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

            {{-- Botón inicio con Google --}}
            <a href="{{ route('google.redirect') }}" class="btn-google">
                <i class="fab fa-google"></i> Iniciar sesión con Google
            </a>
            <p class="divider">— o —</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="email" name="email" placeholder="Correo electrónico" />
                <p id="email-error" style="color: red; font-size: 12px;"></p>

                <div class="password-toggle-container">
                    <input type="password" name="password" id="password" placeholder="Contraseña" />
                    <span class="toggle-password" id="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <p id="password-error" style="color: red; font-size: 12px;"></p>

                @if ($errors->any())
                    <div style="color: red; font-size: 14px; margin-bottom: 10px; text-align:center">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div style="color: green; font-size: 14px; margin-bottom: 10px; text-align:center">
                        {{ session('success') }}
                    </div>
                @endif

                <button type="submit">Iniciar Sesión</button>
            </form>

            @if (session('reactivar'))
                <form action="{{ route('reactivar.cuenta') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" name="id_usuario" value="{{ session('reactivar') }}">
                    <button type="submit" class="reactivar-btn">Reactivar Cuenta</button>
                </form>
            @endif

            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>

    <script src="{{ asset('js/valiLogin.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput  = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                const isText = passwordInput.type === 'text';
                passwordInput.type = isText ? 'password' : 'text';
                this.innerHTML = isText
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        });
    </script>
</body>
</html>
