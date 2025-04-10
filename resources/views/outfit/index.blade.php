@extends('layouts.header')

@section('title', 'Crear Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .filter-group {
            margin-bottom: 15px;
        }
        .badge-filter {
            font-size: 0.75rem;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Crea tu Outfit</h1>

        <!-- Formulario de Filtros -->
        <form method="GET" action="{{ route('outfit.index') }}" class="mb-4">
            <div class="filter-section">
                <!-- Filtros por Color -->
                <div class="filter-group">
                    <div class="filter-title">Filtrar por colores</div>
                    <div class="row g-3">
                        <!-- Filtro para Cabeza -->
                        <div class="col-md-3">
                            <label for="color_cabeza" class="form-label">Color Cabeza</label>
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

                        <!-- Filtro para Torso -->
                        <div class="col-md-3">
                            <label for="color_torso" class="form-label">Color Torso</label>
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

                        <!-- Filtro para Piernas -->
                        <div class="col-md-3">
                            <label for="color_piernas" class="form-label">Color Piernas</label>
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

                        <!-- Filtro para Pies -->
                        <div class="col-md-3">
                            <label for="color_pies" class="form-label">Color Pies</label>
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
                    </div>
                </div>

                <!-- Filtros por Estilo -->
                <div class="filter-group">
                    <div class="filter-title">Filtrar por estilos</div>
                    <div class="row g-3">
                        <!-- Filtro para Cabeza -->
                        <div class="col-md-3">
                            <label for="estilo_cabeza" class="form-label">Estilo Cabeza</label>
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

                        <!-- Filtro para Torso -->
                        <div class="col-md-3">
                            <label for="estilo_torso" class="form-label">Estilo Torso</label>
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

                        <!-- Filtro para Piernas -->
                        <div class="col-md-3">
                            <label for="estilo_piernas" class="form-label">Estilo Piernas</label>
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

                        <!-- Filtro para Pies -->
                        <div class="col-md-3">
                            <label for="estilo_pies" class="form-label">Estilo Pies</label>
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
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <a href="{{ route('outfit.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="row">
            <!-- Columna izquierda: prendas organizadas por tipo -->
            <div class="col-md-4 mb-4">
                <h5>Prendas</h5>

                <!-- Prenda de Cabeza -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Cabeza</h6>
                        <div>
                            @if(request('color_cabeza'))
                                <span class="badge bg-info badge-filter">Color</span>
                            @endif
                            @if(request('estilo_cabeza'))
                                <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                            @endif
                        </div>
                    </div>
                    <div id="carouselCabeza" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach($prendasCabeza as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
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
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Torso</h6>
                        <div>
                            @if(request('color_torso'))
                                <span class="badge bg-info badge-filter">Color</span>
                            @endif
                            @if(request('estilo_torso'))
                                <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                            @endif
                        </div>
                    </div>
                    <div id="carouselTorso" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach($prendasTorso as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
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
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Piernas</h6>
                        <div>
                            @if(request('color_piernas'))
                                <span class="badge bg-info badge-filter">Color</span>
                            @endif
                            @if(request('estilo_piernas'))
                                <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                            @endif
                        </div>
                    </div>
                    <div id="carouselPiernas" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach($prendasPiernas as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
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
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Pies</h6>
                        <div>
                            @if(request('color_pies'))
                                <span class="badge bg-info badge-filter">Color</span>
                            @endif
                            @if(request('estilo_pies'))
                                <span class="badge bg-warning text-dark badge-filter">Estilo</span>
                            @endif
                        </div>
                    </div>
                    <div id="carouselPies" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach($prendasPies as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
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

            <!-- Columna derecha: Información adicional si es necesario -->
            <div class="col-md-8">
                <!-- Aquí podrías agregar más detalles como información de precio, descripción, etc. -->
            </div>
        </div>
    </div>
@endsection