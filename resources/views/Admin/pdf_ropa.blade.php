<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ropa Seleccionada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Ropa Seleccionada</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prendas as $prenda)
                <tr>
                    <td>{{ $prenda->id_prenda }}</td>
                    <td>{{ $prenda->tipo->tipo }}</td>
                    <td>{{ $prenda->precio }} €</td>
                    <td>{{ $prenda->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>