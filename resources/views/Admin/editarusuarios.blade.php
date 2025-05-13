<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Pompita Wear</title>
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
            <h2>Editar Usuario</h2>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.usuarios.update', $usuario->id_usuario) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form__group field">
                    <input type="text" class="form__field" placeholder="Nombre Completo" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}"  />
                    <label for="nombre" class="form__label">Nombre Completo</label>
                </div>
                <div class="form__group field">
                    <input type="email" class="form__field" placeholder="Correo Electrónico" name="email" id="email" value="{{ old('email', $usuario->email) }}"  />
                    <label for="email" class="form__label">Correo Electrónico</label>
                </div>
                <div class="form__group field">
                    <select class="form__field" name="id_rol" id="id_rol" >
                        <option value="" disabled>Selecciona un rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="id_rol" class="form__label">Rol</label>
                </div>
                
                <div class="form__group field">
                    <input type="password" class="form__field" placeholder="Nueva Contraseña (opcional)" name="password" id="password" />
                    <label for="password" class="form__label">Nueva Contraseña</label>
                </div>
                <div class="form__group field">
                    <input type="password" class="form__field" placeholder="Repetir Contraseña" name="password_confirmation" id="password_confirmation" />
                    <label for="password_confirmation" class="form__label">Repetir Contraseña</label>
                </div>
                <button type="submit" class="create-btn"><span>Actualizar Usuario</span></button>
            </form>
        </div>
    </main>
    <script src="{{ asset('js/validacionusuarios.js') }}"></script>
</body>
</html>