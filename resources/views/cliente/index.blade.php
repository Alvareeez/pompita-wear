@extends('layouts.header')

@section('title', 'Página de Inicio')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/cookie-consent.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
    <!-- Carrusel -->
    <div class="carousel-container">
        <div class="carousel">
            <img src="{{ asset('img/carrousel3.png') }}" alt="Imagen 1" class="carousel-image">
            <img src="{{ asset('img/carrousel2.png') }}" alt="Imagen 2" class="carousel-image">
            <img src="{{ asset('img/carrousel1.png') }}" alt="Imagen 3" class="carousel-image">
            <img src="{{ asset('img/carrousel4.png') }}" alt="Imagen 4" class="carousel-image">
        </div>
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
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Prendas más likes" class="small-image">
                        </a>
                        <div class="prenda-info">
                            <span class="likes">❤️ {{ $prenda->likes_count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="image-row">
                @foreach ($prendasPopulares->slice(3, 2) as $prenda)
                    <div class="prenda-item">
                        <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Prendas más likes" class="small-image">
                        </a>
                        <div class="prenda-info">
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
                                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}" class="vertical-image">
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

    <!-- Carrusel 3D de usuarios -->
    <div class="carousel-container-3d">
        <h2 class="section-title">Perfiles 👗✨</h2>
        <div class="carousel-3d">
            @foreach($usuariosRecientes as $usuario)
                <a href="{{ route('perfil.publico', $usuario->id_usuario) }}" class="item-3d">
                    <img src="{{ asset(($usuario->foto_perfil ?? 'img/default-profile.png')) }}" alt="{{ $usuario->nombre }}" class="profile-img-3d">
                    <p class="profile-name-3d">{{ $usuario->nombre }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Sección del clima mejorada -->
<div class="weather-section" >
    <div id="weather-card-trigger" style="display: inline-block; cursor: pointer;">
        <div class="card-time-cloud" id="weather-card">
            <div class="card-time-cloud-front"></div>
            <div class="card-time-cloud-back">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill="#FFFFFF"
                        d="M32.4,-41C45.2,-42.2,61,-38.6,63.9,-29.9C66.8,-21.2,56.8,-7.2,47.5,1.7C38.2,10.6,29.6,14.4,26.3,28.4C22.9,42.3,24.7,66.4,18.4,73C12,79.7,-2.5,68.8,-19.2,64.4C-35.9,60,-54.8,61.9,-56.2,52.9C-57.7,43.8,-41.7,23.7,-37.5,9.4C-33.3,-5,-41,-13.6,-44.4,-26.2C-47.8,-38.7,-47,-55.2,-38.9,-56.2C-30.7,-57.2,-15.4,-42.7,-2.8,-38.3C9.8,-34,19.6,-39.8,32.4,-41Z"
                        transform="translate(100 100)"
                    ></path>
                </svg>
            </div>
            <div class="card-time-cloud-rain-group">
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
                <div class="card-time-cloud-rain"></div>
            </div>
            <p class="card-time-cloud-day" id="weather-card-day">--</p>
            <p class="card-time-cloud-day-number" id="weather-card-date">--/--/----</p>
            <p class="card-time-cloud-hour" id="weather-card-hour">--:--</p>
            <div class="card-time-cloud-icon" id="weather-card-icon"></div>
        </div>
        <p style="margin-top:10px;color:#888;font-size:15px;">Haz clic para ver el pronóstico</p>
    </div>
    <div id="weather-content" class="weather-content hidden" style="margin-top: 30px;">
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
        <div class="forecast" id="forecast-container"></div>
        <button id="close-weather" class="weather-button" style="margin-top: 20px;">Cerrar</button>
    </div>
</div>

<!-- Modal del clima -->
<div id="day-modal" class="modal">
    <div class="modal-content">
        <span id="close-modal" class="close">&times;</span>
        <h3 id="modal-day-title">Detalles del día</h3>
        <div id="modal-day-details"></div>
    </div>
</div>
<br>
@include('layouts.footer')
<x-cookie-banner />
@endsection
