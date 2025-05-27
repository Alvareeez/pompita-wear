<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('js/hamburguesa.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <a href="{{ route('admin.colores.index') }}">
                <button>Colores</button>
            </a>
            <a href="{{ route('admin.solicitudes.index') }}">
                <button>Solicitudes</button>
            </a>
            <a href="{{ route('admin.plantillas.index') }}"><button>Plantillas</button></a>
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

        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll(".tabs a, .logout-form button");
            const spinner = document.getElementById("loading-spinner");

            links.forEach(link => {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    spinner.style.display = "flex";

                    const href = link.tagName === "A" ? link.href : link.closest("form").action;

                    setTimeout(() => {
                        if (link.tagName === "A") {
                            window.location.href = href;
                        } else {
                            link.closest("form").submit();
                        }
                    }, 1000); 
                });
            });

            function filtrarUsuarios() {
                const nombre = document.getElementById("filtro-nombre").value;
                const correo = document.getElementById("filtro-correo").value;
                const rol = document.getElementById("filtro-rol").value;

                spinner.style.display = "flex"; // Mostrar el spinner

                fetch(`{{ route('admin.usuarios.index') }}?nombre=${nombre}&correo=${correo}&rol=${rol}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("tabla-usuarios").innerHTML = data;
                    spinner.style.display = "none"; // Ocultar el spinner
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = "none"; // Ocultar el spinner en caso de error
                });
            }

            document.getElementById("filtro-nombre").addEventListener("keyup", filtrarUsuarios);
            document.getElementById("filtro-correo").addEventListener("keyup", filtrarUsuarios);
            document.getElementById("filtro-rol").addEventListener("change", filtrarUsuarios);
        });

        document.addEventListener("DOMContentLoaded", function () {
            const estadoSelects = document.querySelectorAll(".estado-select");

            estadoSelects.forEach(select => {
                select.addEventListener("change", function () {
                    const userId = this.getAttribute("data-id");
                    const nuevoEstado = this.value;

                    fetch(`{{ route('admin.usuarios.updateEstado') }}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            id_usuario: userId,
                            estado: nuevoEstado
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Estado actualizado",
                                text: `El estado del usuario ha sido cambiado a ${nuevoEstado}.`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "No se pudo actualizar el estado del usuario.",
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Ocurrió un error al intentar actualizar el estado.",
                        });
                    });
                });
            });
        });
    </script>
</body>
</html>