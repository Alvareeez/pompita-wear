@extends('layouts.header')

@section('title', 'Solicitar Plantilla Web')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
  <script src="{{ asset('js/cookie-consent.js') }}"></script>
@endsection

@section('content')
<div class="container my-5">
  <h2 class="mb-4">Solicitar Plantilla Web Básica</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('empresa.plantilla.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="slug" class="form-label">Slug (URL pública)</label>
      <input
        type="text"
        name="slug"
        id="slug"
        class="form-control"
        value="{{ old('slug') }}"
        required
      >
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre de la plantilla</label>
      <input
        type="text"
        name="nombre"
        id="nombre"
        class="form-control"
        value="{{ old('nombre') }}"
        required
      >
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Imagen de cabecera (opcional)</label>
      <input
        type="file"
        name="foto"
        id="foto"
        class="form-control"
      >
    </div>

    <div class="mb-3">
      <label for="enlace" class="form-label">Enlace externo (opcional)</label>
      <input
        type="url"
        name="enlace"
        id="enlace"
        class="form-control"
        value="{{ old('enlace') }}"
      >
    </div>

    <div class="mb-3">
      <label class="form-label">Colores</label>
      <div class="d-flex gap-3">
        <div class="w-100">
          <label for="color_primario" class="form-label small">Primario</label>
          <input
            type="color"
            name="color_primario"
            id="color_primario"
            class="form-control form-control-color"
            value="{{ old('color_primario', '#ff0000') }}"
            required
          >
        </div>
        <div class="w-100">
          <label for="color_secundario" class="form-label small">Secundario</label>
          <input
            type="color"
            name="color_secundario"
            id="color_secundario"
            class="form-control form-control-color"
            value="{{ old('color_secundario', '#00ff00') }}"
            required
          >
        </div>
        <div class="w-100">
          <label for="color_terciario" class="form-label small">Terciario</label>
          <input
            type="color"
            name="color_terciario"
            id="color_terciario"
            class="form-control form-control-color"
            value="{{ old('color_terciario', '#0000ff') }}"
            required
          >
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-success">
      Pagar y Enviar Solicitud (199 €)
    </button>
    <a href="{{ route('empresas.index') }}" class="btn btn-secondary ms-2">
      Cancelar
    </a>
  </form>
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection
