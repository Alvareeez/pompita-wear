<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ropa</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a href="{{ route('admin.solicitudes.index') }}">
                <button>Solicitudes</button> <!-- Nueva pestaña -->
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (!request()->routeIs('admin.solicitudes.index'))
            <div class="actions-container">
                <a href="{{ route('admin.ropa.create') }}" class="create-btn">+ Crear Ropa</a>
            </div>
            <div class="filter-container">
                <input type="text" id="filtro-nombre" placeholder="Filtrar por nombre">
                <input type="number" id="filtro-precio-min" placeholder="Precio mínimo">
                <input type="number" id="filtro-precio-max" placeholder="Precio máximo">
                <textarea id="filtro-descripcion" placeholder="Filtrar por descripción"></textarea>
            </div>
        @endif

        @if (!request()->routeIs('admin.solicitudes.index'))
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Etiquetas</th>
                            <th>Colores</th>
                            <th>Estilos</th>
                            <th>Imágenes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="prendas-table">
                        @foreach ($prendas as $prenda)
                            <tr>
                                <td>{{ $prenda->id_prenda }}</td>
                                <td>{{ $prenda->nombre }}</td>
                                <td>{{ $prenda->tipo->tipo }}</td>
                                <td>{{ $prenda->precio }} €</td>
                                <td>{{ $prenda->descripcion }}</td>
                                <td>
                                    @foreach ($prenda->etiquetas as $etiqueta)
                                        <span class="badge">{{ $etiqueta->nombre }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($prenda->colores as $color)
                                        <span class="badge" style="background-color: {{ $color->hex }}; color: #fff;">{{ $color->nombre }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($prenda->estilos as $estilo)
                                        <span class="badge">{{ $estilo->nombre }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Frontal de {{ $prenda->nombre }}" style="width: 80px; height: auto;">
                                        <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" alt="Trasera de {{ $prenda->nombre }}" style="width: 80px; height: auto;">
                                    </div>
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

            <!-- Paginación -->
            <div class="pagination-container">
                {{ $prendas->links('pagination.custom') }}
            </div>

            <!-- Formulario para descarga en PDF -->
            <form action="{{ route('admin.ropa.pdf') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="prendas">Selecciona las prendas:</label>
                    <select id="prendas" name="prendas[]" multiple>
                        @foreach ($prendas as $prenda)
                            <option value="{{ $prenda->id_prenda }}">{{ $prenda->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="download-btn" type="submit">
                    Descargar PDF
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 16l4-5h-3V4h-2v7H8z"></path>
                            <path d="M20 18H4v-2h16v2z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        @endif

        <!-- Contenido de solicitudes -->
        @if (request()->routeIs('admin.solicitudes.index'))
            <div class="table-container">
                <h2>Solicitudes de Ropa</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Imágenes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->nombre }}</td>
                                <td>{{ $solicitud->descripcion }}</td>
                                <td>{{ $solicitud->tipoPrenda->tipo }}</td>
                                <td>{{ $solicitud->precio }} €</td>
                                <td>
                                    <img src="{{ asset('storage/' . $solicitud->img_frontal) }}" width="80">
                                    @if ($solicitud->img_trasera)
                                        <img src="{{ asset('storage/' . $solicitud->img_trasera) }}" width="80">
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.solicitudes.update', $solicitud->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="action" value="aceptar" class="accept-btn">Aceptar</button>
                                        <button type="submit" name="action" value="rechazar" class="reject-btn">Rechazar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
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

            $('#filtro-nombre, #filtro-precio-min, #filtro-precio-max, #filtro-descripcion').on('input change', function() {
                const nombre = $('#filtro-nombre').val();
                const precio_min = $('#filtro-precio-min').val();
                const precio_max = $('#filtro-precio-max').val();
                const descripcion = $('#filtro-descripcion').val();

                spinner.style.display = "flex"; // Mostrar el spinner

                $.ajax({
                    url: '{{ route('admin.ropa.index') }}',
                    method: 'GET',
                    data: {
                        nombre: nombre,
                        precio_min: precio_min,
                        precio_max: precio_max,
                        descripcion: descripcion,
                    },
                    success: function(response) {
                        $('#prendas-table').html($(response).find('#prendas-table').html());
                        $('.pagination-container').html($(response).find('.pagination-container').html());
                        spinner.style.display = "none"; // Ocultar el spinner
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        spinner.style.display = "none"; // Ocultar el spinner en caso de error
                    }
                });
            });
        });
    </script>
</body>
</html>
