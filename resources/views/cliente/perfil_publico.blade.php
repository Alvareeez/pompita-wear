@extends('layouts.header')

@section('title', 'Perfil de ' . $user->nombre)

@section('css')
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Meta para CSRF y base_url --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url"   content="{{ url('') }}">
@endsection

@section('scripts')
  @parent
  <script src="{{ asset('js/perfilUsuariosCarousel.js') }}"></script>
  <script src="{{ asset('js/solicitudesAJAX.js') }}"></script>
@endsection

@section('content')
@php
    $req    = auth()->check()
              ? auth()->user()
                    ->solicitudesEnviadas()
                    ->where('id_receptor', $user->id_usuario)
                    ->first()
              : null;
    $status = optional($req)->status; // 'pendiente', 'aceptada' o null

    $canView = ! $user->is_private
               || (auth()->check() && auth()->id() === $user->id_usuario)
               || $status === 'aceptada';
@endphp

<div class="container perfil-p text-center py-4">
  {{-- Foto y modal --}}
  <div class="mb-3">
    <div class="profile-picture-container mx-auto" data-bs-toggle="modal" data-bs-target="#perfilModal"
         style="cursor:pointer;">
      <img src="{{ $user->foto_perfil
                   ? asset($user->foto_perfil)
                   : asset('img/default-profile.png') }}"
           class="profile-picture rounded-circle" alt="Foto de perfil">
    </div>
    <h2 class="mt-3">{{ $user->nombre }}</h2>
    <p class="text-muted">
      {{ $user->seguidores()->count() }} seguidores •
      {{ $user->siguiendo()->count() }} seguidos
    </p>

    @auth
      @if(auth()->id() !== $user->id_usuario)
        <button id="solicitud-btn"
                class="btn {{ $status === 'aceptada' ? 'btn-success' : ($status === 'pendiente' ? 'btn-warning' : 'btn-primary') }}"
                data-user-id="{{ $user->id_usuario }}"
                @if($status)
                  data-solicitud-id="{{ $req->id }}"
                  data-status="{{ $status }}"
                @endif>
          {{ $status === 'aceptada' 
             ? 'Siguiendo'
             : ($status === 'pendiente' ? 'Pendiente' : 'Seguir') }}
        </button>
      @endif
    @else
      <a href="{{ route('login') }}" class="btn btn-primary">Inicia sesión para seguir</a>
    @endauth
  </div>

  {{-- Modal foto --}}
  <div class="modal fade" id="perfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body text-center position-relative p-0">
          <button type="button"
                  class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                  data-bs-dismiss="modal"></button>
          <img src="{{ $user->foto_perfil
                       ? asset($user->foto_perfil)
                       : asset('img/default-profile.png') }}"
               class="img-fluid" style="max-width:80%; object-fit:contain; border-radius:8px;">
        </div>
      </div>
    </div>
  </div>

  @if($canView)
    @if($user->outfits->isEmpty())
      <div class="alert alert-info mt-4">Este usuario aún no tiene outfits publicados.</div>
    @else
      <div class="carousel2 mt-4">
        <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
        <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
        <ul class="carousel__list">
          @foreach($user->outfits as $key => $outfit)
            <li class="carousel__item" data-pos="{{ $key }}">
              <a href="{{ route('outfit.show', $outfit->id_outfit) }}">
                <div class="outfit-card">
                  <p class="profile-name">{{ $outfit->nombre }}</p>
                  <div class="prenda-column">
                    @foreach($outfit->prendas as $prenda)
                      <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                           alt="{{ $prenda->nombre }}" class="vertical-image">
                    @endforeach
                  </div>
                </div>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  @else
    <div class="alert alert-warning mt-4">
      Esta cuenta es privada. Envía una solicitud para ver su contenido.
    </div>
  @endif
</div>

@include('layouts.footer')
@endsection
