@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
@endsection

@section('content')


    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Columna izquierda - Carruseles (50%) -->
            <div class="col-md-6">
                <h1 class="text-center mb-4">Tu Outfit</h1>

                <!-- Carrusel Cabeza -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cabeza</h4>
                    </div>
                    <div class="card-body">
                        <div id="carruselCabeza" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/300x200?text=Cabeza+1" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Cabeza+2" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Cabeza+3" class="d-block w-100"
                                        alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselCabeza"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselCabeza"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carrusel Torso -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Torso</h4>
                    </div>
                    <div class="card-body">
                        <div id="carruselTorso" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/300x200?text=Torso+1" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Torso+2" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Torso+3" class="d-block w-100"
                                        alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselTorso"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselTorso"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carrusel Piernas -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Piernas</h4>
                    </div>
                    <div class="card-body">
                        <div id="carruselPiernas" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/300x200?text=Piernas+1" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Piernas+2" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Piernas+3" class="d-block w-100"
                                        alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselPiernas"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselPiernas"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carrusel Pies -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Pies</h4>
                    </div>
                    <div class="card-body">
                        <div id="carruselPies" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://via.placeholder.com/300x200?text=Pies+1" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Pies+2" class="d-block w-100"
                                        alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://via.placeholder.com/300x200?text=Pies+3" class="d-block w-100"
                                        alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselPies"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselPies"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Filtros (50%) -->
            <div class="col-md-6">
                <h1 class="mb-4">Crea tu outfit!</h1>

                <!-- Filtros generales (toda la fila) -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filtros generales</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="estilo" class="form-label">Selecciona tu estilo</label>
                                    <select class="form-control" name="estilo" id="estilo">
                                        <option value="">Todos los estilos</option>
                                        <option value="casual">Casual</option>
                                        <option value="formal">Formal</option>
                                        <option value="deportivo">Deportivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros por categoría (2 por fila) -->
                <div class="row mb-4">
                    <!-- Cabeza -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Cabeza</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="prendaCabeza" class="form-label">Prenda:</label>
                                    <select class="form-control" name="prendaCabeza" id="prendaCabeza">
                                        <option value="" selected disabled>Selecciona una prenda</option>
                                        <option value="gorra">Gorra</option>
                                        <option value="sombrero">Sombrero</option>
                                        <option value="bufanda">Bufanda</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoPrendaCabeza" class="form-label">Tipo de prenda:</label>
                                    <select class="form-control" name="tipoPrendaCabeza" id="tipoPrendaCabeza">
                                        <option value="" selected disabled>Selecciona un tipo</option>
                                        <option value="invierno">Invierno</option>
                                        <option value="verano">Verano</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Torso -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0">Torso</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="prendaTorso" class="form-label">Prenda:</label>
                                    <select class="form-control" name="prendaTorso" id="prendaTorso">
                                        <option value="" selected disabled>Selecciona una prenda</option>
                                        <option value="camiseta">Camiseta</option>
                                        <option value="camisa">Camisa</option>
                                        <option value="chaqueta">Chaqueta</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoPrendaTorso" class="form-label">Tipo de prenda:</label>
                                    <select class="form-control" name="tipoPrendaTorso" id="tipoPrendaTorso">
                                        <option value="" selected disabled>Selecciona un tipo</option>
                                        <option value="corta">Manga corta</option>
                                        <option value="larga">Manga larga</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Piernas -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-warning text-dark">
                                <h4 class="mb-0">Piernas</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="prendaPiernas" class="form-label">Prenda:</label>
                                    <select class="form-control" name="prendaPiernas" id="prendaPiernas">
                                        <option value="" selected disabled>Selecciona una prenda</option>
                                        <option value="pantalon">Pantalón</option>
                                        <option value="shorts">Shorts</option>
                                        <option value="falda">Falda</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoPrendaPiernas" class="form-label">Tipo de prenda:</label>
                                    <select class="form-control" name="tipoPrendaPiernas" id="tipoPrendaPiernas">
                                        <option value="" selected disabled>Selecciona un tipo</option>
                                        <option value="vaquero">Vaquero</option>
                                        <option value="deportivo">Deportivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pies -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h4 class="mb-0">Pies</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="prendaPies" class="form-label">Prenda:</label>
                                    <select class="form-control" name="prendaPies" id="prendaPies">
                                        <option value="" selected disabled>Selecciona una prenda</option>
                                        <option value="zapatos">Zapatos</option>
                                        <option value="sandalias">Sandalias</option>
                                        <option value="botas">Botas</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tipoPrendaPies" class="form-label">Tipo de prenda:</label>
                                    <select class="form-control" name="tipoPrendaPies" id="tipoPrendaPies">
                                        <option value="" selected disabled>Selecciona un tipo</option>
                                        <option value="formal">Formal</option>
                                        <option value="casual">Casual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-primary btn-lg w-100">Guardar Outfit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
