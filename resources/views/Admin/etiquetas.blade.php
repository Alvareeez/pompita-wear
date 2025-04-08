<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Etiquetas</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        </div>

        <div class="actions-container">
            <a href="{{ route('admin.etiquetas.create') }}" class="create-btn">+ Crear Etiqueta</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etiquetas as $etiqueta)
                        <tr>
                            <td>{{ $etiqueta->id_etiqueta }}</td>
                            <td>{{ $etiqueta->nombre }}</td>
                            <td>
                                <a href="{{ route('admin.etiquetas.edit', $etiqueta->id_etiqueta) }}" class="edit-btn">✏️</a>
                                <a class="delete-btn" onclick="confirmDelete({{ $etiqueta->id_etiqueta }})">🗑️</a>
                                <form id="delete-form-{{ $etiqueta->id_etiqueta }}" action="{{ route('admin.etiquetas.destroy', $etiqueta->id_etiqueta) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
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
            const links = document.querySelectorAll(".tabs a, .logout-form button"); // Selecciona los enlaces y el botón de cerrar sesión
            const spinner = document.getElementById("loading-spinner");

            links.forEach(link => {
                link.addEventListener("click", function (event) {
                    event.preventDefault(); // Evita la navegación inmediata
                    spinner.style.display = "flex"; // Muestra el spinner

                    const href = link.tagName === "A" ? link.href : link.closest("form").action; // Obtén la URL o acción del formulario

                    setTimeout(() => {
                        if (link.tagName === "A") {
                            window.location.href = href; // Navega a la URL después de 1 segundo
                        } else {
                            link.closest("form").submit(); // Envía el formulario después de 1 segundo
                        }
                    }, 1000); 
                });
            });
        });
    </script>
</body>
</html>