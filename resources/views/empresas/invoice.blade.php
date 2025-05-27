<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            margin-bottom: 30px;
        }

        .datos {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>Factura de Compra</h2>

    <div class="header">
        @if ($solicitud->empresa && $solicitud->empresa->datosFiscales)
            <strong>Razón social:</strong> {{ $solicitud->empresa->datosFiscales->razon_social }}<br>
            <strong>NIF/CIF:</strong> {{ $solicitud->empresa->datosFiscales->nif }}<br>
            <strong>Dirección:</strong> {{ $solicitud->empresa->datosFiscales->direccion }}<br>
            <strong>Código Postal:</strong> {{ $solicitud->empresa->datosFiscales->cp }}<br>
            <strong>Ciudad:</strong> {{ $solicitud->empresa->datosFiscales->ciudad }}<br>
            <strong>Provincia:</strong> {{ $solicitud->empresa->datosFiscales->provincia }}<br>
            <strong>País:</strong> {{ $solicitud->empresa->datosFiscales->pais }}<br>
        @else
            <strong style="color:red">Datos fiscales no disponibles.</strong><br>
        @endif
        <strong>Fecha:</strong> {{ $solicitud->created_at->format('d/m/Y') }}
    </div>
    <div class="datos">
        <strong>Plan:</strong> {{ $solicitud->plan->nombre }}<br>
        <strong>Precio:</strong> {{ number_format($solicitud->plan->precio, 2, ',', '.') }} €<br>
        <strong>Prenda:</strong> {{ $solicitud->prenda->nombre ?? '' }}
    </div>
    <hr>
    <p>Gracias por su compra.</p>
</body>

</html>
