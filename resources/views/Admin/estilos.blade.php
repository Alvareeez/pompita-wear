<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Estilos</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <label class="burger" for="burger">
            <input type="checkbox" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <nav class="menu">
            <a href="/">Inicio</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
        </nav>
    </header>

    <main class="admin-container">
        <div class="tabs">
            <a href="{{ route('admin.usuarios.index') }}">
                <button>Usuarios</button>
            </a>
            <a href="{{ route('admin.ropa.index') }}">
                <button>Ropa</button>
            </a>
            <a href="{{ route('admin.estilos.index') }}">
                <button class="active">Estilos</button>
            </a>
            <a href="{{ route('admin.etiquetas.index') }}">
                <button>Etiquetas</button>
            </a>
            <a href="{{ route('admin.solicitudes.index') }}">
                <button>Solicitudes</button>
            </a>
        </div>

        <div class="actions-container">
            <a href="{{ route('admin.estilos.create') }}" class="create-btn">+ Crear Estilo</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-container">
            <input type="text" id="filtro-nombre" placeholder="Buscar por nombre..." class="filter-input">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-estilos">
                    @include('admin.partials.tabla-estilos', ['estilos' => $estilos])
                </tbody>
            </table>
        </div>
    </main>

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

            document.getElementById('filtro-nombre').addEventListener('input', function () {
                const nombre = this.value;

                fetch(`{{ route('admin.estilos.index') }}?nombre=${encodeURIComponent(nombre)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('tabla-estilos').innerHTML = data;
                });
            });
        });
    </script>
</body>
</html>
