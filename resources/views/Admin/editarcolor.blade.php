<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Color</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
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
            <a href="{{ route('admin.colores.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>
    <main class="admin-container">
        <div class="form-container">
            <h2>Editar Color</h2>
            <form action="{{ route('admin.colores.update', $color->id_color) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre del Color" id="nombre" name="nombre" value="{{ $color->nombre }}" required />
                    <label for="nombre" class="form__label">Nombre del Color</label>
                </div>
                <button type="submit" class="create-btn"><span>Actualizar Color</span></button>
            </form>
        </div>
    </main>
</body>
</html>