{{-- resources/views/emails/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>¡Bienvenido a Pompita Wear!</title>
  <style>
    /* Reset básico */
    body, table, td, a { margin:0; padding:0; font-family: 'Ubuntu', sans-serif; }
    body { background-color:#f2f4f6; }

    .wrapper {
      width:100%;
      background-color:#f2f4f6;
      padding:20px 0;
    }
    .content {
      max-width:600px;
      margin:0 auto;
      background:#ffffff;
      border-radius:8px;
      overflow:hidden;
      box-shadow:0 2px 4px rgba(0,0,0,0.1);
    }

    /* Cabecera */
    .header {
      background-color:#002D68;
      text-align:center;
      padding:20px;
    }
    .header h1 {
      color:#ffffff;
      font-size:24px;
      margin:0;
      font-weight:700;
    }

    /* Cuerpo */
    .body {
      padding:30px;
      color:#555555;
      line-height:1.5;
    }
    .body h2 {
      font-size:20px;
      color:#333333;
      margin-bottom:16px;
    }
    .body p {
      font-size:16px;
      margin-bottom:20px;
    }
    .btn {
      display:inline-block;
      background-color:#F6A894;
      color:#000000 !important;
      text-decoration:none;
      padding:12px 24px;
      border-radius:4px;
      font-weight:500;
    }

    /* Pie */
    .footer {
      background-color:#f2f4f6;
      text-align:center;
      padding:15px;
      font-size:12px;
      color:#888888;
    }
    .footer a {
      color:#002D68;
      text-decoration:none;
      font-weight:500;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="content">

      {{-- Cabecera con texto --}}
      <div class="header">
        <h1>Pompita Wear</h1>
      </div>

      {{-- Cuerpo --}}
      <div class="body">
        <h2>¡Bienvenido, {{ $usuario->nombre }}!</h2>
        <p>Gracias por registrarte en <strong>Pompita Wear</strong>. Ya puedes empezar a explorar y crear tus outfits favoritos.</p>
        <p style="text-align:center;">
          <a href="{{ route('home') }}" class="btn">Ir a la aplicación</a>
        </p>
        <p>¡Disfruta!<br>
        <strong>El equipo de Pompita Wear</strong></p>
      </div>

    </div>

    {{-- Pie de página --}}
    <div class="footer">
      <p>Pompita Wear &bull; <a href="https://g07.daw2j23.es/">g07.daw2j23.es</a></p>
      <p>© {{ date('Y') }} Pompita Wear. Todos los derechos reservados.</p>
    </div>
  </div>
</body>
</html>
