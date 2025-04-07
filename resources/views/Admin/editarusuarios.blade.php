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
            <a href="/logout">Cerrar sesión</a>
        </nav>
    </header>

    <main class="admin-container">
        <div class="form-container">
            <h2>Editar Usuario</h2>
            <form action="{{ route('admin.usuarios.update', $usuario->id_usuario) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre }}" placeholder="Nombre Completo">
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ $usuario->email }}" placeholder="Correo Electrónico">
                </div>
                <div class="form-group">
                    <label for="id_rol">Rol</label>
                    <select id="id_rol" name="id_rol">
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ $usuario->id_rol == $rol->id_rol ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Nueva Contraseña (opcional)</label>
                    <input type="password" id="password" name="password" placeholder="Nueva Contraseña">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Repetir Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repetir Contraseña">
                </div>
                <button type="submit">Actualizar Usuario</button>
            </form>
        </div>
    </main>
</body>
</html>