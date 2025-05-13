<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Pompita Wear</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="{{ route('admin.usuarios.index') }}">Volver</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Crear Usuario</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre Completo" name="nombre" id="nombre"  />
                    <label for="nombre" class="form__label">Nombre Completo</label>
                </div>
                <div class="form__group field">
                    <input type="email" class="form__field" placeholder="Correo Electrónico" name="email" id="email"  />
                    <label for="email" class="form__label">Correo Electrónico</label>
                </div>
                <div class="form__group field">
                    <input type="password" class="form__field" placeholder="Contraseña" name="password" id="password"  />
                    <label for="password" class="form__label">Contraseña</label>
                </div>
                <div class="form__group field">
                    <select class="form__field" name="id_rol" id="id_rol" >
                        <option value="" disabled selected>Selecciona un rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="id_rol" class="form__label">Rol</label>
                </div>
                <div class="form__group field">
                    <select class="form__field" name="estado" id="estado">
                        <option value="activo" selected>Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="baneado">Baneado</option>
                    </select>
                    <label for="estado" class="form__label">Estado</label>
                </div>
                <button type="submit" class="create-btn"><span>Crear Usuario</span></button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/validacionusuarios.js') }}"></script>
</body>
</html>