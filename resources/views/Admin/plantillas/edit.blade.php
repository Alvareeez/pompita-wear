{{-- filepath: c:\wamp64\www\pompita-wear\pompita-wear\resources\views\Admin\plantillas\edit.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Plantilla - Pompita Wear</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
        <nav>
            <a href="{{ route('admin.plantillas.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Editar Plantilla</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.plantillas.update', $plantilla->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre de la plantilla" name="nombre" id="nombre" value="{{ old('nombre', $plantilla->nombre) }}" required />
                    <label for="nombre" class="form__label">Nombre</label>
                </div>

                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Slug de la plantilla" name="slug" id="slug" value="{{ old('slug', $plantilla->slug) }}" required />
                    <label for="slug" class="form__label">Slug</label>
                </div>
                <div class="form__group field">
                    <select class="form__field" name="empresa_id" id="empresa_id" required>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ $empresa->id == $plantilla->empresa_id ? 'selected' : '' }}>
                                {{ $empresa->razon_social }}
                            </option>
                        @endforeach
                    </select>
                    <label for="empresa_id" class="form__label">Empresa</label>
                </div>

                <div class="form__group field">
                    <select class="form__field" name="programador_id" id="programador_id">
                        <option value="">Sin asignar</option>
                        @foreach ($programadores as $programador)
                            <option value="{{ $programador->id_usuario }}" {{ $programador->id_usuario == $plantilla->programador_id ? 'selected' : '' }}>
                                {{ $programador->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="programador_id" class="form__label">Programador</label>
                </div>

                <div class="form__group field">
                    <input type="url" class="form__field" placeholder="Enlace de la plantilla" name="enlace" id="enlace" value="{{ old('enlace', $plantilla->enlace) }}">
                    <label for="enlace" class="form__label">Enlace</label>
                </div>

                <div class="form__group field">
                    <label for="foto">Foto</label>
                    @if ($plantilla->foto)
                        <div>
                            <img src="{{ asset('img/plantillas/' . $plantilla->foto) }}" alt="Foto de la plantilla" class="image-preview" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>

                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Color Primario" name="color_primario" id="color_primario" value="{{ old('color_primario', $plantilla->color_primario) }}">
                    <label for="color_primario" class="form__label">Color Primario</label>
                </div>

                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Color Secundario" name="color_secundario" id="color_secundario" value="{{ old('color_secundario', $plantilla->color_secundario) }}">
                    <label for="color_secundario" class="form__label">Color Secundario</label>
                </div>

                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Color Terciario" name="color_terciario" id="color_terciario" value="{{ old('color_terciario', $plantilla->color_terciario) }}">
                    <label for="color_terciario" class="form__label">Color Terciario</label>
                </div>
                <button type="submit" class="create-btn"><span>Guardar Cambios</span></button>
            </form>
        </div>
    </main>
</body>
</html>