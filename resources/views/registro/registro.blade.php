<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Registro - Pompita Wear</title>
    <!-- Tus estilos de registro -->
    <link rel="stylesheet" href="{{ asset('css/stylesRegistro.css') }}" />
    <!-- También cargamos styleLogin para heredar estilos de botón -->
    <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #db4437;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .btn-google i {
            margin-right: 8px;
        }
        .divider {
            text-align: center;
            margin: 10px 0;
            color: #999;
        }
    </style>
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

            {{-- Botón registro con Google --}}
            <a href="{{ route('google.redirect') }}" class="btn-google">
                <i class="fab fa-google"></i> Registrarse con Google
            </a>
            <p class="divider">— o —</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <input type="text" name="nombre" placeholder="Nombre completo" value="{{ old('nombre') }}">
                <span class="error">{{ $errors->first('nombre') }}</span>

                <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
                <span class="error">{{ $errors->first('email') }}</span>

                <div class="password-toggle-container">
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <span class="toggle-password" id="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <span class="error">{{ $errors->first('password') }}</span>

                <div class="password-toggle-container">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repetir contraseña" required>
                    <span class="toggle-password" id="toggle-password-confirm">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <span class="error">{{ $errors->first('password_confirmation') }}</span>

                <button type="submit">CREAR USUARIO</button>
            </form>

            <p class="mt-3">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/valiRegistro.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        function setupToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input  = document.getElementById(inputId);
            if (!toggle || !input) return;
            toggle.addEventListener('click', function () {
                const isText = input.type === 'text';
                input.type  = isText ? 'password' : 'text';
                this.innerHTML = isText
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        }
        setupToggle('toggle-password', 'password');
        setupToggle('toggle-password-confirm', 'password_confirmation');
    });
    </script>
</body>
</html>
