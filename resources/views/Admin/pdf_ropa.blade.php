<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ropa Seleccionada</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px 40px 20px 20px; /* Margen derecho más amplio */
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        h1 {
            text-align: center;
            color: #00509e;
            margin-bottom: 30px;
            font-size: 24px;
            text-transform: uppercase;
        }
        .table-container {
            width: 100%;
            max-width: 850px; /* Ajustar el ancho máximo */
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }
        th {
            background-color: #00509e;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        td img {
            max-width: 80px;
            height: auto;
            border-radius: 5px;
            display: block;
            margin: 5px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .description {
            font-size: 13px;
            line-height: 1.5;
            color: #555;
        }
        .highlight {
            font-weight: bold;
            color: #00509e;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <div class="logo">
        <img src="{{ public_path('img/pompitaLogo.png') }}" alt="Pompita Wear">
    </div>

    <!-- Título -->
    <h1>Ropa Seleccionada</h1>

    <!-- Tabla -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Estilos</th>
                    <th>Etiquetas</th>
                    <th>Colores</th>
                    <th>Imágenes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prendas as $prenda)
                    <tr>
                        <td class="highlight">{{ $prenda->id_prenda }}</td>
                        <td>{{ $prenda->nombre }}</td>
                        <td>{{ $prenda->tipo->tipo }}</td>
                        <td>{{ number_format($prenda->precio, 2) }} €</td>
                        <td class="description">{{ $prenda->descripcion }}</td>
                        <td>{{ $prenda->estilos->pluck('nombre')->join(', ') }}</td>
                        <td>{{ $prenda->etiquetas->pluck('nombre')->join(', ') }}</td>
                        <td>{{ $prenda->colores->pluck('nombre')->join(', ') }}</td>
                        <td>
                            <img src="{{ public_path('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen Frontal">
                            <img src="{{ public_path('img/prendas/' . $prenda->img_trasera) }}" alt="Imagen Trasera">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>Generado por Pompita Wear - {{ now()->setTimezone('Europe/Madrid')->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>