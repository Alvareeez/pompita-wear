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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FORMULARIO DE FILTROS --}}
    <form method="GET" action="{{ route('outfit.index') }}">
        <div class="row">
            <div class="col-lg-8">

                {{-- COMPONENTES DE CARRUSEL --}}
                @php
                    $partes = ['Cabeza' => $prendasCabeza, 'Torso' => $prendasTorso, 'Piernas' => $prendasPiernas, 'Pies' => $prendasPies];
                @endphp

                @foreach($partes as $parte => $prendas)
                    <div class="carousel-container mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title">Prendas de {{ $parte }}</div>
                            <div>
                                @if(request('color_' . strtolower($parte)))
                                    <span class="badge bg-info">Color</span>
                                @endif
                                @if(request('estilo_' . strtolower($parte)))
                                    <span class="badge bg-warning text-dark">Estilo</span>
                                @endif
                            </div>
                        </div>
                        <div id="carousel{{ $parte }}" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                @foreach($prendas as $prenda)
                                    <div class="carousel-item @if($loop->first) active @endif" data-prenda-id="{{ $prenda->id_prenda }}">
                                        <div class="carousel-slide-container">
                                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block img-fluid" alt="{{ $prenda->nombre }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $parte }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $parte }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- FILTROS --}}
            <div class="col-lg-4">
                <div class="filter-panel">
                    <h5 class="mb-4">Filtros</h5>

                    @foreach($partes as $parte => $_)
                        @php $parteKey = strtolower($parte); @endphp
                        <div class="mb-4">
                            <div class="filter-title">{{ $parte }}</div>
                            <div class="mb-2">
                                <label for="color_{{ $parteKey }}" class="form-label">Color</label>
                                <select name="color_{{ $parteKey }}" id="color_{{ $parteKey }}" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" {{ request("color_$parteKey") == $color->id_color ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="estilo_{{ $parteKey }}" class="form-label">Estilo</label>
                                <select name="estilo_{{ $parteKey }}" id="estilo_{{ $parteKey }}" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" {{ request("estilo_$parteKey") == $estilo->id_estilo ? 'selected' : '' }}>
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

    {{-- FORMULARIO PARA CREAR OUTFIT --}}
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

        <button type="submit" class="btn btn-success">Crear Outfit</button>
    </form>
</div>

{{-- SCRIPTS PARA ACTUALIZAR INPUTS HIDDEN CON LOS CARRUSELES --}}
<script>
    function actualizarPrendaSeleccionada() {
        document.querySelectorAll('.carousel').forEach(carousel => {
            const activeItem = carousel.querySelector('.carousel-item.active');
            const prendaId = activeItem.dataset.prendaId;
            const parte = carousel.id.replace('carousel', '').toLowerCase();
            const input = document.getElementById('prenda_' + parte);
            if (input) input.value = prendaId;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        actualizarPrendaSeleccionada();

        document.querySelectorAll('.carousel').forEach(carousel => {
            carousel.addEventListener('slid.bs.carousel', () => {
                actualizarPrendaSeleccionada();
            });
        });
    });
</script>

@include('layouts.footer')
@endsection