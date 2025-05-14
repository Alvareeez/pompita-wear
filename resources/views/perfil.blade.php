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
  <div class="row">

    {{-- IZQUIERDA --}}
    <div class="col-md-6">
      {{-- Contadores con disparadores de modal --}}
      <div class="text-center mb-4">
        <h2>
          <a href="#" data-bs-toggle="modal" data-bs-target="#followersModal" class="text-decoration-none text-dark">
            Seguidores
          </a>
        </h2>
        <p>
          <a href="#" data-bs-toggle="modal" data-bs-target="#followersModal" class="text-decoration-none">
            <strong>{{ $numeroSeguidores }}</strong>
          </a>
        </p>

        <h2>
          <a href="#" data-bs-toggle="modal" data-bs-target="#followingModal" class="text-decoration-none text-dark">
            Seguidos
          </a>
        </h2>
        <p>
          <a href="#" data-bs-toggle="modal" data-bs-target="#followingModal" class="text-decoration-none">
            <strong>{{ $numeroSeguidos }}</strong>
          </a>
        </p>
      </div>

      {{-- Modal Seguidores --}}
      <div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="followersModalLabel">Seguidores de {{ $user->nombre }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              @if($user->seguidores->isEmpty())
                <p class="text-muted">No tienes seguidores aún.</p>
              @else
                <ul class="list-group">
                  @foreach($user->seguidores as $follower)
                    <li class="list-group-item d-flex align-items-center">
                      <img src="{{ $follower->foto_perfil
                                   ? asset($follower->foto_perfil)
                                   : asset('img/default-profile.png') }}"
                           class="rounded-circle me-2"
                           width="40" height="40" alt="Avatar">
                      <a href="{{ route('perfil.publico', $follower->id_usuario) }}"
                         class="flex-grow-1 text-decoration-none">
                        {{ $follower->nombre }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Modal Seguidos --}}
      <div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="followingModalLabel">Usuarios que sigue {{ $user->nombre }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              @if($user->siguiendo->isEmpty())
                <p class="text-muted">No sigues a nadie aún.</p>
              @else
                <ul class="list-group">
                  @foreach($user->siguiendo as $followed)
                    <li class="list-group-item d-flex align-items-center">
                      <img src="{{ $followed->foto_perfil
                                   ? asset($followed->foto_perfil)
                                   : asset('img/default-profile.png') }}"
                           class="rounded-circle me-2"
                           width="40" height="40" alt="Avatar">
                      <a href="{{ route('perfil.publico', $followed->id_usuario) }}"
                         class="flex-grow-1 text-decoration-none">
                        {{ $followed->nombre }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Solicitudes de seguimiento pendientes --}}
      <div class="card mb-4">
        <div class="card-header"><h4>Solicitudes de seguimiento</h4></div>
        <div class="card-body">
          @if($pendientes->isEmpty())
            <p class="text-muted">No tienes solicitudes pendientes.</p>
          @else
            @foreach($pendientes as $sol)
              <div class="d-flex align-items-center justify-content-between mb-3">
                <a href="{{ route('perfil.publico', $sol->emisor->id_usuario) }}"
                   class="d-flex align-items-center text-decoration-none">
                  <img src="{{ $sol->emisor->foto_perfil
                               ? asset($sol->emisor->foto_perfil)
                               : asset('img/default-profile.png') }}"
                       alt="Avatar"
                       class="rounded-circle me-2"
                       width="40" height="40">
                  <span class="fw-semibold">{{ $sol->emisor->nombre }}</span>
                </a>
                <div>
                  <form action="{{ route('solicitudes.aceptar', $sol->id) }}"
                        method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                      <i class="fas fa-check"></i>
                    </button>
                  </form>
                  <form action="{{ route('solicitudes.rechazar', $sol->id) }}"
                        method="POST" class="d-inline ms-2">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fas fa-times"></i>
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      {{-- Botón Seguir / Pendiente / Siguiendo --}}
      @if(Auth::check() && Auth::id() !== $user->id_usuario)
        @php
          $isFollowing = Auth::user()
            ->siguiendo()
            ->where('id_receptor', $user->id_usuario)
            ->exists();
          $hasPending = Auth::user()
            ->solicitudesEnviadas()
            ->where('id_receptor', $user->id_usuario)
            ->where('status', 'pendiente')
            ->exists();
        @endphp

        <form action="{{ route('solicitudes.store') }}"
              method="POST"
              class="d-inline mb-3">
          @csrf
          <input type="hidden" name="id_receptor" value="{{ $user->id_usuario }}">
          <button type="submit"
                  class="btn btn-primary"
                  {{ $isFollowing || $hasPending ? 'disabled' : '' }}>
            @if($isFollowing)
              Siguiendo
            @elseif($hasPending)
              Pendiente
            @else
              Seguir
            @endif
          </button>
        </form>
      @endif

      {{-- Formulario edición de perfil --}}
      <form action="{{ route('perfil.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="mt-4">
        @csrf
        @method('PUT')

        {{-- Foto de perfil --}}
        <div class="profile-picture-container mb-3">
          <img src="{{ $user->foto_perfil
                       ? asset($user->foto_perfil)
                       : asset('img/default-profile.png') }}"
               alt="Foto de perfil"
               class="profile-picture"
               id="profile-picture">
          <div class="profile-picture-overlay"><span>Editar foto</span></div>
        </div>
        <input type="file" name="foto_perfil" id="profile-picture-input" hidden>

        {{-- Nombre --}}
        <div class="mb-3">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" id="nombre"
                 class="form-control"
                 value="{{ old('nombre', $user->nombre) }}">
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label for="email">Email:</label>
          <input type="email" disabled name="email" id="email"
                 class="form-control"
                 value="{{ $user->email }}">
        </div>

        {{-- Contraseña --}}
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password">Nueva contraseña:</label>
            <input type="password" name="password" id="password"
                   class="form-control"
                   placeholder="Dejar en blanco para no cambiar">
          </div>
          <div class="col-md-6 mb-3">
            <label for="password_confirmation">Repetir contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control"
                   placeholder="Repetir contraseña">
          </div>
        </div>

        {{-- PRIVACIDAD --}}
        <div class="mb-3">
          <label for="is_private">Privacidad de la cuenta:</label>
          <select name="is_private" id="is_private" class="form-select">
            <option value="0" {{ $user->is_private ? '' : 'selected' }}>Público</option>
            <option value="1" {{ $user->is_private ? 'selected' : '' }}>Privado</option>
          </select>
        </div>

        {{-- Botón a bandeja de chats --}}
        @auth
          <div class="mb-3 text-center">
            <a href="{{ route('chat.inbox') }}" class="btn btn-outline-info w-75">
              Ir a Bandeja de Chats
            </a>
          </div>
        @endauth

        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-dark w-75">Guardar cambios</button>
        </div>
      </form>
    </div>

    {{-- DERECHA: Outfits y Favoritos --}}
    <div class="col-md-6">
      <h2>Mis Outfits</h2>
      <div class="outfits-published mb-4">
        <h4>Outfits publicados</h4>
        @if($outfitsPublicados->isEmpty())
          <div class="alert alert-info">No tienes outfits publicados aún.</div>
        @else
          <div class="outfits-container">
            @foreach($outfitsPublicados as $outfit)
              <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                <div class="outfit-card mb-4">
                  <div class="prenda-column">
                    <p>{{ $outfit->nombre }}</p>
                    @foreach($outfit->prendas as $prenda)
                      <img src="{{ asset('img/prendas/'.$prenda->img_frontal) }}"
                           alt="{{ $prenda->nombre }}"
                           class="vertical-image">
                    @endforeach
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>

      <div class="favorites-slider mt-4">
        <h4>Prendas favoritas</h4>
        @if($favorites->isEmpty())
          <div class="alert alert-info">No tienes prendas favoritas aún.</div>
        @else
          <div class="row">
            @foreach($favorites as $fav)
              <div class="col-md-4 mb-3">
                <div class="card">
                  <a href="{{ route('prendas.show', $fav->id_prenda) }}">
                    <img src="{{ asset('img/prendas/'.$fav->img_frontal) }}"
                         class="card-img-top"
                         alt="{{ $fav->nombre }}">
                  </a>
                  <div class="card-body">
                    <h5 class="card-title">{{ $fav->nombre }}</h5>
                    <p class="card-text">Tipo: {{ $fav->tipo->tipo }}</p>
                    <a href="{{ route('prendas.show', $fav->id_prenda) }}"
                       class="btn btn-primary btn-sm">Ver detalles</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

  </div>
</div>

<script>
  const deleteProfilePictureUrl = "{{ route('perfil.delete-picture') }}";
  const defaultProfileImage     = "{{ asset('img/default-profile.png') }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/perfil.js') }}"></script>
<script src="{{ asset('js/seguimiento.js') }}"></script>
@endsection
