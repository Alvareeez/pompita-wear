<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estilo</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="{{ asset('js/hamburguesa.js') }}"></script>
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/Pompita-blanco.png') }}" alt="Pompita Wear">
        </div>
    <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>
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
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre del Estilo" id="nombre" name="nombre" required />
                    <label for="nombre" class="form__label">Nombre del Estilo</label>
                </div>
                <button type="submit" class="create-btn"><span>Crear Estilo</span></button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/validacionestilo.js') }}"></script>
</body>
</html>