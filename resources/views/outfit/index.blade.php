@extends('layouts.header')

@section('title', 'Crear Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Crea tu Outfit</h1>

        <div class="row">
            <!-- Columna izquierda: prendas organizadas por tipo -->
            <div class="col-md-4 mb-4">
                <h5>Prendas</h5>

                <!-- Filtro de Color para Torso -->
                <div class="mb-4">
                    <form action="{{ route('outfit.index') }}" method="GET">
                        <div class="mb-3">
                            <label for="color_id" class="form-label">Selecciona un color para Torso</label>
                            <select id="color_id" name="color_id" class="form-select">
                                <option value="">Todos los colores</option>
                                @foreach($colores as $color)
                                    <option value="{{ $color->id_color }}" 
                                        @if(request()->get('color_id') == $color->id_color) selected @endif>
                                        {{ $color->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                </div>

                <!-- Prenda de Cabeza -->
                <div class="mb-4">
                    <h6>Cabeza</h6>
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
                    <h6>Torso</h6>
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
                    <h6>Piernas</h6>
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
                    <h6>Pies</h6>
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
