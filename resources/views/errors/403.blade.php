<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Error 403</title>
  <style>
    body { margin:0; overflow:hidden; background:#222; }
    canvas { display:block; }
    .message {
      position:absolute; top:20px; width:100%; text-align:center;
      font-family:Ubuntu, sans-serif; color:#eee;
    }
  </style>
</head>
<body>
  <div class="message">
    <h1>403 — ¡Acceso Prohibido!</h1>
    <p>Pulsa ESPACIO para comenzar a jugar como Batman</p>
  </div>
  <canvas id="game"></canvas>
  <!-- Incluye el script al final -->
  <script src="{{ asset('js/forbidden-game.js') }}"></script>
</body>
</html>
