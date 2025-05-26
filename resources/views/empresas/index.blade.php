@extends('layouts.header')

@section('title', 'Panel de Empresa')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
    <script src="{{ asset('js/cookie-consent.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
    {{-- Banner --}}
    <div class="empresa-banner text-center py-5 bg-light">
        <h1>¡Bienvenido, {{ auth()->user()->nombre }}!</h1>
        <p class="lead">Elige un plan para destacar tus prendas.</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Listado de planes --}}
    <div class="container my-5">
        <h2 class="section-title text-center mb-4">Nuestros Planes ⭐</h2>
        <div class="row">
        @foreach($planes as $plan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $plan->nombre }}</h5>
                        <p class="card-text flex-grow-1">{{ $plan->descripcion }}</p>
                        <p class="h4 mb-4">{{ number_format($plan->precio, 2, ',', '.') }} €</p>

                        @if($plan->id === 3)
                            <a href="{{ route('empresa.plantilla.form') }}"
                            class="btn btn-success mt-auto">
                                Crear plantilla
                            </a>
                        @else
                            <a href="{{ route('empresa.destacar', $plan) }}"
                            class="btn btn-primary mt-auto">
                                Seleccionar prenda
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        </div>
    </div>
</div>
@include('layouts.footer')
<x-cookie-banner />
@endsection
