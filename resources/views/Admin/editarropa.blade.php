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
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre de la prenda" name="nombre" id="nombre" value="{{ $prenda->nombre }}" required />
                    <label for="nombre" class="form__label">Nombre</label>
                </div>
                <div class="form__group field">
                    <textarea class="form__field" placeholder="Descripción de la prenda" name="descripcion" id="descripcion" rows="3" required>{{ $prenda->descripcion }}</textarea>
                    <label for="descripcion" class="form__label">Descripción</label>
                </div>
                <div class="form__group field">
                    <select class="form__field" name="id_tipoPrenda" id="id_tipoPrenda" required>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipoPrenda }}" {{ $prenda->id_tipoPrenda == $tipo->id_tipoPrenda ? 'selected' : '' }}>
                                {{ $tipo->tipo }}
                            </option>
                        @endforeach
                    </select>
                    <label for="id_tipoPrenda" class="form__label">Tipo de Prenda</label>
                </div>
                <div class="form__group field">
                    <label for="img_frontal">Imagen Frontal (opcional)</label>
                    <input type="file" id="img_frontal" name="img_frontal" accept="image/*">
                    <div class="image-preview">
                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen Frontal Actual">
                    </div>
                </div>
                <div class="form__group field">
                    <label for="img_trasera">Imagen Trasera (opcional)</label>
                    <input type="file" id="img_trasera" name="img_trasera" accept="image/*">
                    <div class="image-preview">
                        <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" alt="Imagen Trasera Actual">
                    </div>
                </div>
                <div class="form__group field">
                    <label for="estilos">Estilos</label>
                    <div id="estilos" class="checkbox-grid">
                        @foreach ($estilos as $estilo)
                            <label class="checkbox-label">
                                <input type="checkbox" name="estilos[]" value="{{ $estilo->id_estilo }}" 
                                    {{ isset($prenda) && $prenda->estilos->contains($estilo->id_estilo) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                {{ $estilo->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="form__group field">
                    <label for="etiquetas">Etiquetas</label>
                    <div id="etiquetas" class="checkbox-grid">
                        @foreach ($etiquetas as $etiqueta)
                            <label class="checkbox-label">
                                <input type="checkbox" name="etiquetas[]" value="{{ $etiqueta->id_etiqueta }}" 
                                    {{ $prenda->etiquetas->contains($etiqueta->id_etiqueta) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                {{ $etiqueta->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="form__group field">
                    <label for="colores">Colores</label>
                    <div id="colores" class="checkbox-grid">
                        @foreach ($colores as $color)
                            <label class="checkbox-label">
                                <input type="checkbox" name="colores[]" value="{{ $color->id_color }}" 
                                    {{ $prenda->colores->contains($color->id_color) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                {{ $color->nombre }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="create-btn"><span>Actualizar Prenda</span></button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/validacionropa.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const textareas = document.querySelectorAll("textarea");

            textareas.forEach(textarea => {
                // Ajustar la altura inicial
                textarea.style.height = textarea.scrollHeight + "px";

                // Ajustar la altura al escribir
                textarea.addEventListener("input", function () {
                    textarea.style.height = "auto"; // Restablecer la altura
                    textarea.style.height = textarea.scrollHeight + "px"; // Ajustar al contenido
                });
            });
        });
    </script>
</body>
</html>