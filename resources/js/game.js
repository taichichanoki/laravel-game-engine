let currentSteps = [];
let currentChoices = [];
let currentStepIndex = 0;
let bgmAudio = null;
let seAudio = null;
let currentSceneId = 1;
let currentEnergy = 10;
let currentAlignment = 0;
let currentAffection = 0;
let pendingBgmPath = null;

document.addEventListener('DOMContentLoaded', async () => {
    const startAudioContext = () => {
        if(pendingBgmPath && (!bgmAudio || bgmAudio.paused)) {
            playBgm(pendingBgmPath);
        }
        document.removeEventListener('click', startAudioContext);
    };
    document.addEventListener('click', startAudioContext);

    const titleLoadDataStr = localStorage.getItem('title_load_data');
    if(titleLoadDataStr){
        try{
            const save = JSON.parse(titleLoadDataStr);

            currentSceneId = save.scene_id;
            currentStepIndex = save.step_order - 1;
            currentEnergy = save.energy;
            currentAlignment = save.alignment;
            currentAffection = save.affection;

            localStorage.removeItem('title_load_data');

            await loadScene(currentSceneId, false);

        }catch(error){
            console.error('Title Data Restore Error:', error);

            const hasAutosave = await checkAndLoadAutosave();
            if(!hasAutosave) await loadScene(1);
        }
    }else{
        const hasAutosave = await checkAndLoadAutosave();
        if(!hasAutosave) await loadScene(1);
    }

    const gameBox = document.getElementById('game-box');
    gameBox.addEventListener('click', (e) => {
        if(e.target.classList.contains('choice-btn')){
            return;
        }
        nextStep();
    });

    const menuToggleBtn = document.getElementById('menu-toggle-btn');
    const menuSaveBtn = document.getElementById('menu-save-btn');
    const saveModal = document.getElementById('save-modal');
    const saveModalCloseBtn = document.getElementById('save-modal-close-btn');
    if(menuSaveBtn && saveModal){
        menuSaveBtn.addEventListener('click', () => {
            saveModal.classList.add('is-open');
            if(menuToggleBtn){
                menuToggleBtn.style.display = 'none';
            }
        });
    }

    if(saveModalCloseBtn && saveModal){
        saveModalCloseBtn.addEventListener('click', () => {
            saveModal.classList.remove('is-open');
            if(menuToggleBtn){
                menuToggleBtn.style.display = 'flex';
            }
        });
    }

    const menuLoadBtn = document.getElementById('menu-load-btn');
    const loadModal = document.getElementById('load-modal');
    const loadModalCloseBtn = document.getElementById('load-modal-close-btn');
    if(menuLoadBtn && loadModal){
        menuLoadBtn.addEventListener('click', () => {
            loadModal.classList.add('is-open');
            if(menuToggleBtn) menuToggleBtn.style.display = 'none';
        });
    }

    if(loadModalCloseBtn && loadModal){
        loadModalCloseBtn.addEventListener('click', () => {
            loadModal.classList.remove('is-open');
            if(menuToggleBtn) menuToggleBtn.style.display = 'flex';
        });
    }

    const slotButtons = document.querySelectorAll('.slot-btn:not(.load-slot-btn)');
    slotButtons.forEach(button => {
        button.addEventListener('click', () => {
            const slotNumber = button.getAttribute('data-slot');
            if(slotNumber){
                executeSave(parseInt(slotNumber));
            }
        });
    });

    const loadSlotButtons = document.querySelectorAll('.load-slot-btn');
    loadSlotButtons.forEach(button => {
        button.addEventListener('click', () => {
            const slotNumber = button.getAttribute('data-slot');
            if(slotNumber){
                executeLoad(parseInt(slotNumber));
            }
        });
    });

    document.body.addEventListener('click', (e) => {
        const target = e.target.closest('a');
        const gameMenu = document.getElementById('game-menu');
        if(target){
            setTimeout(() => {
                gameMenu.classList.remove('is-open');
                document.body.style.pointerEvents = 'none';
                document.body.style.opacity = '0.5';
            }, 0);
        }
    });
});

async function checkAndLoadAutosave(){
    try{
        const response = await fetch('/game/load/0');
        if(!response.ok) return false;

        const data = await response.json();
        if(data.success && data.save){
            currentSceneId = data.save.scene_id;
            currentStepIndex = data.save.step_order - 1;
            currentEnergy = data.save.energy;
            currentAlignment = data.save.alignment;
            currentAffection = data.save.affection;

            await loadScene(currentSceneId, false);
            return true;
        }
    }catch(error){
        console.error('Autosave Load Error', error);
    }
    return false;
}

async function loadScene(sceneId, triggerAutosave = true){
    const gameBox = document.getElementById('game-box');
    const storyTextDiv = document.getElementById('story-text');
    const choicesContainer = document.getElementById('choices-container');

    gameBox.classList.add('loading');
    storyTextDiv.style.opacity = 0;
    choicesContainer.innerHTML = '';

    try{
        const response = await fetch(`/api/scenes/${sceneId}`);

        if(!response.ok){
            throw new Error('ネットワークエラー、またはシーンデータが見つかりません');
        }

        const data = await response.json();
        currentSceneId = sceneId;
        currentSteps = data.steps || [];
        currentChoices = data.choices || [];

        if(triggerAutosave){
            currentStepIndex = 0;
        }

        displayStep();

        if(triggerAutosave){
            executeAutosave();
        }

    }catch(error){
        console.error('Error:', error);
        storyTextDiv.innerText = "深い霧に包まれ、この物語はここで終わっている...（通信エラーが発生しました）";
        storyTextDiv.style.opacity = 1;
    }finally{
        gameBox.classList.remove('loading');
    }
}

function playBgm(nextBgmPath){
    if(!bgmAudio || bgmAudio.src !== window.location.origin + nextBgmPath){
        if(bgmAudio) bgmAudio.pause();
        bgmAudio = new Audio(nextBgmPath);
        bgmAudio.loop = true;
    }

    bgmAudio.play().catch(e => {
        console.log("BGMの自動再生がブラウザにブロックされました。クリックを待ちます。");
        pendingBgmPath = nextBgmPath;
    });
}

function displayStep(){
    const storyTextDiv = document.getElementById('story-text');
    const choicesContainer = document.getElementById('choices-container');

    if(currentSteps.length === 0){
        storyTextDiv.innerText = "物語が途切れている...";
        storyTextDiv.style.opacity = 1;
        createResetButton(choicesContainer);
        return;
    }

    const step = currentSteps[currentStepIndex];

    storyTextDiv.style.transition = 'none';
    storyTextDiv.style.opacity = 0;

    setTimeout(() => {
        storyTextDiv.innerText = step.text;
        storyTextDiv.style.transition = 'opacity 0.5s ease';
        storyTextDiv.style.opacity = 1;
    }, 50);

    if(step.bg_image){
        const nextBgUrl = `url("/images/${step.bg_image}")`;
        if(document.body.style.backgroundImage !== nextBgUrl){
            document.body.style.backgroundImage = nextBgUrl;
        }
    }

    if(step.se){
        if(seAudio) seAudio.pause();
        seAudio = new Audio(`/ses/${step.se}`);
        seAudio.play().catch(e => console.log("オーディオ再生エラー:", e));
    }

    if(step.bgm){
        playBgm(`/bgms/${step.bgm}`);
    }else{
        if(bgmAudio){
            bgmAudio.pause();
            bgmAudio.currentTime = 0;
        }
        pendingBgmPath = null;
    }

    if(currentStepIndex === currentSteps.length - 1){
        showChoices();
    }else{
        choicesContainer.innerHTML = '';
    }
}

function nextStep(){
    if(currentStepIndex >= currentSteps.length - 1){
        return;
    }

    currentStepIndex++;
    displayStep();

    executeAutosave();
}

function showChoices(){
    const choicesContainer = document.getElementById('choices-container');
    choicesContainer.innerHTML = '';

    if(currentChoices && currentChoices.length > 0){
            currentChoices.forEach(choice => {

                if(choice.min_energy_required !== undefined && currentEnergy < choice.min_energy_required){
                    return;
                }
                if(choice.min_alignment_required != null && currentAlignment < choice.min_alignment_required){
                    return;
                }
                if(choice.max_alignment_required != null && currentAlignment > choice.max_alignment_required){
                    return;
                }
                if(choice.min_affection_required !== undefined && currentAffection < choice.min_affection_required){
                    return;
                }

                const button = document.createElement('button');
                button.classList.add('choice-btn');
                button.innerText = choice.text;

                button.addEventListener('click', () => {
                    if(choice.energy_change !== undefined){
                        currentEnergy += parseInt(choice.energy_change);
                    }
                    if(choice.alignment_change !== undefined){
                        currentAlignment += parseInt(choice.alignment_change);
                    }
                    if(choice.affection_change !== undefined){
                        currentAffection += parseInt(choice.affection_change);
                    }

                    if(currentEnergy < 0){
                        currentEnergy = 0;
                    }
                    if(currentAlignment < 0){
                        currentAlignment = 0;
                    }
                    if(currentAffection < 0){
                        currentAffection = 0;
                    }

                    const nextId = choice.next_scene_id;
                    loadScene(nextId);
                });

                choicesContainer.appendChild(button);
            });

            if(choicesContainer.innerHTML === ''){
                createResetButton(choicesContainer);
            }
        }else{
            createResetButton(choicesContainer);
        }
}

function createResetButton(container){
    const endText = document.createElement('div');
    endText.style.textAlign = 'center';
    endText.style.marginTop = '20px';

    const resetButton = document.createElement('button');
    resetButton.classList.add('choice-btn');
    resetButton.innerText = '最初からやり直す';
    resetButton.addEventListener('click', () => {
        if(bgmAudio) bgmAudio.pause();
        loadScene(1);
    });

    endText.appendChild(resetButton);
    container.appendChild(endText);
}

async function executeAutosave(){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const currentStepOrder = currentStepIndex + 1;

    const saveData = {
        slot: 0,
        scene_id: currentSceneId,
        step_order: currentStepOrder,
        energy: currentEnergy,
        alignment: currentAlignment,
        affection: currentAffection
    };

    try{
        const response = await fetch('/game/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(saveData)
        });

        if(response.ok){
            const data = await response.json();
            if(data.success){
                const autoSaveButton = document.getElementById('load-slot-0');
                if(autoSaveButton){
                    autoSaveButton.classList.remove('empty-slot');
                    const dateSpan = autoSaveButton.querySelector('.slot-date');
                    if(dateSpan){
                        dateSpan.innerText = data.updated_at;
                        dateSpan.classList.remove('no-slot-date');
                    }
                }
            }
        }
    }catch(error){
        console.error('Autosave Silent Error:', error);
    }
}

async function executeSave(slotNumber){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const currentStepOrder = currentStepIndex + 1;

    const slotButtons = document.querySelectorAll('.slot-btn');
    const saveModalCloseBtn = document.getElementById('save-modal-close-btn');
    slotButtons.forEach(btn => {
        btn.disabled = true;
        btn.style.opacity = '0.5';
        btn.style.cursor = 'not-allowed';
    });
    if(saveModalCloseBtn){
        saveModalCloseBtn.disabled = true;
        saveModalCloseBtn.style.opacity = '0.5';
        saveModalCloseBtn.style.cursor = 'not-allowed';
    }

    const saveData = {
        slot: slotNumber,
        scene_id: currentSceneId,
        step_order: currentStepOrder,
        energy: currentEnergy,
        alignment: currentAlignment,
        affection: currentAffection
    };

    try{
        const response = await fetch('/game/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(saveData)
        });
        if(!response.ok){
            throw new Error('セーブデータの送信に失敗しました。');
        }
        const data = await response.json();

        if(data.success){
            const slotButton = document.getElementById(`slot-${slotNumber}`);
            if(slotButton){
                slotButton.classList.remove('empty-slot');

                const dateSpan = slotButton.querySelector('.slot-date')

                if(dateSpan){
                    dateSpan.innerText = data.updated_at;
                    dateSpan.classList.remove('no-slot-date', 'no-click');
                }
            }

            const loadSlotButton = document.getElementById(`load-slot-${slotNumber}`);
            if(loadSlotButton){
                loadSlotButton.classList.remove('empty-slot');

                const loadDateSpan = loadSlotButton.querySelector('.slot-date')

                if(loadDateSpan){
                    loadDateSpan.innerText = data.updated_at;
                    loadDateSpan.classList.remove('no-slot-date');
                }
            }

            alert(`データ${slotNumber}にセーブしました。`);
        }else{
            alert('セーブに失敗しました。');
        }
    }catch(error){
        console.error('Save Error:', error);
        alert('通信エラーが発生したため、セーブできませんでした。');
    }finally{
        slotButtons.forEach(btn => {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        });
        if(saveModalCloseBtn){
        saveModalCloseBtn.disabled = false;
        saveModalCloseBtn.style.opacity = '1';
        saveModalCloseBtn.style.cursor = 'pointer';
        }
    }
}

async function executeLoad(slotNumber){
    const loadSlotButtons = document.querySelectorAll('.load-slot-btn');
    const loadModalCloseBtn = document.getElementById('load-modal-close-btn');
    const menuToggleBtn = document.getElementById('menu-toggle-btn');
    const loadModal = document.getElementById('load-modal');

    loadSlotButtons.forEach(btn => {
        btn.disabled =true;
        btn.style.opacity = '0.5';
        btn.style.cursor = 'not-allowed';
    });
    if(loadModalCloseBtn){
        loadModalCloseBtn.disabled = true;
        loadModalCloseBtn.style.opacity = '0.5';
        loadModalCloseBtn.style.cursor = 'not-allowed';
    }

    try{
        const response = await fetch(`/game/load/${slotNumber}`);
        if(!response.ok){
            throw new Error('セーブデータが見つからないか、読み込みに失敗しました。');
        }

        const data = await response.json();
        if(data.success && data.save){
            currentSceneId = data.save.scene_id;
            currentStepIndex = data.save.step_order - 1;
            currentEnergy = data.save.energy;
            currentAlignment = data.save.alignment;
            currentAffection = data.save.affection;

            await loadScene(currentSceneId, false);

            const gameMenu = document.getElementById('game-menu')
            if(loadModal) loadModal.classList.remove('is-open');
            if(gameMenu) gameMenu.classList.remove('is-open');
            if(menuToggleBtn) menuToggleBtn.style.display = 'flex';
        }else{
            alert('セーブデータが見つかりません。');
        }
    }catch(error){
        console.error('Load Error:', error);
        alert('ロードに失敗しました。データが存在しない可能性があります。');
    }finally{
        loadSlotButtons.forEach(btn => {
        btn.disabled =false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
        });
        if(loadModalCloseBtn){
            loadModalCloseBtn.disabled = false;
            loadModalCloseBtn.style.opacity = '1';
            loadModalCloseBtn.style.cursor = 'pointer';
        }
    }
}
