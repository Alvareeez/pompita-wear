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
            padding: 20px;
            color: #333;
        }

        /* Encabezado */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            color: #0056b3;
            text-transform: uppercase;
            margin: 0;
        }

        /* Tabla */
        .table-container {
            width: 100%;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #0056b3;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td {
            vertical-align: top;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Imágenes */
        .image-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: center; /* Centra las imágenes horizontalmente */
        }

        .image-container img {
            max-width: 80px; /* Ajusta el ancho máximo */
            max-height: 80px; /* Ajusta el alto máximo */
            object-fit: contain; /* Asegura que la imagen se ajuste sin recortarse */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Pie de página */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <img src="{{ public_path('img/pompitaLogo.png') }}" alt="Pompita Wear">
        <h1>Ropa Seleccionada</h1>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
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
                        <td>{{ $prenda->nombre }}</td>
                        <td>{{ $prenda->tipo->tipo }}</td>
                        <td>{{ $prenda->descripcion }}</td>
                        <td>{{ $prenda->estilos->pluck('nombre')->join(', ') }}</td>
                        <td>{{ $prenda->etiquetas->pluck('nombre')->join(', ') }}</td>
                        <td>{{ $prenda->colores->pluck('nombre')->join(', ') }}</td>
                        <td>
                            <div class="image-container">
                                <img src="{{ public_path('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen Frontal">
                                <img src="{{ public_path('img/prendas/' . $prenda->img_trasera) }}" alt="Imagen Trasera">
                            </div>
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