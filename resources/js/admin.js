document.addEventListener('DOMContentLoaded', () => {
    const adminBody = document.body;
    if(adminBody){
        adminBody.addEventListener('click', (e) => {
            const target = e.target.closest('a, button');
            if(target && !target.classList.contains('js-skip')){
                adminBody.style.pointerEvents = 'none';
                adminBody.style.opacity = '0.5';
            }
        });

        window.addEventListener('submit', (e) => {
            if(e.defaultPrevented){
                adminBody.style.pointerEvents = 'auto';
                adminBody.style.opacity = '1';
            }
        }, false);

        window.addEventListener('invalid', () => {
            adminBody.style.pointerEvents = 'auto';
            adminBody.style.opacity = '1';
        }, true);

        window.addEventListener('pageshow', (e) => {
            if(e.persisted || (window.performance && window.performance.navigation.type === 2)){
                adminBody.style.pointerEvents = 'auto';
                adminBody.style.opacity = '1';
            }
        });

        const titleText = document.getElementById('title-text');
        const titleInput = document.getElementById('title-input');
        const editBtn = document.getElementById('title-edit-btn');
        const editForm = document.getElementById('title-edit-form');

        if(titleText && titleInput && editBtn && editForm){
            editBtn.addEventListener('click', (e) => {
                const mode = editBtn.getAttribute('data-mode');
                if(mode === 'view'){
                    e.preventDefault();
                    titleText.style.display = 'none';
                    titleInput.style.display = 'inline-block';
                    titleInput.focus();

                    editBtn.textContent = '名前登録';
                    editBtn.setAttribute('data-mode', 'edit');
                }else if(mode === 'edit'){
                    adminBody.style.pointerEvents = 'none';
                    adminBody.style.opacity = '0.5';
                    editForm.submit();
                }
            })
        }
    }
})
