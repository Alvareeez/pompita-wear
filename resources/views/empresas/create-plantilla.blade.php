@php
    $datosFiscales = $empresa && $empresa->datosFiscales ? $empresa->datosFiscales : null;
@endphp
@extends('layouts.header')

@section('title', 'Solicitar Plantilla Web')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Solicitar Plantilla Web Básica</h2>

        <form action="{{ route('empresa.plantilla.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="slug" class="form-label">Slug (URL pública)</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la plantilla</label>
                <input type="text" name="nombre" id="nombre"
                    class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}">
                @error('nombre')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Imagen de cabecera (opcional)</label>
                <input type="file" name="foto" id="foto"
                    class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="enlace" class="form-label">Enlace externo (opcional)</label>
                <input type="text" name="enlace" id="enlace"
                    class="form-control @error('enlace') is-invalid @enderror" value="{{ old('enlace') }}">
                @error('enlace')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Colores</label>
                <div class="d-flex gap-3">
                    <div class="w-100">
                        <label for="color_primario" class="form-label small">Primario</label>
                        <input type="color" name="color_primario" id="color_primario"
                            class="form-control form-control-color" value="{{ old('color_primario', '#ff0000') }}">
                    </div>
                    <div class="w-100">
                        <label for="color_secundario" class="form-label small">Secundario</label>
                        <input type="color" name="color_secundario" id="color_secundario"
                            class="form-control form-control-color" value="{{ old('color_secundario', '#00ff00') }}">
                    </div>
                    <div class="w-100">
                        <label for="color_terciario" class="form-label small">Terciario</label>
                        <input type="color" name="color_terciario" id="color_terciario"
                            class="form-control form-control-color" value="{{ old('color_terciario', '#0000ff') }}">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="button" id="btn-fiscal" class="btn btn-secondary">
                    {{ empty($empresa->datos_fiscales_id) ? 'Añadir dirección fiscal' : 'Editar dirección fiscal' }}
                </button>
                <button type="submit" id="btn-pagar" class="btn btn-success"
                    {{ empty($empresa->datos_fiscales_id) ? 'disabled' : '' }}>
                    Pagar y Enviar Solicitud (199 €)
                </button>
            </div>
            {{-- <a href="{{ route('empresas.index') }}" class="btn btn-secondary ms-2">
                Cancelar
            </a> --}}
        </form>
    </div>

    @include('layouts.footer')
    <x-cookie-banner />
@endsection
@section('scripts')
    <script>
        window.datosFiscales = @json($datosFiscales);
        window.routeDatosFiscalesStore = "{{ route('empresa.datos-fiscales.store') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/select-prenda.js') }}"></script>
    <script src="{{ asset('js/createPlantilla.js') }}"></script>
    {{-- <script src="{{ asset('js/empresa.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/inicio.js') }}"></script> --}}
    <script src="{{ asset('js/cookie-consent.js') }}"></script>
@endsection
