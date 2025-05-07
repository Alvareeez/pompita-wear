@extends('layouts.header')

@section('title', 'Perfil de ' . $user->nombre)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/perfilUsuariosCarousel.js') }}"></script>
@endsection

@section('content')
<!-- Modal para ver la foto de perfil -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0" style="background-color: transparent; box-shadow: none;">
      <div class="modal-body text-center p-0 position-relative">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
        <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
             alt="Foto de perfil completa"
             class="img-fluid"
             style="width: 500px; max-height: 400px;object-fit: contain; border-radius: 8px;">
      </div>
    </div>
  </div>
</div>

<div class="container perfil-p">
  <div class="text-center mb-4">
    <div class="profile-picture-container mx-auto" data-bs-toggle="modal" data-bs-target="#perfilModal" style="cursor: pointer;">
      <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
           alt="Foto de perfil" class="profile-picture" id="profile-picture">
    </div>
    <h2 class="mt-3">{{ $user->nombre }}</h2>
    <p class="text-muted">Este usuario tiene {{ $user->outfits->count() }} outfit(s)</p>

    @auth
      @if(auth()->id() !== $user->id_usuario)
        @php
          $existingFollow = $user->seguidores()
            ->where('id_seguidor', auth()->id())
            ->first();
          $isAccepted = $existingFollow && $existingFollow->estado === 'aceptado';
          $followState = $isAccepted ? 'following' : ($existingFollow ? 'pending' : '');
          $followText  = $isAccepted ? 'Siguiendo' : ($existingFollow ? 'Pendiente' : 'Seguir');
        @endphp
        <button id="follow-btn" class="follow-btn {{ $followState }}"
                data-user-id="{{ $user->id_usuario }}"
                data-state="{{ $followState }}">
          {{ $followText }}
          <span class="btn-loader d-none"><i class="fas fa-spinner fa-spin"></i></span>
        </button>
      @else
        {{-- Your own profile --}}
      @endif
    @else
      <a href="{{ route('login') }}" class="btn btn-primary">Inicia sesión para seguir</a>
    @endauth

    @php
      // Determinar si puede ver outfits
      $canView = ! $user->is_private
                 || auth()->id() === $user->id_usuario
                 || (isset($isAccepted) && $isAccepted);
    @endphp

    @unless($canView)
      <div class="alert alert-warning mt-3">
        Este perfil es privado. Síguelo para ver su contenido.
      </div>
    @endunless

  </div>

  @if($canView)
    @if($user->outfits->isEmpty())
      <div class="alert alert-info text-center">
        Este usuario aún no tiene outfits publicados.
      </div>
    @else
      <div class="carousel2">
        <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
        <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
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
      </div>
    @endif
  @endif

</div>

@include('layouts.footer')
@endsection
