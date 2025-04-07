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
                <input type="text" name="nombre" placeholder="Nombre Completo" required>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="password_confirmation" placeholder="Repetir contraseña" required>
                <button type="submit">CREAR USUARIO</button>
            </form>
            <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>