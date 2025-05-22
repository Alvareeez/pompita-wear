@extends('layouts.header')

@section('title', 'Panel de Empresa')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}"> {{-- adapta o crea styleEmpresa.css si lo prefieres --}}
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/cookie-consent.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
    {{-- Banner de bienvenida --}}
    <div class="empresa-banner text-center py-5 bg-light">
        <h1>¡Bienvenido, {{ auth()->user()->nombre }}!</h1>
        <p class="lead">Gestiona tu perfil de empresa y elige un plan para destacar tus prendas.</p>
    </div>

    {{-- Mensajes de sesión --}}
    @if(session('success'))
        <div class="alert alert-success text-center my-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Sección de planes --}}
    <div class="container my-5">
        <h2 class="section-title text-center mb-4">Nuestros Planes ⭐</h2>
        <div class="row justify-content-center">
            @foreach($planes as $plan)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $plan->nombre }}</h5>
                            <p class="card-text flex-grow-1">{{ $plan->descripcion }}</p>
                            <p class="h4 mb-4">{{ number_format($plan->precio, 2) }} €</p>
                            <a href="{{ route('paypal.subscribe', $plan) }}"
                               class="btn btn-primary mt-auto">
                                Contratar
                            </a>
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
