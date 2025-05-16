<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Etiquetas</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('js/hamburguesa.js') }}"></script>


</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/pompitaLogo.png') }}" alt="Pompita Wear">
        </div>
        <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
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
                <button>Usuarios</button>
            </a>
            <a href="{{ route('admin.ropa.index') }}">
                <button>Ropa</button>
            </a>
            <a href="{{ route('admin.estilos.index') }}">
                <button>Estilos</button>
            </a>
            <a href="{{ route('admin.etiquetas.index') }}">
                <button class="active">Etiquetas</button>
            </a>
            <a href="{{ route('admin.solicitudes.index') }}">
                <button>Solicitudes</button>
            </a>
        </div>

        <div class="actions-container">
            <a href="{{ route('admin.etiquetas.create') }}" class="create-btn">+ Crear Etiqueta</a>
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
                <tbody id="tabla-etiquetas">
                    @include('admin.partials.tabla-etiquetas', ['etiquetas' => $etiquetas])
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

                fetch(`{{ route('admin.etiquetas.index') }}?nombre=${encodeURIComponent(nombre)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('tabla-etiquetas').innerHTML = data;
                });
            });
        });
    </script>
</body>
</html>
