@extends('layouts.header')

@section('title', 'Perfil de ' . $user->nombre)

@section('css')
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Metadatos para AJAX --}}
  <meta name="csrf-token"    content="{{ csrf_token() }}">
  <meta name="base-url"       content="{{ url('') }}">
  <meta name="is-private"     content="{{ $user->is_private ? '1' : '0' }}">
  {{-- URL para comprobar seguimiento mutuo --}}
  <meta name="mutual-url"     content="{{ route('perfil.checkMutual', ['other' => $user->id_usuario]) }}">
  {{-- Plantilla de URL de chat --}}
  <meta name="chat-url-tmpl"  content="{{ url('/chat/{other}') }}">
@endsection

@section('scripts')
  @parent
  <script src="{{ asset('js/perfilUsuariosCarousel.js') }}"></script>
  <script src="{{ asset('js/solicitudesAJAX.js') }}"></script>
@endsection

@section('content')
@php
    $me = auth()->user();
    $req = $me
            ? $me->solicitudesEnviadas()
                 ->where('id_receptor', $user->id_usuario)
                 ->first()
            : null;
    $status = optional($req)->status; // 'pendiente', 'aceptada' o null
@endphp

<div class="container perfil-p text-center py-4">
  {{-- Foto, nombre y contadores --}}
  <div class="mb-3">
    <div class="profile-picture-container mx-auto" data-bs-toggle="modal" data-bs-target="#perfilModal" style="cursor:pointer;">
      <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
           class="profile-picture rounded-circle"
           alt="Foto de perfil">
    </div>
    <h2 class="mt-3">{{ $user->nombre }}</h2>
    <p class="text-muted">
      <span id="followers-count">{{ $user->seguidores()->count() }}</span> seguidores •
      {{ $user->siguiendo()->count() }} seguidos
    </p>
  </div>

  {{-- Botón Seguir / Pendiente / Siguiendo --}}
  @auth
    @if($me->id_usuario !== $user->id_usuario)
      <div>
        <button id="solicitud-btn"
                class="btn {{ $status === 'aceptada'
                             ? 'btn-success'
                             : ($status === 'pendiente' ? 'btn-warning' : 'btn-primary') }}"
                data-user-id="{{ $user->id_usuario }}"
                @if($status)
                  data-solicitud-id="{{ $req->id }}"
                  data-status="{{ $status }}"
                @endif>
          {{ $status === 'aceptada'
             ? 'Siguiendo'
             : ($status === 'pendiente' ? 'Pendiente' : 'Seguir') }}
        </button>
      </div>
    @endif
  @endauth

  {{-- Donde insertaremos el botón “Chatear” desde JS --}}
  <div id="chat-btn-container" class="mt-2"></div>

  {{-- Modal para ver la foto ampliada --}}
  <div class="modal fade" id="perfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body text-center position-relative p-0">
          <button type="button"
                  class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                  data-bs-dismiss="modal"></button>
          <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
               class="img-fluid"
               style="max-width:80%; object-fit:contain; border-radius:8px;">
        </div>
      </div>
    </div>
  </div>

  {{-- Outfits o aviso de privado --}}
  <div id="outfits-section">
    @php
      $canView = !$user->is_private
                 || ($me && $me->id_usuario === $user->id_usuario)
                 || $status === 'aceptada';
    @endphp

    @if($canView)
      @if($user->outfits->isEmpty())
        <div class="alert alert-info mt-4">
          Este usuario aún no tiene outfits publicados.
        </div>
      @else
                <!-- Sección de Outfits - Carrusel 3D -->
                <div class="carousel2">
                    <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>

                    <ul class="carousel__list">
                        @foreach($user->outfits as $key => $outfit)
                            <li class="carousel__item" data-pos="{{ $key }}">
                                <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
                                    <div class="outfit-card">
                                        <p class="profile-name">{{ $outfit->nombre }}</p>
                                        <div class="prenda-column">
                                            @foreach($outfit->prendas as $prenda)
                                                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                                                    alt="{{ $prenda->nombre }}"
                                                    class="vertical-image">
                                            @endforeach
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
                </div>    
            </div>
        </div>      
    @endif
    @else
      <div class="alert alert-warning mt-4">
        Esta cuenta es privada. Envía una solicitud para ver su contenido.
      </div>
    @endif
  </div>
</div>

@include('layouts.footer')
@endsection
