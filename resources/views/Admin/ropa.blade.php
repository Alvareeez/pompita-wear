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
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-container">
            <input type="text" id="filtro-nombre" placeholder="Filtrar por nombre">
            <input type="number" id="filtro-precio-min" placeholder="Precio mínimo">
            <input type="number" id="filtro-precio-max" placeholder="Precio máximo">
            <textarea id="filtro-descripcion" placeholder="Filtrar por descripción"></textarea>
        </div>

        <div class="actions-container">
            <a href="{{ route('admin.ropa.create') }}" class="create-btn">+ Crear Ropa</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Descripción</th>
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
            {{ $prendas->links('pagination.custom') }}
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

        $(document).ready(function() {
            // Filtrar prendas cuando se seleccionen opciones
            $('#filtro-nombre, #filtro-precio-min, #filtro-precio-max, #filtro-descripcion, #filtro-estilos, #filtro-etiquetas').on('input change', function() {
                let nombre = $('#filtro-nombre').val();
                let precio_min = $('#filtro-precio-min').val();
                let precio_max = $('#filtro-precio-max').val();
                let descripcion = $('#filtro-descripcion').val();
                let estilos = $('#filtro-estilos').val();
                let etiquetas = $('#filtro-etiquetas').val();
    
                $.ajax({
                    url: '{{ route('admin.ropa.index') }}',
                    method: 'GET',
                    data: {
                        nombre: nombre,
                        precio_min: precio_min,
                        precio_max: precio_max,
                        descripcion: descripcion,
                        estilos: estilos,
                        etiquetas: etiquetas,
                    },
                    beforeSend: function() {
                        $('#loading-spinner').show(); // Mostrar el spinner de carga
                    },
                    success: function(response) {
                        // Reemplazar el contenido de la tabla con la respuesta parcial
                        $('#prendas-table').html($(response).find('#prendas-table').html());
                        // Reemplazar la paginación si es necesario
                        $('.pagination-container').html($(response).find('.pagination-container').html());
                    },
                    complete: function() {
                        $('#loading-spinner').hide(); // Ocultar el spinner de carga
                    }
                });
            });
        });
    </script>
</body>
</html>
