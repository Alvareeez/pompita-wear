<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ropa</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a href="{{ route('admin.colores.index') }}">
                <button>Colores</button>
            </a>
            <a href="{{ route('admin.solicitudes.index') }}">
                <button>Solicitudes</button>
            </a>
            <a href="{{ route('admin.plantillas.index') }}"><button>Plantillas</button></a>
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
            <form method="GET" action="{{ route('admin.ropa.index') }}">
                <div class="filter-container">
                    <input type="text" id="filtro-nombre" name="nombre" placeholder="Buscar por nombre" value="{{ request('nombre') }}">

                    <div class="filter-group">
                        <select id="filtro-estilos" name="estilos">
                            <option value="">Todos los estilos</option>
                            @foreach ($estilos as $estilo)
                                <option value="{{ $estilo->id_estilo }}" {{ request('estilos') == $estilo->id_estilo ? 'selected' : '' }}>
                                    {{ $estilo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <select id="filtro-etiquetas" name="etiquetas">
                            <option value="">Todas las etiquetas</option>
                            @foreach ($etiquetas as $etiqueta)
                                <option value="{{ $etiqueta->id_etiqueta }}" {{ request('etiquetas') == $etiqueta->id_etiqueta ? 'selected' : '' }}>
                                    {{ $etiqueta->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <select id="filtro-colores" name="colores">
                            <option value="">Todos los colores</option>
                            @foreach ($colores as $color)
                                <option value="{{ $color->id_color }}" {{ request('colores') == $color->id_color ? 'selected' : '' }}>
                                    {{ $color->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón para limpiar filtros -->
                    <button type="button" id="clear-filters-btn">Limpiar filtros</button>
                </div>
            </form>
        @endif

        @if (!request()->routeIs('admin.solicitudes.index'))
            <div id="tabla-prendas-contenedor">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
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

                <div class="pagination-container">
                    {{ $prendas->appends(request()->except('page'))->links('pagination.custom') }}
                </div>
            </div>
<br>
            <!-- Formulario para descarga en PDF -->
            <form action="{{ route('admin.ropa.pdf') }}" method="POST">
                @csrf
                <div class="form-group">
                    <select id="prenda" name="prenda" class="select-pdf">
    <option value="" disabled selected>Selecciona una prenda</option>
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
    // Limpiar filtros
    document.getElementById('clear-filters-btn').addEventListener('click', function () {
        document.getElementById('filtro-nombre').value = '';
        document.getElementById('filtro-estilos').value = '';
        document.getElementById('filtro-etiquetas').value = '';
        document.getElementById('filtro-colores').value = '';

        // Realizar la solicitud Fetch sin filtros
        fetchPrendas({});
    });

    // Aplicar filtros automáticamente al cambiar los valores
    ['filtro-nombre', 'filtro-estilos', 'filtro-etiquetas', 'filtro-colores'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
            const nombre = document.getElementById('filtro-nombre').value;
            const estilos = document.getElementById('filtro-estilos').value;
            const etiquetas = document.getElementById('filtro-etiquetas').value;
            const colores = document.getElementById('filtro-colores').value;
            fetchPrendas({ nombre, estilos, etiquetas, colores });
        });
    });

    // Paginación con Fetch
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination-container .pagination a')) {
            e.preventDefault();
            const link = e.target.closest('a');
            const url = new URL(link.href);
            const nombre = document.getElementById('filtro-nombre').value;
            const estilos = document.getElementById('filtro-estilos').value;
            const etiquetas = document.getElementById('filtro-etiquetas').value;
            const colores = document.getElementById('filtro-colores').value;

            if (nombre) url.searchParams.set('nombre', nombre);
            if (estilos) url.searchParams.set('estilos', estilos);
            if (etiquetas) url.searchParams.set('etiquetas', etiquetas);
            if (colores) url.searchParams.set('colores', colores);

            fetchPrendas({}, url.toString());
        }
    });

    function fetchPrendas(data = {}, customUrl = null) {
        let url = customUrl || '{{ route('admin.ropa.index') }}';
        if (!customUrl) {
            const params = new URLSearchParams();
            if (data.nombre) params.append('nombre', data.nombre);
            if (data.estilos) params.append('estilos', data.estilos);
            if (data.etiquetas) params.append('etiquetas', data.etiquetas);
            if (data.colores) params.append('colores', data.colores);
            url += '?' + params.toString();
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Extraer solo la tabla y la paginación del HTML recibido
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newTable = tempDiv.querySelector('#prendas-table');
            const newPagination = tempDiv.querySelector('.pagination-container');
            if (newTable) {
                document.getElementById('prendas-table').innerHTML = newTable.innerHTML;
            }
            if (newPagination) {
                document.querySelector('.pagination-container').innerHTML = newPagination.innerHTML;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

    </script>
</body>
</html>