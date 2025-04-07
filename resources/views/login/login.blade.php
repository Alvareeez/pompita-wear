<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Logo" class="logo" />
        </div>

        <div class="form-container">
            <div class="title-container">
                <h2>Iniciar Sesión</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="email" placeholder="Correo electrónico" required />
                <p id="email-error" style="color: red; font-size: 12px;"></p> <!-- Error debajo del email -->

                <input type="password" name="password" placeholder="Contraseña" required />
                <p id="password-error" style="color: red; font-size: 12px;"></p> <!-- Error debajo de la contraseña -->

                <button type="submit">Iniciar Sesión</button>
            </form>

            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>
    <script src="{{ asset('js/valiLogin.js') }}"></script>
</body>
</html>
