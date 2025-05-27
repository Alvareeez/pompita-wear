<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Plantillas</title>
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
            <a href="{{ route('admin.usuarios.index') }}" onclick="showSpinner()"><button>Usuarios</button></a>
            <a href="{{ route('admin.ropa.index') }}" onclick="showSpinner()"><button>Ropa</button></a>
            <a href="{{ route('admin.estilos.index') }}" onclick="showSpinner()"><button>Estilos</button></a>
            <a href="{{ route('admin.etiquetas.index') }}" onclick="showSpinner()"><button>Etiquetas</button></a>
            <a href="{{ route('admin.colores.index') }}" onclick="showSpinner()"><button>Colores</button></a>
            <a href="{{ route('admin.solicitudes.index') }}" onclick="showSpinner()"><button>Solicitudes</button></a>
            <a href="{{ route('admin.plantillas.index') }}" onclick="showSpinner()"><button class="active">Plantillas</button></a>
        </div>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-container">
            <input type="text" id="filtro-nombre" placeholder="Filtrar por nombre..." class="filter-input">
            <input type="text" id="filtro-empresa" placeholder="Filtrar por empresa..." class="filter-input">
        </div>

        <div class="table-container" id="tabla-plantillas">
            @include('admin.plantillas.partials.tabla-plantillas', ['plantillas' => $plantillas])
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
        document.addEventListener("DOMContentLoaded", function () {
            const spinner = document.getElementById("loading-spinner");

            function filtrarPlantillas() {
                const nombre = document.getElementById("filtro-nombre").value;
                const empresa = document.getElementById("filtro-empresa").value;

                spinner.style.display = "flex"; // Mostrar el spinner

                fetch(`{{ route('admin.plantillas.index') }}?nombre=${nombre}&empresa=${empresa}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("tabla-plantillas").innerHTML = data;
                    spinner.style.display = "none"; // Ocultar el spinner
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = "none"; // Ocultar el spinner en caso de error
                });
            }

            document.getElementById("filtro-nombre").addEventListener("keyup", filtrarPlantillas);
            document.getElementById("filtro-empresa").addEventListener("keyup", filtrarPlantillas);
        });

        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }

        function showSpinner() {
            document.getElementById("loading-spinner").style.display = "flex";
        }
    </script>
</body>
</html>