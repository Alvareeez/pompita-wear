<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pompita Wear</title>
    <link rel="stylesheet" href="{{ asset('css/stylesRegistro.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear" class="logo">
        </div>
        <div class="form-container">
            <div class="title-container">
                <h2>Registro</h2>
            </div>
            <form action="{{ route('register') }}" method="POST">
            @csrf
                <input type="text" name="nombre" placeholder="Nombre Completo">
                <span class="error"></span> <!-- Mensaje de error para nombre -->
                
                <input type="text" name="email" placeholder="Correo">
                <span class="error"></span> <!-- Mensaje de error para email -->

                <input type="password" name="password" placeholder="Contraseña">
                <span class="error"></span> <!-- Mensaje de error para contraseña -->

                <input type="password" name="password_confirmation" placeholder="Repetir contraseña">
                <span class="error"></span> <!-- Mensaje de error para confirmación de contraseña -->

                <!-- Mostrar errores generales antes del formulario -->
                @if ($errors->any())
                    <div style="color: red; font-size: 14px; margin-bottom: 10px; text-align:center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit">CREAR USUARIO</button>
            </form>
            <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión</a></p>
        </div>
    </div>

    <script src="{{ asset('js/valiRegistro.js') }}"></script>
</body>
</html>
