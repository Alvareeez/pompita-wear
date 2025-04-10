@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
@endsection

@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Editar Perfil</h2>
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Foto de perfil -->
                    <div class="profile-picture-container"
                        onclick="document.getElementById('profile-picture-input').click()">
                        <img src="{{ asset($user->foto_perfil ?? 'storage/profile_pictures/default.jpg') }}"
                            alt="Foto de perfil" class="profile-picture" id="profile-picture">
                        <div class="profile-picture-overlay">
                            <span>Editar foto</span>
                        </div>
                    </div>
                    <input type="file" name="foto_perfil" id="profile-picture-input" accept="image/*">

                    <!-- Nombre (único campo en tu BD) -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control my-3"
                                placeholder="Introducir nombre" value="{{ $user->nombre ?? '' }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control my-3"
                        placeholder="Introducir correo electrónico" value="{{ $user->email ?? '' }}">

                    <!-- Contraseña (opcional para edición) -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password">Nueva contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control my-3"
                                placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Repetir contraseña:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control my-3" placeholder="Repetir contraseña">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-dark w-75">Guardar cambios</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Mi Perfil</h2>

                <!-- Slider de Outfits -->
                <div class="outfit-slider">
                    <h4>Outfits publicados</h4>
                    @if ($outfitsPublicados->count() > 0)
                        <div id="outfitsCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($outfitsPublicados->chunk(3) as $key => $chunk)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <div class="row">
                                            @foreach ($chunk as $outfit)
                                                <div class="col-md-4">
                                                    <div class="carousel-card">
                                                        <img src="{{ asset($outfit->image_path) }}"
                                                            alt="{{ $outfit->name }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($outfitsPublicados->count() > 3)
                                <button class="carousel-control-prev" type="button" data-bs-target="#outfitsCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#outfitsCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">No tienes outfits publicados aún.</div>
                    @endif
                </div>

                <!-- Slider de Favoritos -->
                <div class="favorites-slider">
                    <h4>Prendas favoritas</h4>
                    @if ($favorites->count() > 0)
                        <div id="favoritesCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($favorites->chunk(3) as $key => $chunk)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <div class="row">
                                            @foreach ($chunk as $favorite)
                                                <div class="col-md-4">
                                                    <div class="carousel-card">
                                                        <img src="{{ asset('img/prendas/' . $favorite->img_frontal) }}"
                                                            alt="{{ $favorite->nombre }}" class="d-block w-100">
                                                        <p class="text-center mt-2">
                                                            <strong>{{ $favorite->nombre }}</strong>
                                                        </p>
                                                        <p class="text-center">€{{ number_format($favorite->precio, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($favorites->count() > 3)
                                <button class="carousel-control-prev" type="button" data-bs-target="#favoritesCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#favoritesCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">No tienes prendas favoritas aún.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar la imagen seleccionada con ajuste de tamaño
        document.getElementById('profile-picture-input').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                const imgElement = document.getElementById('profile-picture');

                reader.onload = function(event) {
                    // Crear una imagen temporal para calcular las dimensiones
                    const tempImg = new Image();
                    tempImg.src = event.target.result;

                    tempImg.onload = function() {
                        const containerWidth = 150; // Ancho del contenedor
                        const containerHeight = 150; // Alto del contenedor

                        // Calcular relación de aspecto
                        const imgRatio = tempImg.width / tempImg.height;
                        const containerRatio = containerWidth / containerHeight;

                        // Ajustar según la relación de aspecto
                        if (imgRatio > containerRatio) {
                            imgElement.style.width = '100%';
                            imgElement.style.height = 'auto';
                        } else {
                            imgElement.style.width = 'auto';
                            imgElement.style.height = '100%';
                        }

                        imgElement.src = event.target.result;
                    };
                }

                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Inicializar los carruseles con intervalo
        document.addEventListener('DOMContentLoaded', function() {
            @if ($outfitsPublicados->count() > 0)
                const outfitCarousel = new bootstrap.Carousel(document.getElementById('outfitsCarousel'), {
                    interval: 5000,
                    wrap: true
                });
            @endif

            @if ($favorites->count() > 0)
                const favoritesCarousel = new bootstrap.Carousel(document.getElementById('favoritesCarousel'), {
                    interval: 5000,
                    wrap: true
                });
            @endif
        });
    </script>
@endsection
