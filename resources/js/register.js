document.addEventListener('DOMContentLoaded', () => {
    const gameContainer = document.querySelector('.game-container');
    if(gameContainer){
        gameContainer.addEventListener('click', (e) => {
            const target = e.target.closest('a, button');
            if(!target) return;
            gameContainer.style.pointerEvents = 'none';
            gameContainer.style.opacity = '0.5';
        });

        window.addEventListener('invalid', () => {
            gameContainer.style.pointerEvents = 'auto';
            gameContainer.style.opacity = '1';
        }, true);

        window.addEventListener('pageshow', (e) => {
            if(e.persisted || (window.performance && window.performance.navigation.type === 2)){
                gameContainer.style.pointerEvents = 'auto';
                gameContainer.style.opacity = '1';
            }
        });
    }
})
