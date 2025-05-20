@extends('layouts.header')

@section('title', 'Perfil de ' . $user->nombre)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container-fluid mt-4">
        {{-- Sección móvil: seguidores/seguidos y solicitudes (solo visible en móvil) --}}
        <div class="d-md-none mb-4">
            <div class="d-flex justify-content-around text-center mb-4">
                <div>
                    <h5>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#followersModal"
                            class="text-decoration-none text-dark">
                            Seguidores
                        </a>
                    </h5>
                    <p>
                        <strong id="count-followers">{{ $numeroSeguidores }}</strong>
                    </p>
                </div>
                <div>
                    <h5>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#followingModal"
                            class="text-decoration-none text-dark">
                            Seguidos
                        </a>
                    </h5>
                    <p>
                        <strong id="count-following">{{ $numeroSeguidos }}</strong>
                    </p>
                </div>
            </div>

            @if ($user->is_private)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Solicitudes de seguimiento</h4>
                    </div>
                    <div class="card-body">
                        @if ($pendientes->isEmpty())
                            <p class="text-muted">No tienes solicitudes pendientes.</p>
                        @else
                            @foreach ($pendientes as $sol)
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <a href="{{ route('perfil.publico', $sol->emisor->id_usuario) }}"
                                        class="d-flex align-items-center text-decoration-none">
                                        <img src="{{ $sol->emisor->foto_perfil ? asset($sol->emisor->foto_perfil) : asset('img/default-profile.png') }}"
                                            class="rounded-circle me-2" width="40" height="40" alt="Avatar">
                                        <span>{{ $sol->emisor->nombre }}</span>
                                    </a>
                                    <div>
                                        <form action="{{ route('solicitudes.aceptar', $sol->id) }}" method="POST"
                                            class="d-inline">@csrf
                                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('solicitudes.rechazar', $sol->id) }}" method="POST"
                                            class="d-inline ms-2">@csrf
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            @if (Auth::check() && Auth::id() !== $user->id_usuario)
                @php
                    $isFollowing = Auth::user()->siguiendo()->where('id_receptor', $user->id_usuario)->exists();
                    $hasPending = Auth::user()
                        ->solicitudesEnviadas()
                        ->where('id_receptor', $user->id_usuario)
                        ->where('status', 'pendiente')
                        ->exists();
                @endphp
                <form action="{{ route('solicitudes.store') }}" method="POST" class="text-center my-3">
                    @csrf
                    <input type="hidden" name="id_receptor" value="{{ $user->id_usuario }}">
                    <button type="submit" class="btn btn-primary w-75"
                        {{ $isFollowing || $hasPending ? 'disabled' : '' }}>
                        @if ($isFollowing)
                            Siguiendo
                        @elseif($hasPending)
                            Pendiente
                        @else
                            Seguir
                        @endif
                    </button>
                </form>
            @endif
        </div>

        <div class="row g-4">
            {{-- Columna izquierda: perfil --}}
            <div class="col-md-6">
                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Foto de perfil --}}
                    <div class="text-center mb-3">
                        <div class="profile-picture-container mx-auto">
                            <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
                                class="profile-picture" id="profile-picture" alt="Foto de perfil">
                            <div class="profile-picture-overlay"><span>Editar foto</span></div>
                        </div>
                        <input type="file" name="foto_perfil" id="profile-picture-input" hidden>
                    </div>

                    {{-- Campos del formulario --}}
                    <div class="mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $user->nombre) }}">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" disabled name="email" id="email" class="form-control"
                            value="{{ $user->email }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password">Nueva contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation">Repetir contraseña:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Repetir contraseña">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="is_private">Privacidad de la cuenta:</label>
                        <select name="is_private" id="is_private" class="form-select">
                            <option value="0" {{ $user->is_private ? '' : 'selected' }}>Público</option>
                            <option value="1" {{ $user->is_private ? 'selected' : '' }}>Privado</option>
                        </select>
                    </div>

                    {{-- Ir a bandeja de chats --}}
                    @auth
                        <div class="mb-3 text-center">
                            <a href="{{ route('chat.inbox') }}" class="btn btn-outline-info w-75">Ir a Bandeja de Chats</a>
                        </div>
                    @endauth

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-dark w-75">Guardar cambios</button>
                    </div>
                </form>

                {{-- Outfits publicados --}}
                <h4 class="mt-5">Outfits publicados</h4>
                <div class="outfits-container">
                    @forelse($outfitsPublicados as $outfit)
                        <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                            <div class="outfit-card">
                                <p class="fw-bold">{{ $outfit->nombre }}</p>
                                <div class="prenda-column">
                                    @foreach ($outfit->prendas as $prenda)
                                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                            alt="{{ $prenda->nombre }}">
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="alert alert-info">No tienes outfits publicados aún.</div>
                    @endforelse
                </div>

                {{-- Outfits favoritos --}}
                <h4 class="mt-5">Outfits favoritos</h4>
                <div class="outfits-container">
                    @forelse($favOutfits->sortByDesc('created_at') as $outfit)
                        <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                            <div class="outfit-card">
                                <p class="fw-bold">{{ $outfit->nombre }}</p>
                                <div class="prenda-column">
                                    @foreach ($outfit->prendas as $prenda)
                                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                            alt="{{ $prenda->nombre }}">
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="alert alert-info">No tienes outfits favoritos aún.</div>
                    @endforelse
                </div>

                {{-- Prendas favoritas --}}
                <h4 class="mt-5">Prendas favoritas</h4>
                <div class="row">
                    @forelse($favorites as $fav)
                        <div class="col-md-4 mb-4">
                            <div class="card text-center">
                                <a href="{{ route('prendas.show', $fav->id_prenda) }}">
                                    <img src="{{ asset('img/prendas/' . $fav->img_frontal) }}" class="card-img-top"
                                        alt="{{ $fav->nombre }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $fav->nombre }}</h5>
                                    <p class="card-text text-muted">{{ $fav->tipo->tipo }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">No tienes prendas favoritas aún.</div>
                    @endforelse
                </div>
            </div>

            {{-- Columna derecha: seguidores/seguidos + solicitudes (solo visible en desktop) --}}
            <div class="col-md-6 d-none d-md-block">
                <div class="d-flex justify-content-around text-center mb-4">
                    <div>
                        <h5>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#followersModal"
                                class="text-decoration-none text-dark">
                                Seguidores
                            </a>
                        </h5>
                        <p>
                            <strong id="count-followers">{{ $numeroSeguidores }}</strong>
                        </p>
                    </div>
                    <div>
                        <h5>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#followingModal"
                                class="text-decoration-none text-dark">
                                Seguidos
                            </a>
                        </h5>
                        <p>
                            <strong id="count-following">{{ $numeroSeguidos }}</strong>
                        </p>
                    </div>
                </div>

                @if ($user->is_private)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Solicitudes de seguimiento</h4>
                        </div>
                        <div class="card-body">
                            @if ($pendientes->isEmpty())
                                <p class="text-muted">No tienes solicitudes pendientes.</p>
                            @else
                                @foreach ($pendientes as $sol)
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <a href="{{ route('perfil.publico', $sol->emisor->id_usuario) }}"
                                            class="d-flex align-items-center text-decoration-none">
                                            <img src="{{ $sol->emisor->foto_perfil ? asset($sol->emisor->foto_perfil) : asset('img/default-profile.png') }}"
                                                class="rounded-circle me-2" width="40" height="40"
                                                alt="Avatar">
                                            <span>{{ $sol->emisor->nombre }}</span>
                                        </a>
                                        <div>
                                            <form action="{{ route('solicitudes.aceptar', $sol->id) }}" method="POST"
                                                class="d-inline">@csrf
                                                <button class="btn btn-sm btn-success"><i
                                                        class="fas fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('solicitudes.rechazar', $sol->id) }}" method="POST"
                                                class="d-inline ms-2">@csrf
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="fas fa-times"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                @if (Auth::check() && Auth::id() !== $user->id_usuario)
                    @php
                        $isFollowing = Auth::user()->siguiendo()->where('id_receptor', $user->id_usuario)->exists();
                        $hasPending = Auth::user()
                            ->solicitudesEnviadas()
                            ->where('id_receptor', $user->id_usuario)
                            ->where('status', 'pendiente')
                            ->exists();
                    @endphp
                    <form action="{{ route('solicitudes.store') }}" method="POST" class="text-center my-3">
                        @csrf
                        <input type="hidden" name="id_receptor" value="{{ $user->id_usuario }}">
                        <button type="submit" class="btn btn-primary w-75"
                            {{ $isFollowing || $hasPending ? 'disabled' : '' }}>
                            @if ($isFollowing)
                                Siguiendo
                            @elseif($hasPending)
                                Pendiente
                            @else
                                Seguir
                            @endif
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    {{-- Modal Seguidores --}}
    <div class="modal fade" id="followersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seguidores de {{ $user->nombre }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @forelse($user->seguidores as $f)
                        <div class="d-flex align-items-center justify-content-between mb-2"
                            data-id="{{ $f->id_usuario }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ $f->foto_perfil ? asset($f->foto_perfil) : asset('img/default-profile.png') }}"
                                    width="40" height="40" class="rounded-circle me-2"
                                    alt="Avatar de {{ $f->nombre }}">
                                <a href="{{ route('perfil.publico', $f->id_usuario) }}">
                                    {{ $f->nombre }}
                                </a>
                            </div>
                            <button class="btn btn-sm btn-danger remove-follower-btn">
                                Eliminar
                            </button>
                        </div>
                    @empty
                        <p class="text-muted">Sin seguidores.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Seguidos --}}
    <div class="modal fade" id="followingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Usuarios que sigue {{ $user->nombre }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @forelse($user->siguiendo as $s)
                        <div class="d-flex align-items-center justify-content-between mb-2"
                            data-id="{{ $s->id_usuario }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ $s->foto_perfil ? asset($s->foto_perfil) : asset('img/default-profile.png') }}"
                                    width="40" height="40" class="rounded-circle me-2"
                                    alt="Avatar de {{ $s->nombre }}">
                                <a href="{{ route('perfil.publico', $s->id_usuario) }}">
                                    {{ $s->nombre }}
                                </a>
                            </div>
                            <button class="btn btn-sm btn-warning unfollow-btn">
                                Dejar de seguir
                            </button>
                        </div>
                    @empty
                        <p class="text-muted">No sigues a nadie.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.deleteProfilePictureUrl = "{{ route('perfil.deleteProfilePicture') }}";
        window.defaultImage = "{{ asset('img/default-profile.png') }}";
    </script>
    <script src="{{ asset('js/perfil.js') }}"></script>
    <script src="{{ asset('js/seguimiento.js') }}"></script>
    <script src="{{ asset('js/dejardeSeguirEliminarSeguidores.js') }}"></script>
@endsection
