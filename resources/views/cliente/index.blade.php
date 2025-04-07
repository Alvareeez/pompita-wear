<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Pompita Wear</title>
    <link rel="stylesheet" href="{{ asset('css/stylesIndex.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="/">Inicio</a>
            <a href="/logout">Cerrar sesión</a>
            @if (Auth::check() && Auth::user()->rol->nombre === 'admin')
                <a href="{{ route('admin.usuarios.index') }}" class="admin-btn">Admin</a>
            @endif
        </nav>
    </header>

    <main>
        <h1>Bienvenido a Pompita Wear</h1>
        <p>Explora nuestros productos y crea tu estilo único.</p>
    </main>
</body>
</html>