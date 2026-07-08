document.addEventListener('DOMContentLoaded', () => {
    const menuToggleBtn = document.getElementById('menu-toggle-btn');
    const menuCloseBtn = document.getElementById('menu-close-btn');
    const gameMenu = document.getElementById('game-menu');

    menuToggleBtn.addEventListener('click', () => {
        gameMenu.classList.toggle('is-open');
    });

    menuCloseBtn.addEventListener('click', () => {
        gameMenu.classList.remove('is-open');
    });

    gameMenu.addEventListener('click', (e) => {
        if(e.target === gameMenu){
            gameMenu.classList.remove('is-open');
        }
    });
})
