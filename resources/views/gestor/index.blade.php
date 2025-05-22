@extends('layouts.header')

@section('title', 'Panel de Gestión')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
    <div class="container my-5">
        <h2 class="section-title text-center mb-4">Gestión de Prendas Destacadas</h2>

        @if(session('success'))
            <div class="alert alert-success text-center my-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            @foreach($solicitudes as $sol)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $sol->prenda->nombre }}</h5>
                            <p class="mb-2"><strong>Empresa:</strong> {{ $sol->empresa->nombre }}</p>
                            <p class="mb-2"><strong>Plan:</strong> {{ $sol->plan->nombre }}</p>
                            <img src="{{ asset('img/prendas/'.$sol->prenda->img_frontal) }}"
                                 alt="{{ $sol->prenda->nombre }}"
                                 class="img-fluid mb-3 flex-grow-1">

                            @if(! $sol->prenda->destacada)
                                <form action="{{ route('gestor.highlight', $sol) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 mt-auto">
                                        Destacar prenda
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-success w-100 mt-auto" disabled>
                                    Ya destacada
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $solicitudes->links() }}
        </div>
    </div>
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection
