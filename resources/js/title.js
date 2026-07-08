document.addEventListener('DOMContentLoaded', () => {
    const titleResumeBtn = document.getElementById('title-resume-btn');
    const loadModal = document.getElementById('load-modal');
    const loadModalCloseBtn = document.getElementById('load-modal-close-btn');

    if(titleResumeBtn && loadModal){
        titleResumeBtn.addEventListener('click', (e) => {
            e.preventDefault()
            loadModal.classList.add('is-open');
        });
    }

    if(loadModalCloseBtn && loadModal){
        loadModalCloseBtn.addEventListener('click', () => {
            loadModal.classList.remove('is-open');
        });
    }

    const loadSlotButtons = document.querySelectorAll('.load-slot-btn');
    loadSlotButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const slotNumber = button.getAttribute('data-slot');
            if(!slotNumber) return;

            loadSlotButtons.forEach(btn => {
                btn.disabled = true;
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
                    throw new Error('データの読み込みに失敗しました。');
                }

                const data = await response.json();
                if(data.success && data.save){
                    localStorage.setItem('title_load_data', JSON.stringify(data.save));
                    window.location.href = '/game';
                }else{
                    alert('セーブデータが見つかりません。');
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
            }catch(error){
                console.error('Title Load Error:', error);
                alert('ロードに失敗しました。');
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
        })
    })

    const titleNewGameBtn = document.getElementById('title-new-game-btn');
    const menuContainer = document.querySelector('.menu-container');
    if(titleNewGameBtn && menuContainer){
        titleNewGameBtn.addEventListener('click', async (e) => {
            e.preventDefault();

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const initialSaveData = {
                slot: 0,
                scene_id: 1,
                step_order: 1,
                energy: 10,
                alignment: 0,
                affection: 0
            };

            menuContainer.style.pointerEvents = 'none';
            menuContainer.style.opacity = '0.5';
            menuContainer.style.cursor = 'not-allowed';

            try{
                const response = await fetch('/game/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(initialSaveData)
                });
                if(!response.ok){
                    throw new Error('初期データの作成に失敗しました。');
                }
                const data = await response.json();
                if(data.success){
                    window.location.href = '/game';
                }else{
                    alert('ゲームの初期化に失敗しました。');
                    menuContainer.style.pointerEvents = 'auto';
                    menuContainer.style.opacity = '1';
                    menuContainer.style.cursor = 'default';
                }
            }catch(error){
                console.error('New Game Error:', error);
                alert('新しくゲームを始めることができませんでした。');
                menuContainer.style.pointerEvents = 'auto';
                menuContainer.style.opacity = '1';
                menuContainer.style.cursor = 'default';
            }
        });
    }

    const gameContainer = document.querySelector('.game-container');
    if(gameContainer){
        gameContainer.addEventListener('click', (e) => {
            const target = e.target.closest('a, button');
            if(!target) return;
            if(target.id === 'load-modal-close-btn' || target.id === 'title-resume-btn') return;
            gameContainer.style.pointerEvents = 'none';
            gameContainer.style.opacity = '0.5';
        });

        window.addEventListener('submit', (e) => {
            if(e.defaultPrevented){
                gameContainer.style.pointerEvents = 'auto';
                gameContainer.style.opacity = '1';
            }
        }, false);

        window.addEventListener('pageshow', (e) => {
            if(e.persisted || (window.performance && window.performance.navigation.type === 2)){
                gameContainer.style.pointerEvents = 'auto';
                gameContainer.style.opacity = '1';
            }
        });
    }
})
