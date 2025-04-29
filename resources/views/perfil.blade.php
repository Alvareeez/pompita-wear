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
                <div class="container">
                    <h2>Seguidores</h2>
                    <div class="container">
                        <h2>Seguidores</h2>
                        <p>Tienes {{ $numeroSeguidores }} seguidores.</p>
                    </div>
                </div>
                <div class="container">
                    <div class="container">
                        <h2>Seguidos</h2>
                        <p>Sigues a {{ $numeroSeguidos }} usuarios.</p>
                    </div>
                </div>
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
                    <input disabled type="email" name="email" id="email" class="form-control my-3"
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

                <!-- Outfits publicados -->
                <div class="outfits-published">
                    <h4>Outfits publicados</h4>
                    @if ($outfitsPublicados->count() > 0)
                        <div class="outfits-container">
                            @foreach ($outfitsPublicados as $outfit)
                                <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                                    <div class="outfit-card mb-4">
                                        <div class="prenda-column">
                                            <p>{{ $outfit->nombre }}</p>
                                            @foreach ($outfit->prendas->sortBy('tipo.id_tipoPrenda') as $prenda)
                                                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                                    alt="{{ $prenda->nombre }}" class="vertical-image">
                                            @endforeach
                                        </div>

                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No tienes outfits publicados aún.</div>
                    @endif
                </div>

                <!-- Prendas favoritas -->
                <div class="favorites-slider mt-4">
                    <h4>Prendas favoritas</h4>
                    @if ($favorites->count() > 0)
                        <div class="row">
                            @foreach ($favorites as $favorite)
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <a href="{{ route('prendas.show', $favorite->id_prenda) }}">
                                            <img src="{{ asset('img/prendas/' . $favorite->img_frontal) }}"
                                                alt="{{ $favorite->nombre }}" class="card-img-top">
                                        </a>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $favorite->nombre }}</h5>
                                            <p class="card-text">Tipo: {{ $favorite->tipo->nombre }}</p>
                                            <a href="{{ route('prendas.show', $favorite->id_prenda) }}"
                                                class="btn btn-primary">Ver
                                                detalles</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No tienes prendas favoritas aún.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteProfilePictureUrl = "{{ route('perfil.delete-picture') }}";
        const defaultProfileImage = "{{ asset('img/default-profile.png') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/perfil.js') }}"></script>
@endsection
