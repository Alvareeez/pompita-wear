@extends('layouts.header')

@section('title', 'Detalles del Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/outfitSolo.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/detalles2.js') }}"></script>
@endsection
@section('content')
<div class="title-container">
    <h1 class="center-title_outfit">Outfit de {{ $outfit->usuario->nombre }}</h1>
</div>

<div class="centered-container">
    <div class="outfit-detalle">
        <h3 class="outfit-title">Outfit: {{ $outfit->nombre }}</h3>
        <div class="prendas">
            @foreach ($outfit->prendas->sortBy('tipo.id_tipoPrenda') as $prenda)
                <div class="prenda-detalle">
                    <!-- Enlace a la prenda -->
                    <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                    </a>
                    <div class="info-prenda">
                        <p><strong>{{ $prenda->nombre }}</strong></p>
                        <p>Tipo: {{ $prenda->tipo->nombre }}</p>
                        <p>Descripción: {{ $prenda->descripcion }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-outfit">
        </div>
        <button id="like-button" class="btn-like {{ $outfit->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
            data-outfit-id="{{ $outfit->id_outfit }}">
        ❤️ <span id="likes-count">{{ $outfit->likes()->count() }}</span> Likes
        </button>
        <!-- Botón de volver -->
        <div class="volver-btn-container">
            <a href="{{ route('outfit.outfits') }}" class="volver-btn">← Volver a todos los outfits</a>
        </div>
    </div>
</div>
<!-- Sección de comentarios y valoraciones (copiada y adaptada de prendas) -->
<div class="comentarios-valoraciones-container">
    <!-- Columna izquierda - Valoraciones -->
    <div class="valoraciones-columna">
        <div class="valoraciones-section">
            <div class="valoracion-header">
                <h2>Valoraciones</h2>
                <div class="valoracion-promedio">
                    <div class="promedio-numero">{{ number_format($puntuacionPromedio, 1) }}</div>
                    <div class="stars-promedio">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($puntuacionPromedio) ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </div>
                    <div class="total-valoraciones">{{ $outfit->valoraciones->count() }} valoraciones</div>
                </div>
            </div>

            @auth
            <div class="tu-valoracion">
                <h3>¿Qué te parece este outfit?</h3>
                <form action="{{ route('outfits.storeValoracion', $outfit->id_outfit) }}" method="POST">
                    @csrf
                    <div class="rating-container">
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="outfit-star{{$i}}" name="puntuacion" value="{{$i}}"
                                    {{ $puntuacionUsuario && $puntuacionUsuario->puntuacion == $i ? 'checked' : '' }}>
                                <label for="outfit-star{{$i}}" title="{{$i}} estrellas"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                        <button type="submit" class="btn-valorar">
                            <i class="fas fa-check"></i> Enviar valoración
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}" class="text-primary">Inicia sesión</a> para valorar este outfit.
            </div>
            @endauth

            <div class="lista-valoraciones">
                <h3>Opiniones recientes</h3>
                @foreach($outfit->valoraciones->take(5) as $valoracion)
                <div class="valoracion-card">
                    <div class="valoracion-user">
                        @if($valoracion->usuario->foto_perfil)
                            <img src="{{ asset($valoracion->usuario->foto_perfil) }}" 
                                 alt="{{ $valoracion->usuario->nombre }}"
                                 class="foto-perfil-valoracion">
                        @else
                            <div class="foto-perfil-default">
                                {{ substr($valoracion->usuario->nombre, 0, 1) }}
                            </div>
                        @endif
                        <div class="user-info">
                            <strong>{{ $valoracion->usuario->nombre }}</strong>
                            <small class="text-muted">{{ $valoracion->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="valoracion-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $valoracion->puntuacion ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Columna derecha - Comentarios -->
    <div class="comentarios-columna">
        <div class="comentarios-section">
            <div class="comentario-form-container">
                <h2>Deja tu comentario</h2>
                @auth
                <form action="{{ route('outfits.storeComment', $outfit->id_outfit) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="form-group">
                        <textarea name="comentario" class="form-control custom-textarea" rows="5" 
                                  placeholder="Escribe tu comentario aquí..." 
                                  required></textarea>
                        <div class="contador-caracteres">Máximo 500 caracteres</div>
                    </div>
                    <button type="submit" class="btn-comentar">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar comentario
                    </button>
                </form>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}" class="text-primary">Inicia sesión</a> para dejar un comentario.
                </div>
                @endauth
            </div>

            @foreach($outfit->comentarios as $comentario)
            <div class="comentario-card mb-3">
                <div class="comentario-content">
                    <div class="foto-comentario-container">
                        <a href="{{ route('perfil.publico', $comentario->usuario->id_usuario) }}">
                            @if($comentario->usuario->foto_perfil)
                            <img src="{{ asset($comentario->usuario->foto_perfil) }}" 
                            alt="{{ $comentario->usuario->nombre }}"
                            class="foto-perfil-valoracion">
                            @else
                                <div class="foto-perfil-default">
                                    {{ substr($comentario->usuario->nombre, 0, 1) }}
                                </div>
                            @endif
                        </a>
                    </div>
    
                    <div class="contenido-comentario">
                        <div class="cabecera-comentario">
                            <div class="user-info">
                                <strong>{{ $comentario->usuario->nombre }}</strong>
                                <span class="tiempo-comentario">{{ $comentario->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="acciones-comentario">
                                <button class="btn-like-comentario {{ $comentario->isLikedByUser(auth()->id()) ? 'liked' : '' }}" 
                                        data-comentario-id="{{ $comentario->id_comentario }}">
                                    ❤️ <span class="likes-count">{{ $comentario->likesCount() }}</span>
                                </button>
                            </div>
                        </div>
                        <p class="texto-comentario">{{ $comentario->comentario }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
