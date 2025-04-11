<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <nav>
            <a href="/">Inicio</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="text-white logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="tabs">
            <a href="{{ route('admin.usuarios.index') }}">
                <button class="active">Usuarios</button>
            </a>
            <a href="{{ route('admin.ropa.index') }}">
                <button>Ropa</button>
            </a>
            <a href="{{ route('admin.estilos.index') }}">
                <button>Estilos</button>
            </a>
            <a href="{{ route('admin.etiquetas.index') }}">
                <button>Etiquetas</button>
            </a>
        </div>

        <div class="actions-container">
            <a href="{{ route('admin.usuarios.create') }}" class="create-btn">+ Crear Usuario</a>
        </div>

        <!-- FILTROS AJAX -->
        <div class="filter-container">
            <input type="text" id="filtro-nombre" placeholder="Filtrar por nombre...">
            <input type="text" id="filtro-correo" placeholder="Filtrar por correo...">
            <select id="filtro-rol">
                <option value="">Todos los roles</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->nombre }}">{{ $rol->nombre }}</option>
                @endforeach
            </select>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabla dinámica con AJAX -->
        <div class="table-container" id="tabla-usuarios">
            @include('admin.partials.tabla-usuarios', ['usuarios' => $usuarios])
        </div>

        <div id="loading-spinner" class="dot-spinner" style="display: none;">
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
        </div>
    </main>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }

        // AJAX de filtros
        document.addEventListener("DOMContentLoaded", function () {
            const spinner = document.getElementById("loading-spinner");

            function filtrarUsuarios() {
                const nombre = document.getElementById("filtro-nombre").value;
                const correo = document.getElementById("filtro-correo").value;
                const rol = document.getElementById("filtro-rol").value;

                spinner.style.display = "flex";

                fetch(`{{ route('admin.usuarios.index') }}?nombre=${nombre}&correo=${correo}&rol=${rol}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("tabla-usuarios").innerHTML = data;
                    spinner.style.display = "none";
                });
            }

            document.getElementById("filtro-nombre").addEventListener("keyup", filtrarUsuarios);
            document.getElementById("filtro-correo").addEventListener("keyup", filtrarUsuarios);
            document.getElementById("filtro-rol").addEventListener("change", filtrarUsuarios);
        });
    </script>
</body>
</html>
