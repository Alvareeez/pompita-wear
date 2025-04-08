<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prenda - Pompita Wear</title>
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
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Editar Prenda</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.ropa.update', $prenda->id_prenda) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" value="{{ $prenda->descripcion }}" placeholder="Descripción de la prenda" >
                </div>
                <div class="form-group">
                    <label for="id_tipoPrenda">Tipo de Prenda</label>
                    <select id="id_tipoPrenda" name="id_tipoPrenda" >
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipoPrenda }}" {{ $prenda->id_tipoPrenda == $tipo->id_tipoPrenda ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€)</label>
                    <input type="number" id="precio" name="precio" value="{{ $prenda->precio }}" placeholder="Precio de la prenda" step="0.01" >
                </div>
                <div class="form-group">
                    <label for="estilos">Estilos</label>
                    <select id="estilos" name="estilos[]" multiple>
                        @foreach ($estilos as $estilo)
                            <option value="{{ $estilo->id_estilo }}" {{ $prenda->estilos->contains($estilo->id_estilo) ? 'selected' : '' }}>
                                {{ $estilo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="etiquetas">Etiquetas</label>
                    <select id="etiquetas" name="etiquetas[]" multiple>
                        @foreach ($etiquetas as $etiqueta)
                            <option value="{{ $etiqueta->id_etiqueta }}" {{ $prenda->etiquetas->contains($etiqueta->id_etiqueta) ? 'selected' : '' }}>
                                {{ $etiqueta->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="colores">Colores</label>
                    <select id="colores" name="colores[]" multiple>
                        @foreach ($colores as $color)
                            <option value="{{ $color->id_color }}" {{ $prenda->colores->contains($color->id_color) ? 'selected' : '' }}>
                                {{ $color->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="img_frontal">Imagen Frontal (opcional)</label>
                    <input type="file" id="img_frontal" name="img_frontal" accept="image/*">
                    <img src="{{ asset($prenda->img_frontal) }}" alt="Imagen Frontal Actual" style="width: 100px; height: auto; margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label for="img_trasera">Imagen Trasera (opcional)</label>
                    <input type="file" id="img_trasera" name="img_trasera" accept="image/*">
                    <img src="{{ asset($prenda->img_trasera) }}" alt="Imagen Trasera Actual" style="width: 100px; height: auto; margin-top: 10px;">
                </div>
                <button type="submit"><span>Actualizar Prenda</span></button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/validacionropa.js') }}"></script>
</body>
</html>