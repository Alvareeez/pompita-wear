@extends('layouts.header')

@section('title', 'Página de Inicio')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">

@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        
    </script>
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Carrusel -->
        <div class="carousel-container">
            <div class="carousel">
                <img src="{{ asset('img/carrousel1.png') }}" alt="Imagen 1" class="carousel-image active">
                <img src="{{ asset('img/carrousel2.png') }}" alt="Imagen 2" class="carousel-image">
                <img src="{{ asset('img/carrousel3.png') }}" alt="Imagen 3" class="carousel-image">
                <img src="{{ asset('img/carrousel4.png') }}" alt="Imagen 4" class="carousel-image">
            </div>
        </div>

        <!-- Fila de botones -->
        <div class="button-row">
            <a href="{{ route('prendas.index') }}" class="action-button">Prendas</a>
            <a href="{{ route('outfit.index') }}" class="action-button">Crea tu outfit</a>
            <a href="{{ route('outfit.outfits') }}" class="action-button">Outfits</a>
            <a href="{{ route('calendario') }}" class="action-button">Calendario</a>
        </div>

        <!-- Contenido principal: Prendas y Outfits -->
        <div class="content-row">
            <!-- Columna izquierda - Prendas -->
            <div class="content-column left-column">
                <h2 class="section-title">Tendencias En Prendas 🔥</h2>
                <div class="image-row">
                    @foreach ($prendasPopulares->take(3) as $prenda)
                        <div class="prenda-item">
                            <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Prendas más likes"
                                    class="small-image">
                            </a>
                            <div class="prenda-info">
                                <span class="precio">€{{ number_format($prenda->precio, 2) }}</span>
                                <span class="likes">❤️ {{ $prenda->likes_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="image-row">
                    @foreach ($prendasPopulares->slice(3, 2) as $prenda)
                        <div class="prenda-item">
                            <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Prendas más likes"
                                    class="small-image">
                            </a>
                            <div class="prenda-info">
                                <span class="precio">€{{ number_format($prenda->precio, 2) }}</span>
                                <span class="likes">❤️ {{ $prenda->likes_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Columna derecha - Outfits -->
            <div class="content-column right-column">
                <h2 class="section-title">Tendencias En Outfits 🔥</h2>
                <div class="outfits-container">
                    @foreach ($outfitsPopulares as $outfit)
                        <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                            <div class="outfit-card">
                                <div class="prenda-column">
                                    <p>{{ $outfit->nombre }}</p>
                                    @foreach ($outfit->prendas->sortBy('tipo.id_tipoPrenda') as $prenda)
                                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                            alt="{{ $prenda->nombre }}" class="vertical-image">
                                    @endforeach
                                </div>
                                <div class="outfit-creator-container">
                                    <p class="outfit-creator">Por: {{ $outfit->usuario->nombre }}</p>
                                </div>
                                <div class="likes-footer">
                                    ❤️ {{ $outfit->likes_count }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>



    <!-- Sección de usuarios - Carrusel 3D (ahora debajo de todo) -->
    <div class="carousel-container-3d">
        <h2 class="section-title">Perfiles 👗✨</h2>
        <div class="carousel-3d">
            @foreach($usuariosRecientes as $usuario)
            <a href="{{ route('perfil.publico', $usuario->id_usuario) }}" class="item-3d">        
            <img src="{{ asset(($usuario->foto_perfil ?? 'default.png')) }}" 
             alt="{{ $usuario->nombre }}" 
             class="profile-img-3d">
        <p class="profile-name-3d">{{ $usuario->nombre }}</p>
    </a>
@endforeach
        </div>

    </div>

    </div>
        <!-- Sección del clima -->
        <div class="weather-section">
            <button id="toggle-weather" class="weather-button">Ver el tiempo</button>
            <div id="weather-content" class="weather-content hidden">
                <div class="weather-info">
                    <div class="left-side">
                        <div class="icon">
                            <img id="weather-icon" src="" alt="Weather Icon">
                        </div>
                        <p id="weather-description">Cargando...</p>
                    </div>
                    <div class="right-side">
                        <div class="location">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="#ffffff" width="20px">
                                <path d="M32,0C18.746,0,8,10.746,8,24c0,5.219,1.711,10.008,4.555,13.93c0.051,0.094,0.059,0.199,0.117,0.289l16,24 C29.414,63.332,30.664,64,32,64s2.586-0.668,3.328-1.781l16-24c0.059-0.09,0.066-0.195,0.117-0.289C54.289,34.008,56,29.219,56,24 C56,10.746,45.254,0,32,0z M32,32c-4.418,0-8-3.582-8-8s3.582-8,8-8s8,3.582,8,8S36.418,32,32,32z"></path>
                            </svg>
                            <span id="location">Cargando ubicación...</span>
                        </div>
                        <p id="current-date"></p>
                        <p class="temperature" id="current-temperature">--°C</p>
                    </div>
                </div>
                <div class="forecast" id="forecast-container">
                    <!-- Los recuadros de los días se generarán dinámicamente aquí -->
                </div>
            </div>
        </div>

        <!-- Modal para mostrar detalles del día -->
        <div id="day-modal" class="modal">
            <div class="modal-content">
                <span id="close-modal" class="close">&times;</span>
                <h3 id="modal-day-title">Detalles del día</h3>
                <div id="modal-day-details">
                    <!-- Aquí se cargará la información del día -->
                </div>
            </div>
        </div>
    @include('layouts.footer')

@endsection
