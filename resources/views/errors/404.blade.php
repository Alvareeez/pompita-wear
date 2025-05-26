<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Error 404</title>

  <!-- Google Fonts: Ubuntu -->
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">

  <style>
    /* Ubuntu en todo */
    body, .title-banner, .instructions {
      font-family: 'Ubuntu', sans-serif;
    }

    body {
      margin: 0;
      overflow: hidden;
      background: #000;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      color: #eee;
      position: relative;
    }

    /* Título 404 FUERA de la tele */
    .title-banner {
      margin-bottom: 20px;
      text-align: center;
      z-index: 10;
    }

    .tv-frame {
      position: relative;
      width: 80vw;
      max-width: 800px;
      aspect-ratio: 16/9;
      background: #000;
      border: 20px solid #333;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0,0,0,0.8);
      overflow: hidden;
    }

    .tv-frame .background-gif {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: url('/img/juego/Gotham.gif') no-repeat center center;
      background-size: cover;
      z-index: 0;
    }

    .tv-frame canvas {
      position: relative;
      width: 100%;
      height: 100%;
      z-index: 1;
      display: block;
    }

    /* Instrucciones ABAJO de la tele */
    .instructions {
      margin-top: 20px;
      text-align: center;
      z-index: 5;
    }
  </style>
</head>
<body>

  <!-- Título 404: fuera de la tele -->
  <div class="title-banner">
    <h1>404 — ¡NO INTENTES BUSCAR!</h1>
  </div>

  <!-- Televisor con GIF y canvas -->
  <div class="tv-frame">
    <div class="background-gif"></div>
    <canvas id="game"></canvas>
  </div>

  <!-- Instrucciones: fuera y debajo -->
  <div class="instructions">
    <p>Pulsa ESPACIO para comenzar a jugar como Batman</p>
  </div>

  <script src="{{ asset('js/forbidden-game.js') }}"></script>
</body>
</html>
