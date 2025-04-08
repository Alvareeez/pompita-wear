<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ropa</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
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
                <button class="active">Ropa</button>
            </a>
            <a href="{{ route('admin.estilos.index') }}">
                <button>Estilos</button>
            </a>
            <a href="{{ route('admin.etiquetas.index') }}">
                <button>Etiquetas</button>
            </a>
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
        <div class="actions-container">
            <a href="{{ route('admin.ropa.create') }}" class="create-btn">+ Crear Ropa</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Estilos</th>
                        <th>Etiquetas</th>
                        <th>Colores</th>
                        <th>Imágenes</th> <!-- Nueva columna para las imágenes -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prendas as $prenda)
                        <tr>
                            <td>{{ $prenda->id_prenda }}</td>
                            <td>{{ $prenda->tipo->tipo }}</td>
                            <td>{{ $prenda->precio }} €</td>
                            <td>{{ $prenda->descripcion }}</td>
                            <td>{{ $prenda->estilos->pluck('nombre')->join(', ') }}</td>
                            <td>{{ $prenda->etiquetas->pluck('nombre')->join(', ') }}</td>
                            <td>{{ $prenda->colores->pluck('nombre')->join(', ') }}</td>
                            <td>
                                <img src="{{ asset($prenda->img_frontal) }}" alt="Imagen Frontal" style="width: 50px; height: auto; margin-right: 5px;">
                                <img src="{{ asset($prenda->img_trasera) }}" alt="Imagen Trasera" style="width: 50px; height: auto;">
                            </td>
                            <td>
                                <a href="{{ route('admin.ropa.edit', $prenda->id_prenda) }}" class="edit-btn">✏️</a>
                                <a class="delete-btn" onclick="confirmDelete({{ $prenda->id_prenda }})">🗑️</a>
                                <form id="delete-form-{{ $prenda->id_prenda }}" action="{{ route('admin.ropa.destroy', $prenda->id_prenda) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form action="{{ route('admin.ropa.pdf') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="prendas">Selecciona las prendas:</label>
                <select id="prendas" name="prendas[]" multiple required>
                    @foreach ($prendas as $prenda)
                        <option value="{{ $prenda->id_prenda }}">{{ $prenda->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="download-btn">Descargar PDF</button>
        </form>
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
                            window.location.href = href; // Navega a la URL después de 2 segundos
                        } else {
                            link.closest("form").submit(); // Envía el formulario después de 2 segundos
                        }
                    }, 1000); 
                });
            });
        });
    </script>
</body>
</html>