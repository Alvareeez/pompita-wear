@extends('layouts.header')

@section('title', 'Crear Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .filter-panel {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            height: 100%;
        }
        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }
        .badge-filter {
            font-size: 0.8rem;
            margin-left: 6px;
        }
        .carousel-container {
            margin-bottom: 25px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .carousel-inner img {
            max-height: 250px;
            width: auto;
            object-fit: contain;
            margin: 0 auto;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 12px;
        }
        .row-equal-height {
            display: flex;
            flex-wrap: wrap;
        }
        .row-equal-height > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
            border-radius: 50%;
            width: 25px;
            height: 25px;
        }
        .carousel-control-prev,
        .carousel-control-next {
            filter: invert(1);
            width: 8%;
        }
        .form-select-sm {
            padding: 0.35rem 0.7rem;
            font-size: 1rem;
        }
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 1rem;
        }
        .carousel-slide-container {
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 1200px;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .create-outfit-btn {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">Crea tu Outfit</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="filter-form" method="GET" action="{{ route('outfit.filterAjax') }}">
        <div class="row">
            <div class="col-lg-8">
                <div id="carousel-results">
                    @php
                        $partes = [
                            'Cabeza'  => $prendasCabeza,
                            'Torso'   => $prendasTorso,
                            'Piernas' => $prendasPiernas,
                            'Pies'    => $prendasPies
                        ];
                    @endphp
                    @include('outfit.partials.carousel')
                </div>
            </div>
            <div class="col-lg-4">
                <div class="filter-panel">
                    <h5 class="mb-4">Filtros</h5>
                    @foreach($partes as $parte => $_)
                        @php $key = strtolower($parte) @endphp
                        <div class="mb-4">
                            <div class="filter-title">{{ $parte }}</div>
                            <div class="mb-2">
                                <label for="color_{{ $key }}" class="form-label">Color</label>
                                <select name="color_{{ $key }}" id="color_{{ $key }}" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" {{ request("color_$key")==$color->id_color?'selected':'' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="estilo_{{ $key }}" class="form-label">Estilo</label>
                                <select name="estilo_{{ $key }}" id="estilo_{{ $key }}" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" {{ request("estilo_$key")==$estilo->id_estilo?'selected':'' }}>
                                            {{ $estilo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        <a href="{{ route('outfit.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('outfit.store') }}" class="mt-5">
        @csrf
        <div class="mb-3">
            <label for="nombre_outfit" class="form-label">Nombre del Outfit</label>
            <input type="text" name="nombre" id="nombre_outfit" class="form-control" placeholder="Introduce un nombre para tu outfit" required>
        </div>
        <input type="hidden" name="prenda_cabeza" id="prenda_cabeza">
        <input type="hidden" name="prenda_torso" id="prenda_torso">
        <input type="hidden" name="prenda_piernas" id="prenda_piernas">
        <input type="hidden" name="prenda_pies" id="prenda_pies">
        <button type="submit" class="btn btn-success create-outfit-btn">Crear Outfit</button>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/filtroCrearOutfit.js') }}"></script>
@endsection

@include('layouts.footer')```
