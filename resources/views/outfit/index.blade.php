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

                <!-- Filtro por Color para cada tipo de prenda -->
                <form id="filter-form">
                    <div class="mb-3">
                        <label for="color" class="form-label">Filtrar por color</label>
                        <select class="form-select" id="color" name="color_id">
                            <option value="">Selecciona un color</option>
                            @foreach($colores as $color)
                                <option value="{{ $color->id_color }}">{{ $color->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <!-- Prenda de Cabeza -->
                <div class="mb-4">
                    <h6>Cabeza</h6>
                    <div id="carouselCabeza" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-cabeza">
                            @foreach($prendasCabeza as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Prenda de Torso -->
                <div class="mb-4">
                    <h6>Torso</h6>
                    <div id="carouselTorso" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-torso">
                            @foreach($prendasTorso as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Prenda de Piernas -->
                <div class="mb-4">
                    <h6>Piernas</h6>
                    <div id="carouselPiernas" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-piernas">
                            @foreach($prendasPiernas as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Prenda de Pies -->
                <div class="mb-4">
                    <h6>Pies</h6>
                    <div id="carouselPies" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-pies">
                            @foreach($prendasPies as $prenda)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" class="d-block w-100" alt="{{ $prenda->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Información adicional si es necesario -->
            <div class="col-md-8">
                <!-- Aquí podrías agregar más detalles como información de precio, descripción, etc. -->
            </div>
        </div>
    </div>

    <script>
        // Detectar el cambio de color y actualizar el carousel
        document.getElementById('color').addEventListener('change', function (e) {
            var colorId = e.target.value;
            var tipoPrenda = 'CABEZA';  // Cambiar dinámicamente según el tipo de prenda seleccionado

            // Hacer una solicitud AJAX para obtener las prendas filtradas por color
            fetch('/filtrar-prendas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ color_id: colorId, tipo_prenda: tipoPrenda })
            })
            .then(response => response.json())
            .then(prendas => {
                // Aquí actualizas los carouseles con las prendas filtradas
                let carouselContainer = document.getElementById('carousel-cabeza');
                carouselContainer.innerHTML = ''; // Vaciar el contenido actual

                prendas.forEach(prenda => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('carousel-item');
                    itemDiv.innerHTML = `
                        <img src="/img/prendas/${prenda.img_frontal}" class="d-block w-100" alt="${prenda.nombre}">
                    `;
                    carouselContainer.appendChild(itemDiv);
                });
            });
        });
    </script>
@endsection
