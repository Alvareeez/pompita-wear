{{-- filepath: c:\wamp64\www\M12\pompita-wear\resources\views\cliente\index.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pompita Wear - Inicio</title>
    <link rel="stylesheet" href="{{ asset('css/stylesIndex.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Fira Mono', monospace;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .card {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e7e7e7;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        height: 50px;
        width: 300px;
    }

    .card::before,
    .card::after {
        position: absolute;
        display: flex;
        align-items: center;
        width: 50%;
        height: 100%;
        transition: 0.25s linear;
        z-index: 1;
    }

    .card::before {
        content: "";
        left: 0;
        justify-content: flex-end;
        background-color: #4d60b6;
    }

    .card::after {
        content: "";
        right: 0;
        justify-content: flex-start;
        background-color: #4453a6;
    }

    .card:hover {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .card:hover span {
        opacity: 0;
        z-index: -3;
    }

    .card:hover::before {
        opacity: 0.5;
        transform: translateY(-100%);
    }

    .card:hover::after {
        opacity: 0.5;
        transform: translateY(100%);
    }

    .card span {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: whitesmoke;
        font-size: 24px;
        font-weight: 700;
        opacity: 1;
        transition: opacity 0.25s;
        z-index: 2;
    }

    .card .social-link {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 25%;
        height: 100%;
        color: whitesmoke;
        font-size: 24px;
        text-decoration: none;
        transition: 0.25s;
    }

    .card .social-link svg {
        text-shadow: 1px 1px rgba(31, 74, 121, 0.7);
        transform: scale(1);
    }

    .card .social-link:hover {
        background-color: rgba(249, 244, 255, 0.774);
        animation: bounce_613 0.4s linear;
    }

    @keyframes bounce_613 {
        40% {
            transform: scale(1.4);
        }

        60% {
            transform: scale(0.8);
        }

        80% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
</style>
</head>

</html>
<body>
    <header class="main-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            @if (Auth::check())
                <a href="/">Inicio</a>
                @if (Auth::user()->rol && Auth::user()->rol->nombre === 'admin')
                    <a href="{{ route('admin.usuarios.index') }}">Admin</a>
                @endif
                <a href="/logout">Cerrar sesión</a>
            @else
                <a href="/login">Login</a>
                <a href="/registro">Registrar</a>
            @endif
        </nav>
    </header>
    <div class="card">
        <span>Social</span>
        <a class="social-link" href="https://facebook.com/pompitawear" target="_blank">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/facebook.png" alt="Facebook">
        </a>
        <a class="social-link" href="https://twitter.com/pompitawear" target="_blank">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/twitter.png" alt="Twitter">
        </a>
        <a class="social-link" href="https://instagram.com/pompitawear" target="_blank">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png" alt="Instagram">
        </a>
        <a class="social-link" href="https://youtube.com/pompitawear" target="_blank">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/youtube.png" alt="YouTube">
        </a>
    </div>
</body>
</html>