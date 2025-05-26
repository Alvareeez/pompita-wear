const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

// Variables de estado del juego
let W, H;
let assetsLoaded = false;
let gameStarted = false;
let lastFrameTime = 0;
const FPS = 60;
const frameInterval = 1000 / FPS;

// Configuración del sprite sheet
const SPRITE_CONFIG = {
    frameWidth: 165.5,
    frameHeight: 91,
    runFrames: 4,
    jumpFrames: 2,
    fallFrames: 2
};

// Configuración del juego
const FLOOR_Y_RATIO = 0.90;
const ENEMY_WIDTH_RATIO = 0.05;

// Variables del juego 
let FLOOR_Y;
let hero, enemies;
let currentFrame, frameCount, animationSpeed;
let isWalking, isJumping, isFalling;
let frame, speed, playing, score;

// Sprites
const batmanSprite = new Image();
const enemyImg = new Image();

function initGame() {
    // Inicializar dimensiones
    W = canvas.width = window.innerWidth;
    H = canvas.height = window.innerHeight;
    FLOOR_Y = H * FLOOR_Y_RATIO;

    // Configurar tamaño del héroe basado en el sprite
    hero = {
        x: W * 0.1,
        y: FLOOR_Y - SPRITE_CONFIG.frameHeight,
        w: SPRITE_CONFIG.frameWidth,
        h: SPRITE_CONFIG.frameHeight,
        hitbox: {
            x: SPRITE_CONFIG.frameWidth * 0.4,
            y: SPRITE_CONFIG.frameHeight * 0.2,
            w: SPRITE_CONFIG.frameWidth * 0.6,
            h: SPRITE_CONFIG.frameHeight * 0.7
        },
        vy: 0,
        gravity: 0.8,
        jump: -16,
        speedX: W * 0.005
    };

    // Inicializar variables de animación
    currentFrame = 0;
    frameCount = SPRITE_CONFIG.runFrames;
    animationSpeed = 5;
    isWalking = false;
    isJumping = false;
    isFalling = false;

    // Inicializar sistema de juego
    enemies = [];
    frame = 0;
    speed = W * 0.005;
    playing = false;
    score = 0; // Reiniciar puntaje
}

function loadAssets() {
    return new Promise((resolve, reject) => {
        let loadedCount = 0;
        const totalAssets = 2;

        function assetLoaded() {
            loadedCount++;
            if (loadedCount === totalAssets) {
                console.log('Todos los assets cargados');
                console.log(`Sprite sheet dimensions: ${batmanSprite.width}x${batmanSprite.height}`);
                assetsLoaded = true;
                resolve();
            }
        }

        // Cargar sprites con manejo de errores
        batmanSprite.src = '/img/juego/batman-sprites.png';
        batmanSprite.onload = () => {
            console.log('Spritesheet cargado');
            assetLoaded();
        };
        batmanSprite.onerror = () => {
            console.error('Error cargando el spritesheet');
            reject('Error cargando el spritesheet');
        };

        enemyImg.src = '/img/juego/joker.png';
        enemyImg.onload = () => {
            console.log('Imagen del enemigo cargada');
            assetLoaded();
        };
        enemyImg.onerror = () => {
            console.error('Error cargando la imagen del enemigo');
            reject('Error cargando la imagen del enemigo');
        };
    });
}

function spawnEnemy() {
    const enemyWidth = W * ENEMY_WIDTH_RATIO;
    enemies.push({
        x: W + enemyWidth,
        y: FLOOR_Y - enemyWidth,
        w: enemyWidth,
        h: enemyWidth,
        passed: false
    });
}

function update(timestamp) {
    if (!playing) return;

    // Control de FPS
    const deltaTime = timestamp - lastFrameTime;
    if (deltaTime < frameInterval) return;
    lastFrameTime = timestamp - (deltaTime % frameInterval);

    frame++;

    // Física del héroe
    hero.vy += hero.gravity;
    hero.y += hero.vy;

    // Limitar al suelo
    if (hero.y >= FLOOR_Y - hero.h) {
        hero.y = FLOOR_Y - hero.h;
        hero.vy = 0;
        isJumping = false;
        isFalling = false;
    } else {
        isFalling = true;
    }

    // Movimiento horizontal
    if (isWalking) {
        hero.x = Math.min(hero.x + hero.speedX, W * 0.5);
    }

    // Generar enemigos
    if (frame % Math.floor(FPS * 1.5) === 0) {
        spawnEnemy();
    }

    // Mover enemigos y ajustar velocidad según puntaje
    enemies.forEach(e => e.x -= speed * (1 + score * 0.01)); // Aumento progresivo

    // Eliminar enemigos fuera de pantalla
    enemies = enemies.filter(e => e.x + e.w > 0);

    // Detectar si el héroe pasó por encima del enemigo
    const hb = hero.hitbox;
    const hx = hero.x + hb.x;
    const hy = hero.y + hb.y;
    const hw = hb.w;
    const hh = hb.h;

    enemies.forEach((e, index) => {
        // Puntúa solo si pasa por encima y cae detrás
        if (!e.passed && hero.x > e.x + e.w) {
            e.passed = true;
            score += 1;
            return;
        }

        // Colisión normal → Game Over
        if (
            hx < e.x + e.w &&
            hx + hw > e.x &&
            hy < e.y + e.h &&
            hy + hh > e.y
        ) {
            gameOver();
        }
    });

    // Animación
    if (isWalking && !isJumping && !isFalling && frame % animationSpeed === 0) {
        currentFrame = (currentFrame + 1) % frameCount;
    }
}

function drawHero() {
    if (!batmanSprite.complete) {
        // Dibujar placeholder si el sprite no está cargado
        ctx.fillStyle = 'red';
        ctx.fillRect(hero.x, hero.y, hero.w, hero.h);
        return;
    }

    let row = 0; // Por defecto: correr
    if (isJumping) row = 1;
    else if (isFalling) row = 2;

    // Calcular posición en el sprite sheet
    const sx = currentFrame * SPRITE_CONFIG.frameWidth;
    const sy = row * SPRITE_CONFIG.frameHeight;

    // Verificar que no nos salimos del sprite sheet
    if (sx + SPRITE_CONFIG.frameWidth > batmanSprite.width ||
        sy + SPRITE_CONFIG.frameHeight > batmanSprite.height) {
        console.error('Frame fuera de los límites del sprite sheet');
        ctx.fillStyle = 'purple';
        ctx.fillRect(hero.x, hero.y, hero.w, hero.h);
        return;
    }

    // Dibujar el frame correspondiente
    ctx.drawImage(
        batmanSprite,
        sx, sy,
        SPRITE_CONFIG.frameWidth, SPRITE_CONFIG.frameHeight,
        hero.x, hero.y,
        hero.w, hero.h
    );
}

function draw() {
    // Limpiar canvas sin pintar fondo negro
    ctx.clearRect(0, 0, W, H);

    // Suelo
    ctx.strokeStyle = '#444';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(0, FLOOR_Y);
    ctx.lineTo(W, FLOOR_Y);
    ctx.stroke();

    // Dibujar héroe
    drawHero();

    // Dibujar enemigos
    if (enemyImg.complete) {
        enemies.forEach(e => {
            ctx.drawImage(enemyImg, e.x, e.y, e.w, e.h);
        });
    } else {
        enemies.forEach(e => {
            ctx.fillStyle = 'blue';
            ctx.fillRect(e.x, e.y, e.w, e.h);
        });
    }

    // Mostrar puntaje con estilo
    ctx.fillStyle = 'white';
    ctx.font = `${W * 0.04}px "Comic Sans MS", cursive, sans-serif`;
    ctx.textAlign = 'right';
    ctx.shadowColor = 'black';

    ctx.shadowBlur = 5;
    ctx.fillText(`Puntos: ${score}`, W - 30, 50);
    ctx.shadowBlur = 0;

    // UI
    if (!gameStarted) {
        ctx.fillStyle = 'white';
        ctx.font = `${W * 0.04}px Arial`;
        ctx.textAlign = 'center';
        ctx.fillText('Presiona ESPACIO para comenzar', W / 2, H / 2);
    }
}

function gameOver() {
    playing = false;
    ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
    ctx.fillRect(0, 0, W, H);

    ctx.fillStyle = 'red';
    ctx.font = `${W * 0.06}px "Comic Sans MS", cursive, sans-serif`;
    ctx.textAlign = 'center';
    ctx.fillText('GAME OVER', W / 2, H / 2);

    ctx.fillStyle = 'white';
    ctx.font = `${W * 0.03}px Arial`;
    ctx.fillText('Presiona ESPACIO para reiniciar', W / 2, H / 2 + 50);
    ctx.fillText(`Puntuación final: ${score}`, W / 2, H / 2 + 90);
}

function gameLoop(timestamp) {
    update(timestamp);
    draw();
    requestAnimationFrame(gameLoop);
}

// Inicialización del juego
async function init() {
    try {
        initGame();
        await loadAssets();
        gameStarted = true;

        window.addEventListener('resize', () => {
            initGame();
            if (!playing) draw();
        });

        gameLoop(0);
    } catch (error) {
        console.error('Error inicializando el juego:', error);
        ctx.fillStyle = 'white';
        ctx.font = '20px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Error cargando los recursos del juego', W / 2, H / 2);
    }
}

// Controles
window.addEventListener('keydown', (e) => {
    if (e.code === 'Space') {
        if (!playing && assetsLoaded) {
            initGame();
            playing = true;
        }
        if (playing && hero.vy === 0) {
            hero.vy = hero.jump;
            isWalking = false;
            isJumping = true;
            frameCount = SPRITE_CONFIG.jumpFrames;
            currentFrame = 0; // Reiniciar frame
        }
    } else if (e.code === 'ArrowRight') {
        isWalking = true;
        frameCount = SPRITE_CONFIG.runFrames;
        currentFrame = 0; // Reiniciar frame
    }
});

window.addEventListener('keyup', (e) => {
    if (e.code === 'ArrowRight') {
        isWalking = false;
    }
});

// Iniciar el juego
window.addEventListener('load', init);