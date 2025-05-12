<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Ropa</title>
    <link rel="stylesheet" href="{{ asset('css/stylesAdmin.css') }}">
</head>
<body>
    <header>
        <h1>Solicitudes de Ropa</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Precio</th>
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
                        <td>{{ $solicitud->precio }} €</td>
                        <td>
                            <img src="{{ asset('img/prendas/' . $solicitud->img_frontal) }}" alt="Frontal de {{ $solicitud->nombre }}" width="80">
                            @if ($solicitud->img_trasera)
                                <img src="{{ asset('img/prendas/' . $solicitud->img_trasera) }}" alt="Trasera de {{ $solicitud->nombre }}" width="80">
                            @endif
                        </td>
                        <td>
                            @foreach ($solicitud->etiquetas as $etiqueta)
                                <span>{{ $etiqueta->nombre }}</span>@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($solicitud->colores as $color)
                                <span>{{ $color->nombre }}</span>@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($solicitud->estilos as $estilo)
                                <span>{{ $estilo->nombre }}</span>@if (!$loop->last), @endif
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
    </main>
</body>
</html>