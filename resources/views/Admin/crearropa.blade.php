<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Prenda - Pompita Wear</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="{{ route('admin.ropa.index') }}">Volver</a>
            <a href="/logout">Cerrar sesión</a>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Crear Prenda</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.ropa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" placeholder="Descripción de la prenda" required>
                </div>
                <div class="form-group">
                    <label for="id_tipoPrenda">Tipo de Prenda</label>
                    <select id="id_tipoPrenda" name="id_tipoPrenda" required>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipoPrenda }}">{{ $tipo->tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€)</label>
                    <input type="number" id="precio" name="precio" placeholder="Precio de la prenda" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="img_frontal">Imagen Frontal</label>
                    <input type="file" id="img_frontal" name="img_frontal" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="img_trasera">Imagen Trasera</label>
                    <input type="file" id="img_trasera" name="img_trasera" accept="image/*" required>
                </div>
                <button type="submit"><span>Crear Prenda</span></button>
            </form>
        </div>
    </main>
</body>
</html>