@extends('layouts.header')

@section('content')
<div class="form-container">
    <h2>Solicitar Nueva Prenda</h2>
    <form action="{{ route('solicitudes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre de la prenda" required>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <select name="id_tipoPrenda" required>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id_tipoPrenda }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>
        <input type="number" name="precio" placeholder="Precio (€)" step="0.01" required>
        <input type="file" name="img_frontal" required>
        <input type="file" name="img_trasera">

        <!-- Etiquetas -->
        <label for="etiquetas">Etiquetas:</label>
        <select name="etiquetas[]" id="etiquetas" multiple>
            @foreach ($etiquetas as $etiqueta)
                <option value="{{ $etiqueta->id_etiqueta }}">{{ $etiqueta->nombre }}</option>
            @endforeach
        </select>

        <!-- Colores -->
        <label for="colores">Colores:</label>
        <select name="colores[]" id="colores" multiple>
            @foreach ($colores as $color)
                <option value="{{ $color->id_color }}">{{ $color->nombre }}</option>
            @endforeach
        </select>

        <!-- Estilos -->
        <label for="estilos">Estilos:</label>
        <select name="estilos[]" id="estilos" multiple>
            @foreach ($estilos as $estilo)
                <option value="{{ $estilo->id_estilo }}">{{ $estilo->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Enviar Solicitud</button>
    </form>
</div>
@endsection