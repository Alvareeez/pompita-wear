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

        <form method="GET" action="{{ route('outfit.index') }}">
            <div class="row row-equal-height">
                <!-- Columna izquierda: Carrousels de prendas -->
                <div class="col-lg-8">
                    <!-- Prenda de Cabeza -->
                    <div class="carousel-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title">Prendas de Cabeza</div>
                            <div>
                                @if(request('color_cabeza'))
                                    <span class="badge bg-info badge-filter">Color</span>
                                @endif
                                @if(request('estilo_cabeza'))
                                    <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                                @endif
                            </div>
                        </div>
                        <div id="carouselCabeza" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                @foreach($prendasCabeza as $prenda)
                                    <div class="carousel-item @if($loop->first) active @endif" data-prenda-id="{{ $prenda->id_prenda }}">
                                        <div class="carousel-slide-container">
                                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block img-fluid" alt="{{ $prenda->nombre }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCabeza" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselCabeza" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- Prenda de Torso -->
                    <div class="carousel-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title">Prendas de Torso</div>
                            <div>
                                @if(request('color_torso'))
                                    <span class="badge bg-info badge-filter">Color</span>
                                @endif
                                @if(request('estilo_torso'))
                                    <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                                @endif
                            </div>
                        </div>
                        <div id="carouselTorso" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                @foreach($prendasTorso as $prenda)
                                    <div class="carousel-item @if($loop->first) active @endif" data-prenda-id="{{ $prenda->id_prenda }}">
                                        <div class="carousel-slide-container">
                                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block img-fluid" alt="{{ $prenda->nombre }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTorso" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselTorso" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- Prenda de Piernas -->
                    <div class="carousel-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title">Prendas de Piernas</div>
                            <div>
                                @if(request('color_piernas'))
                                    <span class="badge bg-info badge-filter">Color</span>
                                @endif
                                @if(request('estilo_piernas'))
                                    <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                                @endif
                            </div>
                        </div>
                        <div id="carouselPiernas" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                @foreach($prendasPiernas as $prenda)
                                    <div class="carousel-item @if($loop->first) active @endif" data-prenda-id="{{ $prenda->id_prenda }}">
                                        <div class="carousel-slide-container">
                                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block img-fluid" alt="{{ $prenda->nombre }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPiernas" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselPiernas" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- Prenda de Pies -->
                    <div class="carousel-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="section-title">Prendas de Pies</div>
                            <div>
                                @if(request('color_pies'))
                                    <span class="badge bg-info badge-filter">Color</span>
                                @endif
                                @if(request('estilo_pies'))
                                    <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                                @endif
                            </div>
                        </div>
                        <div id="carouselPies" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                @foreach($prendasPies as $prenda)
                                    <div class="carousel-item @if($loop->first) active @endif" data-prenda-id="{{ $prenda->id_prenda }}">
                                        <div class="carousel-slide-container">
                                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block img-fluid" alt="{{ $prenda->nombre }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPies" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselPies" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Columna derecha: Filtros -->
                <div class="col-lg-4">
                    <div class="filter-panel">
                        <h5 class="mb-4" style="font-size: 1.3rem;">Filtros</h5>
                        
                        <!-- Filtros para Cabeza -->
                        <div class="mb-4">
                            <div class="filter-title">Cabeza</div>
                            <div class="mb-3">
                                <label for="color_cabeza" class="form-label">Color</label>
                                <select name="color_cabeza" id="color_cabeza" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" 
                                            {{ request('color_cabeza') == $color->id_color ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estilo_cabeza" class="form-label">Estilo</label>
                                <select name="estilo_cabeza" id="estilo_cabeza" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" 
                                            {{ request('estilo_cabeza') == $estilo->id_estilo ? 'selected' : '' }}>
                                            {{ $estilo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filtros para Torso -->
                        <div class="mb-4">
                            <div class="filter-title">Torso</div>
                            <div class="mb-3">
                                <label for="color_torso" class="form-label">Color</label>
                                <select name="color_torso" id="color_torso" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" 
                                            {{ request('color_torso') == $color->id_color ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estilo_torso" class="form-label">Estilo</label>
                                <select name="estilo_torso" id="estilo_torso" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" 
                                            {{ request('estilo_torso') == $estilo->id_estilo ? 'selected' : '' }}>
                                            {{ $estilo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filtros para Piernas -->
                        <div class="mb-4">
                            <div class="filter-title">Piernas</div>
                            <div class="mb-3">
                                <label for="color_piernas" class="form-label">Color</label>
                                <select name="color_piernas" id="color_piernas" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" 
                                            {{ request('color_piernas') == $color->id_color ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estilo_piernas" class="form-label">Estilo</label>
                                <select name="estilo_piernas" id="estilo_piernas" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" 
                                            {{ request('estilo_piernas') == $estilo->id_estilo ? 'selected' : '' }}>
                                            {{ $estilo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filtros para Pies -->
                        <div class="mb-4">
                            <div class="filter-title">Pies</div>
                            <div class="mb-3">
                                <label for="color_pies" class="form-label">Color</label>
                                <select name="color_pies" id="color_pies" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($colores as $color)
                                        <option value="{{ $color->id_color }}" 
                                            {{ request('color_pies') == $color->id_color ? 'selected' : '' }}>
                                            {{ $color->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="estilo_pies" class="form-label">Estilo</label>
                                <select name="estilo_pies" id="estilo_pies" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($estilos as $estilo)
                                        <option value="{{ $estilo->id_estilo }}" 
                                            {{ request('estilo_pies') == $estilo->id_estilo ? 'selected' : '' }}>
                                            {{ $estilo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" form="filterForm" class="btn btn-primary">Aplicar Filtros</button>
                            <a href="{{ route('outfit.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('outfit.store') }}">
            @csrf
            <input type="hidden" name="prenda_cabeza" id="prenda_cabeza">
            <input type="hidden" name="prenda_torso" id="prenda_torso">
            <input type="hidden" name="prenda_piernas" id="prenda_piernas">
            <input type="hidden" name="prenda_pies" id="prenda_pies">

            <button type="submit" class="btn btn-success mt-4">Crear Outfit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.carousel').forEach(carousel => {
                const activeItem = carousel.querySelector('.carousel-item.active');
                const prendaId = activeItem.getAttribute('data-prenda-id');
                const inputId = 'prenda_' + carousel.id.replace('carousel', '').toLowerCase();
                document.getElementById(inputId).value = prendaId;
            });
        });

        // Script para capturar la prenda seleccionada en cada carrusel
        document.querySelectorAll('.carousel').forEach(carousel => {
            carousel.addEventListener('slid.bs.carousel', function (event) {
                const activeItem = event.target.querySelector('.carousel-item.active');
                const prendaId = activeItem.getAttribute('data-prenda-id');
                const inputId = 'prenda_' + event.target.id.replace('carousel', '').toLowerCase();
                document.getElementById(inputId).value = prendaId;
            });
        });

        document.querySelector('form[action="{{ route('outfit.store') }}"]').addEventListener('submit', function (event) {
            console.log('Prenda Cabeza:', document.getElementById('prenda_cabeza').value);
            console.log('Prenda Torso:', document.getElementById('prenda_torso').value);
            console.log('Prenda Piernas:', document.getElementById('prenda_piernas').value);
            console.log('Prenda Pies:', document.getElementById('prenda_pies').value);
        });
    </script>
@endsection