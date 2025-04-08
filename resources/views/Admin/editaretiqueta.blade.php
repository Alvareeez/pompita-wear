<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Etiqueta</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="{{ route('admin.etiquetas.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Editar Etiqueta</h2>
            <form action="{{ route('admin.etiquetas.update', $etiqueta->id_etiqueta) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre de la Etiqueta</label>
                    <input type="text" id="nombre" name="nombre" value="{{ $etiqueta->nombre }}" required>
                </div>
                <button type="submit"><span>Actualizar Etiqueta</span></button>
            </form>
        </div>
    </main>
</body>
</html>