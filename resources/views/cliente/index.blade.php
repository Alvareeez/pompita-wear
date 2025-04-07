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
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white">Cerrar sesión</button>
                </form>            
                @else
                <a href="/login">Login</a>
                <a href="/registro">Registrar</a>
            @endif
        </nav>
    </header>

</body>
</html>