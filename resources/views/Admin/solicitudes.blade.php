<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Ropa</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
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
                <button>Etiquetas</button>
            </a>
            <a href="{{ route('admin.solicitudes.index') }}">
                <button class="active">Solicitudes</button>
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

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Imágenes</th>
                        <th>Etiquetas</th>
                        <th>Colores</th>
                        <th>Estilos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->nombre }}</td>
                            <td>{{ $solicitud->descripcion }}</td>
                            <td>{{ $solicitud->tipoPrenda->tipo ?? 'N/A' }}</td>
                            <td>
                                <img src="{{ asset('img/prendas/' . $solicitud->img_frontal) }}" alt="Frontal de {{ $solicitud->nombre }}" width="80">
                                @if ($solicitud->img_trasera)
                                    <img src="{{ asset('img/prendas/' . $solicitud->img_trasera) }}" alt="Trasera de {{ $solicitud->nombre }}" width="80">
                                @endif
                            </td>
                            <td>
                                @foreach ($solicitud->etiquetas as $etiqueta)
                                    <span class="badge">{{ $etiqueta->nombre }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($solicitud->colores as $color)
                                    <span class="badge">{{ $color->nombre }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($solicitud->estilos as $estilo)
                                    <span class="badge">{{ $estilo->nombre }}</span>
                                @endforeach
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
    </main>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const spinner = document.getElementById("loading-spinner");

    document.querySelectorAll("form button[type='submit']").forEach(button => {
        button.addEventListener("click", function () {
            spinner.style.display = "flex";
        });
    });

    document.querySelectorAll(".tabs a, .logout-form button").forEach(link => {
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
});

    </script>
</body>
</html>