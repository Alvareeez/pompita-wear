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
<div class="container perfil-p">
        <div class="text-center mb-4">
            <div class="profile-picture-container mx-auto">
                <img src="{{ $user->foto_perfil ? asset($user->foto_perfil) : asset('img/default-profile.png') }}"
                    alt="Foto de perfil" class="profile-picture" id="profile-picture">
            </div>
            <h2 class="mt-3">{{ $user->nombre }}</h2>
            <p class="text-muted">Este usuario tiene {{ $user->outfits->count() }} outfit(s)</p>
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
                                <p class="likes-footer">❤️ {{ $outfit->likes_count }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        
            <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
        </div>    
    </div>
</div>

@include('layouts.footer')

@endsection