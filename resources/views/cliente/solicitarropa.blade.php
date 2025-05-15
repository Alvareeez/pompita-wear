@extends('layouts.header')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleSolicitarRopa.css') }}">
@endsection
@section('scripts')
  <script src="{{ asset('js/solicitarropa.js') }}"></script>
@endsection
@section('content')
<div class="form-container">
    <h2>Solicitar Nueva Prenda</h2>

    <!-- Mostrar errores generales -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('solicitudes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nombre -->
        <input type="text" name="nombre" placeholder="Nombre de la prenda" value="{{ old('nombre') }}">
        @error('nombre')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Descripción -->
        <textarea name="descripcion" placeholder="Descripción">{{ old('descripcion') }}</textarea>
        @error('descripcion')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Tipo de Prenda -->
        <select name="id_tipoPrenda">
            <option value="">Selecciona un tipo de prenda</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id_tipoPrenda }}" {{ old('id_tipoPrenda') == $tipo->id_tipoPrenda ? 'selected' : '' }}>
                    {{ $tipo->tipo }}
                </option>
            @endforeach
        </select>
        @error('id_tipoPrenda')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Imagen Frontal -->
        <input type="file" name="img_frontal">
        @error('img_frontal')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Imagen Trasera -->
        <input type="file" name="img_trasera">
        @error('img_trasera')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Etiquetas -->
        <label for="etiquetas">Etiquetas:</label>
        <div class="checkbox-grid" name="etiquetas">
            @foreach ($etiquetas as $etiqueta)
                <label class="checkbox-label">
                    <input type="checkbox" name="etiquetas[]" value="{{ $etiqueta->id_etiqueta }}" 
                        {{ is_array(old('etiquetas')) && in_array($etiqueta->id_etiqueta, old('etiquetas')) ? 'checked' : '' }}>
                    <span class="checkbox-custom"></span>
                    {{ $etiqueta->nombre }}
                </label>
            @endforeach
        </div>
        @error('etiquetas')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Colores -->
        <label for="colores">Colores:</label>
        <div class="checkbox-grid" name="colores">
            @foreach ($colores as $color)
                <label class="checkbox-label">
                    <input type="checkbox" name="colores[]" value="{{ $color->id_color }}" 
                        {{ is_array(old('colores')) && in_array($color->id_color, old('colores')) ? 'checked' : '' }}>
                    <span class="checkbox-custom"></span>
                    {{ $color->nombre }}
                </label>
            @endforeach
        </div>
        @error('colores')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <!-- Estilos -->
        <label for="estilos">Estilos:</label>
        <div class="checkbox-grid" name="estilos">
            @foreach ($estilos as $estilo)
                <label class="checkbox-label">
                    <input type="checkbox" name="estilos[]" value="{{ $estilo->id_estilo }}" 
                        {{ is_array(old('estilos')) && in_array($estilo->id_estilo, old('estilos')) ? 'checked' : '' }}>
                    <span class="checkbox-custom"></span>
                    {{ $estilo->nombre }}
                </label>
            @endforeach
        </div>
        @error('estilos')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <button type="submit" class="submit-btn">Enviar Solicitud</button>
    </form>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/solicitarropa.js') }}"></script>
@endsection