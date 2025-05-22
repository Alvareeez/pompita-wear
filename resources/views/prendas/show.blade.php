@extends('layouts.header')

@section('title', 'Detalles de la Prenda')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleDetalles.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/detalles.js') }}"></script>
@endsection
@section('content')
    <div class="container mt-4">
        <div class="prenda-detalle">
            <div class="prenda-imagenes">
                <div class="imagenes-container">
                         <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" 
                         alt="Vista trasera" 
                         class="imagen-detalle">
                    @if($prenda->img_trasera)
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" 
                         alt="Vista frontal" 
                         class="imagen-detalle">
                    @endif
                </div>
            </div>
            
            <div class="prenda-info">
                <h1>{{ $prenda->nombre }}</h1>
                
                <p class="descripcion">{{ $prenda->descripcion }}</p>
                
                <button id="like-button" class="btn-like {{ $prenda->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
                    data-prenda-id="{{ $prenda->id_prenda }}">
                ❤️ <span id="likes-count">{{ $prenda->likes()->count() }}</span> Likes
                </button>
                
                <!-- Botones de acción -->
                <div class="acciones">
                    <button id="favorite-button" 
        class="btn-favorito {{ $prenda->isFavoritedByUser(auth()->id() ?? 0) ? 'favorited' : '' }}" 
        data-prenda-id="{{ $prenda->id_prenda }}">
    {{ $prenda->isFavoritedByUser(auth()->id() ?? 0) ? '😈 En favoritos' : 'Añadir a favoritos' }}
</button>
                </div>
                
                <!-- Display styles -->
                @if($prenda->estilos->count())
                <div class="estilos mt-4">
                    <h4>Estilos</h4>
                    <div class="d-flex gap-2 flex-wrap">
                    @foreach($prenda->estilos as $estilo)
                        <span class="badge bg-secondary">
                        {{ $estilo->nombre }}
                        </span>
                    @endforeach
                    </div>
                </div>
                @endif

                @if($prenda->etiquetas->count())
                <div class="etiquetas mt-4">
                    <h4>Etiquetas</h4>
                    <div class="d-flex gap-2 flex-wrap">
                    @foreach($prenda->etiquetas as $etiqueta)
                        <span class="badge bg-secondary">
                        {{ $etiqueta->nombre }}
                        </span>
                    @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
        
        <!-- Comentarios y valoraciones section -->
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
                            <div class="total-valoraciones">{{ $prenda->valoraciones->count() }} valoraciones</div>
                        </div>
                    </div>

                    @auth
                    <div class="tu-valoracion">
                        <h3>¿Qué te parece esta prenda?</h3>
                        <form action="{{ route('prendas.storeValoracion', $prenda->id_prenda) }}" method="POST">
                            @csrf
                            <div class="rating-container">
                                <div class="rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{$i}}" name="puntuacion" value="{{$i}}"
                                            {{ $puntuacionUsuario && $puntuacionUsuario->puntuacion == $i ? 'checked' : '' }}>
                                        <label for="star{{$i}}" title="{{$i}} estrellas"><i class="fas fa-star"></i></label>
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
                        <a href="{{ route('login') }}" class="text-primary">Inicia sesión</a> para valorar esta prenda.
                    </div>
                    @endauth

                    <div class="lista-valoraciones">
                        <h3>Opiniones recientes</h3>
                        @foreach($prenda->valoraciones->take(5) as $valoracion)
                        <div class="valoracion-card">
                            <div class="valoracion-user">
                                <div class="user-avatar">
                                    @if($valoracion->usuario->foto_perfil)
                                        <img src="{{ asset($valoracion->usuario->foto_perfil) }}" 
                                             alt="{{ $valoracion->usuario->nombre }}"
                                             class="foto-perfil-valoracion">
                                    @else
                                        <div class="foto-perfil-default">
                                            {{ substr($valoracion->usuario->nombre, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
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
                        <form action="{{ route('prendas.storeComment', $prenda->id_prenda) }}" method="POST" class="mb-4">
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

                    @foreach($prenda->comentarios as $comentario)
                    <div class="comentario-card mb-3">
                        <div class="comentario-content">
                            <div class="foto-comentario-container">
                                <a href="{{ route('perfil.publico', $comentario->usuario->id_usuario)}}">
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
                                        <button class="btn-like-comentario {{ $comentario->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
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
    </div>
    <br>
@include('layouts.footer')
@endsection