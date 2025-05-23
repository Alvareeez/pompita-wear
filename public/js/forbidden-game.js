// public/js/forbidden-game.js

const canvas = document.getElementById('game');
const ctx    = canvas.getContext('2d');

let W, H;
function resize(){
  W = canvas.width  = innerWidth;
  H = canvas.height = innerHeight;
}
window.addEventListener('resize', resize);
resize();

// Sprites en GIF dentro de /public/img/juego/
const batmanImg = new Image();
batmanImg.src   = '/img/juego/batman.gif';

const enemyImg  = new Image();
enemyImg.src    = '/img/juego/joker.png';

const FLOOR_Y   = H - 80;
let hero = {
  x: 80,
  y: FLOOR_Y - 64,
  w: 64,
  h: 64,
  vy: 0,
  gravity: 0.8,
  jump: -15
};

let enemies = [];
let frame   = 0;
let speed   = 6;
let playing = false;

function spawnEnemy(){
  enemies.push({
    x: W + 50,
    y: FLOOR_Y - 64,
    w: 64,
    h: 64
  });
}

function update(){
  if (!playing) return;

  frame++;
  // gravedad y salto
  hero.vy += hero.gravity;
  hero.y  += hero.vy;
  if (hero.y > FLOOR_Y - hero.h){
    hero.y  = FLOOR_Y - hero.h;
    hero.vy = 0;
  }

  // generar enemigos
  if (frame % 100 === 0) spawnEnemy();

  // mover y limpiar enemigos fuera de pantalla
  enemies.forEach(e => e.x -= speed);
  enemies = enemies.filter(e => e.x + e.w > 0);

  // detección de colisión
  enemies.forEach(e => {
    if (
      hero.x < e.x + e.w &&
      hero.x + hero.w > e.x &&
      hero.y < e.y + e.h &&
      hero.y + hero.h > e.y
    ) {
      playing = false;
    }
  });
}

function draw(){
  // fondo
  ctx.fillStyle = '#111';
  ctx.fillRect(0, 0, W, H);

  // suelo
  ctx.strokeStyle = '#444';
  ctx.beginPath();
  ctx.moveTo(0, FLOOR_Y);
  ctx.lineTo(W, FLOOR_Y);
  ctx.stroke();

  // dibujar a Batman
  ctx.drawImage(batmanImg, hero.x, hero.y, hero.w, hero.h);

  // dibujar enemigos
  enemies.forEach(e => {
    ctx.drawImage(enemyImg, e.x, e.y, e.w, e.h);
  });
}

function loop(){
  update();
  draw();
  requestAnimationFrame(loop);
}
loop();

// controlar con espacio
window.addEventListener('keydown', e => {
  if (e.code === 'Space') {
    if (!playing) {
      // reiniciar partida
      enemies = [];
      frame   = 0;
      speed   = 6;
      playing = true;
      hero.y  = FLOOR_Y - hero.h;
      hero.vy = 0;
    }
    // salto
    if (hero.vy === 0) hero.vy = hero.jump;
  }
});
