@php
    $datosFiscales = $empresa && $empresa->datosFiscales ? $empresa->datosFiscales : null;
@endphp
@extends('layouts.header')

@section('title', 'Seleccionar Prenda')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        /* Oculta completamente las opciones marcadas como hidden */
        select option[hidden] {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Seleccionar Prenda para Destacar</h1>

        <h2 class="h4">
            Plan: {{ $plan->nombre }} — {{ number_format($plan->precio, 2, ',', '.') }} €
        </h2>
        <p>{{ $plan->descripcion }}</p>

        <form id="checkout-form" action="{{ route('paypal.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">

            {{-- Campo de búsqueda y botón Filtrar --}}
            <div class="input-group mb-4">
                <input type="text" id="prenda-search" class="form-control" placeholder="Escribe para filtrar…">
                <button class="btn btn-primary" id="btn-filter" type="button">
                    Filtrar
                </button>
            </div>

            <div class="form-group">
                <label for="prenda_id">Prenda a destacar:</label>
                <select name="prenda_id" id="prenda_id" class="form-control" required>
                    <option value="">— Selecciona una prenda —</option>
                    @foreach ($prendas as $prenda)
                        <option value="{{ $prenda->id_prenda }}" {{ $prenda->destacada ? 'disabled' : '' }}>
                            {{ $prenda->nombre }}
                            @if ($prenda->destacada)
                                — Ya destacada
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="button" id="btn-fiscal" class="btn btn-secondary">
                    {{ empty($empresa->datos_fiscales_id) ? 'Añadir dirección fiscal' : 'Editar dirección fiscal' }}
                </button>
                <button type="submit" id="btn-pagar" class="btn btn-success"
                    {{ empty($empresa->datos_fiscales_id) ? 'disabled' : '' }}>
                    Pagar {{ number_format($plan->precio, 2, ',', '.') }} €
                </button>
            </div>
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
@endsection
