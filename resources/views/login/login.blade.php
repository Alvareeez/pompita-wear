<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

                <div class="password-toggle-container">
                    <input type="password" name="password" id="password" placeholder="Contraseña" required />
                    <span class="toggle-password" id="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <p id="password-error" style="color: red; font-size: 12px;"></p> <!-- Error debajo de la contraseña -->

                @if ($errors->any())
                <div style="color: red; font-size: 14px; margin-bottom: 10px; text-align:center">
                    {{ $errors->first() }}
                </div>
                @endif

                <button type="submit">Iniciar Sesión</button>
            </form>

            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>
    <script src="{{ asset('js/valiLogin.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            this.innerHTML = isPasswordVisible
                ? '<i class="fas fa-eye"></i>' // Ícono de ojo cerrado
                : '<i class="fas fa-eye-slash"></i>'; // Ícono de ojo abierto
        });
    });
</script>
</body>
</html>
