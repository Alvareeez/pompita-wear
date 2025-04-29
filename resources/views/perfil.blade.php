@extends('layouts.header')

@section('title', 'Mi Perfil')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                    <div class="profile-picture-container">
                        <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
                            alt="Foto de perfil" class="profile-picture" id="profile-picture">
                        <div class="profile-picture-overlay">
                            <span>Editar foto</span>
                        </div>
                    </div>
                    <input type="file" name="foto_perfil" id="profile-picture-input" accept="image/*"
                        style="display: none;">

                    <!-- Nombre -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control my-3"
                                placeholder="Introducir nombre" value="{{ old('nombre', $user->nombre ?? '') }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control my-3"
                        placeholder="Introducir correo electrónico" value="{{ old('email', $user->email ?? '') }}">

                    <!-- Contraseña -->
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
                                                            alt="{{ $outfit->name }}" class="img-fluid">
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
                                                        <a href="{{ route('prendas.show', $favorite->id_prenda) }}">
                                                            <img src="{{ asset('img/prendas/' . $favorite->img_frontal) }}"
                                                                alt="{{ $favorite->nombre }}" class="img-fluid">
                                                        </a>
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
        window.deleteProfilePictureUrl = "{{ route('perfil.delete-picture') }}"; // Corregido
        window.defaultProfileImage = "{{ asset('img/default-profile.png') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/perfil.js') }}"></script>
@endsection
