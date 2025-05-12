@extends('layouts.header')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleSolicitarRopa.css') }}">

@endsection
@section('content')
<div class="form-container">
    <h2>Solicitar Nueva Prenda</h2>
    <form action="{{ route('solicitudes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre de la prenda" >
        <textarea name="descripcion" placeholder="Descripción" ></textarea>
        <select name="id_tipoPrenda">
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id_tipoPrenda }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>
        <input type="number" name="precio" placeholder="Precio (€)" step="0.01" >
        <input type="file" name="img_frontal" >
        <input type="file" name="img_trasera">

        <!-- Etiquetas -->
        <label for="etiquetas">Etiquetas:</label>
        <div class="checkbox-grid">
            @foreach ($etiquetas as $etiqueta)
                <label class="checkbox-label">
                    <input type="checkbox" name="etiquetas[]" value="{{ $etiqueta->id_etiqueta }}">
                    <span class="checkbox-custom"></span>
                    {{ $etiqueta->nombre }}
                </label>
            @endforeach
        </div>

        <!-- Colores -->
        <label for="colores">Colores:</label>
        <div class="checkbox-grid">
            @foreach ($colores as $color)
                <label class="checkbox-label">
                    <input type="checkbox" name="colores[]" value="{{ $color->id_color }}">
                    <span class="checkbox-custom"></span>
                    {{ $color->nombre }}
                </label>
            @endforeach
        </div>

        <!-- Estilos -->
        <label for="estilos">Estilos:</label>
        <div class="checkbox-grid">
            @foreach ($estilos as $estilo)
                <label class="checkbox-label">
                    <input type="checkbox" name="estilos[]" value="{{ $estilo->id_estilo }}">
                    <span class="checkbox-custom"></span>
                    {{ $estilo->nombre }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="submit-btn">Enviar Solicitud</button>
    </form>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/solicitarropa.js') }}"></script>
@endsection

