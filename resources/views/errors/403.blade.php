<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Error 403</title>
  <style>
    body {
      margin: 0;
      overflow: hidden;
      background: #222;
    }

    /* Fondo GIF */
    .background-gif {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: url('/img/juego/Gotham.gif') no-repeat center center;
      background-size: cover;
      z-index: -2; /* Detrás de todo */
    }

    /* Overlay oscuro opcional para mejorar visibilidad */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.5); /* Oscurece el fondo */
      z-index: -1;
    }

    canvas {
      display: block;
      position: relative;
      z-index: 1;
    }

    .message {
      position: absolute;
      top: 20px;
      width: 100%;
      text-align: center;
      font-family: Ubuntu, sans-serif;
      color: #eee;
      z-index: 2;
    }
  </style>
</head>
<body>

  <!-- Fondo GIF -->
  <div class="background-gif"></div>

  <!-- Overlay opcional -->
  <div class="overlay"></div>

  <!-- Mensaje inicial -->
  <div class="message">
    <h1>403 — ¡Acceso Prohibido!</h1>
    <p>Pulsa ESPACIO para comenzar a jugar como Batman</p>
  </div>

  <!-- Canvas del juego -->
  <canvas id="game"></canvas>

  <!-- Script del juego -->
  <script src="{{ asset('js/forbidden-game.js') }}"></script>
</body>
</html>