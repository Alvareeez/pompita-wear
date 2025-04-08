{{-- filepath: c:\wamp64\www\M12\pompita-wear\resources\views\Admin\crearestilo.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estilo</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="{{ route('admin.estilos.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>
    <main class="admin-container">
        <div class="form-container">
            <h2>Crear Estilo</h2>
            <form action="{{ route('admin.estilos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre del Estilo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre del Estilo" required>
                </div>
                <button type="submit"><span>Crear Estilo</span></button>
            </form>
        </div>
    </main>
</body>
</html>