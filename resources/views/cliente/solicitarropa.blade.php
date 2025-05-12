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

<style>
/* Estilo general del formulario */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Ubuntu', sans-serif;
}

.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-container input,
.form-container textarea,
.form-container select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.form-container button.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #004080;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-container button.submit-btn:hover {
    background-color: #003060;
}

/* Estilo de los checkboxes */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 10px;
    margin-bottom: 15px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 14px;
    color: #333;
}

.checkbox-label input {
    display: none;
}

.checkbox-custom {
    width: 18px;
    height: 18px;
    border: 2px solid #004080;
    border-radius: 3px;
    margin-right: 10px;
    display: inline-block;
    position: relative;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.checkbox-label input:checked + .checkbox-custom {
    background-color: #004080;
    border-color: #004080;
}

.checkbox-custom::after {
    content: '';
    width: 10px;
    height: 10px;
    background-color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    border-radius: 2px;
    transition: transform 0.3s ease;
}

.checkbox-label input:checked + .checkbox-custom::after {
    transform: translate(-50%, -50%) scale(1);
}
</style>