@extends('layouts.header')

@section('title', 'Perfil de ' . $user->nombre)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil-publico.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('scripts')
    @parent
    <script src="{{ asset('js/perfilUsuariosCarousel.js') }}"></script>
@endsection

@section('content')
<!-- Modal para ver la foto de perfil -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- modal-xl es aún más grande que modal-lg -->
        <div class="modal-content border-0" style="background-color: transparent; box-shadow: none;">
            <div class="modal-body text-center p-0 position-relative">
                <!-- Botón de cerrar (X) -->
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>

                <!-- Imagen ampliada -->
                <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
                     alt="Foto de perfil completa"
                     class="img-fluid"
                     style="width: 500px; max-height: 400px;object-fit: contain; border-radius: 8px;">
            </div>
        </div>
    </div>
</div>
</div><div class="container perfil-p">
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
        $followState = '';
        $followText = 'Seguir';
        
        $existingFollow = $user->seguidores()
            ->where('id_seguidor', auth()->id())
            ->first();
        
        if ($existingFollow) {
            if ($existingFollow->estado == 'aceptado') {
                $followState = 'following';
                $followText = 'Siguiendo';
            } elseif ($existingFollow->estado == 'pendiente') {
                $followState = 'pending';
                $followText = 'Pendiente';
            }
        }
    @endphp
    
    <button id="follow-btn" class="follow-btn {{ $followState }}" 
            data-user-id="{{ $user->id_usuario }}" 
            data-state="{{ $followState }}">
        {{ $followText }}
        <span class="btn-loader d-none"><i class="fas fa-spinner fa-spin"></i></span>
    </button>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Inicia sesión para seguir</a>
    @endauth
    </div>

        <!-- Sección de Outfits - Carrusel 3D -->
        <div>
        @if ($user->outfits->count() <= 0)
        <div class="alert alert-info text-center">
            Este usuario aún no tiene outfits publicados.
        </div>
        @endif
        </div>
        <!-- Sección de Outfits - Carrusel 3D -->
        <div class="carousel2">
            @if($user->outfits->count() > 0)
                <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
            @endif
            
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
    </div>
</div>

@include('layouts.footer')

@endsection