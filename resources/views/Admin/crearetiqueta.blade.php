<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Etiqueta</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <script src="{{ asset('js/validacionetiquetas.js') }}"></script>
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
            <a href="{{ route('admin.etiquetas.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Crear Etiqueta</h2>
            <form action="{{ route('admin.etiquetas.store') }}" method="POST">
                @csrf
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre de la Etiqueta" id="nombre" name="nombre" required />
                    <label for="nombre" class="form__label">Nombre de la Etiqueta</label>
                </div>
                <button type="submit" class="create-btn"><span>Crear Etiqueta</span></button>
            </form>
        </div>
    </main>
</body>
</html>