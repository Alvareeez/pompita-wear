{{-- resources/views/programador/show-plantilla.blade.php --}}
@extends('layouts.header')

@section('title', 'Procesar Solicitud de Plantilla')

@section('content')
<div class="container my-5">
  <h2 class="mb-4">Procesar Solicitud #{{ $plantilla->id }}</h2>

  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Empresa:</strong> {{ $plantilla->empresa->usuario->nombre }} ({{ $plantilla->empresa->razon_social }})</p>
      <p><strong>Slug público:</strong> {{ $plantilla->slug }}</p>
      <p><strong>Nombre plantilla:</strong> {{ $plantilla->nombre }}</p>
      @if($plantilla->foto)
        <p><strong>Imagen:</strong><br>
        <img src="{{ asset($plantilla->foto) }}" class="img-fluid" style="max-width:300px"></p>
      @endif
      @if($plantilla->enlace)
        <p><strong>Enlace externo:</strong> <a href="{{ $plantilla->enlace }}" target="_blank">{{ $plantilla->enlace }}</a></p>
      @endif
      <p><strong>Colores:</strong></p>
      <div class="d-flex gap-2 mb-3">
        <div style="width:40px;height:40px;background:{{ $plantilla->color_primario }};" title="Primario"></div>
        <div style="width:40px;height:40px;background:{{ $plantilla->color_secundario }};" title="Secundario"></div>
        <div style="width:40px;height:40px;background:{{ $plantilla->color_terciario }};" title="Terciario"></div>
      </div>
      <p><strong>Solicitada en:</strong> {{ $plantilla->solicitada_en->format('d/m/Y H:i') }}</p>
    </div>
  </div>

  <form action="{{ route('programador.plantillas.procesar', $plantilla) }}" method="POST" class="d-inline">
    @csrf
    <input type="hidden" name="action" value="aprobar">
    <button class="btn btn-success">Aprobar plantilla</button>
  </form>

  <form action="{{ route('programador.plantillas.procesar', $plantilla) }}" method="POST" class="d-inline ms-2">
    @csrf
    <input type="hidden" name="action" value="rechazar">
    <button class="btn btn-danger">Rechazar solicitud</button>
  </form>

  <a href="{{ route('programador.index') }}" class="btn btn-secondary ms-3">Volver al listado</a>
</div>
@include('layouts.footer')
@endsection
