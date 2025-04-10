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
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" 
                         alt="Vista frontal" 
                         class="imagen-detalle">
                    @if($prenda->img_trasera)
                    <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" 
                         alt="Vista trasera" 
                         class="imagen-detalle">
                    @endif
                </div>
            </div>
            
            <div class="prenda-info">
                <h1>{{ $prenda->nombre }}</h1>
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($puntuacionPromedio) ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                    <span>({{ number_format($puntuacionPromedio, 1) }})</span>
                </div>
                <p class="precio">€{{ number_format($prenda->precio, 2) }}</p>
                
                <p class="descripcion">{{ $prenda->descripcion }}</p>
                
                <button id="like-button" class="btn-like {{ $prenda->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
                    data-prenda-id="{{ $prenda->id_prenda }}">
                ❤️ <span id="likes-count">{{ $prenda->likes()->count() }}</span> Likes
            </button>
                
                <!-- Botones de acción -->
                <div class="acciones">
                    <button class="btn-comprar">Comprar ahora</button>
                    <button class="btn-favorito">Añadir a favoritos</button>
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
            </div>
        </div>
        <!-- Sección de comentarios y valoraciones en columnas -->
        <div class="comentarios-valoraciones-container">
            <!-- Columna izquierda - Comentarios -->
            <div class="comentarios-columna">
                <div class="comentarios-section">
                    <h2>Comentarios</h2>
                    @auth
                    <form action="{{ route('prendas.storeComment', $prenda->id_prenda) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="form-group">
                            <textarea name="comentario" class="form-control" rows="3" placeholder="Añade un comentario..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Enviar comentario</button>
                    </form>
                    @endauth

                    @foreach($prenda->comentarios as $comentario)
                    <div class="comentario-card mb-3 p-3">
                        <div class="d-flex">
                            <!-- Foto de perfil a la izquierda -->
                            <div class="foto-comentario-container">
                                @if($comentario->usuario->foto_perfil)
                                <a href="{{ url('/perfil')}}">
                                    <img src="{{ asset('img/' . $comentario->usuario->foto_perfil) }}" 
                                        alt="Foto de {{ $comentario->usuario->nombre }}"
                                        class="foto-perfil-comentario">
                                </a>
                                @else
                                <a href="{{ url('perfil') }}">
                                    <div class="foto-perfil-default">
                                        {{ substr($comentario->usuario->nombre, 0, 1) }}
                                    </div>
                                </a>
                                @endif
                            </div>
                            
                            <!-- Contenido del comentario a la derecha -->
                            <div class="contenido-comentario">
                                <div class="cabecera-comentario">
                                    <strong>{{ $comentario->usuario->nombre }}</strong>
                                    <span class="tiempo-comentario">{{ $comentario->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="texto-comentario">{{ $comentario->comentario }}</p>
                            </div>
                        </div>
                        
                        <!-- Like debajo del comentario alineado a la derecha -->
                        <div class="acciones-comentario">
                            <button class="btn-like-comentario {{ $comentario->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
                                    data-comentario-id="{{ $comentario->id_comentario }}">
                                ❤️ <span class="likes-count">{{ $comentario->likesCount() }}</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Columna derecha - Valoraciones -->
            <div class="valoraciones-columna">
                <div class="valoraciones-section">
                    <h2>Valoraciones</h2>
                    @auth
                    <div class="tu-valoracion mb-4">
                        <h5>Tu valoración:</h5>
                        <form action="{{ route('prendas.storeValoracion', $prenda->id_prenda) }}" method="POST">
                            @csrf
                            <div class="rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{$i}}" name="puntuacion" value="{{$i}}"
                                        {{ $puntuacionUsuario && $puntuacionUsuario->puntuacion == $i ? 'checked' : '' }}>
                                    <label for="star{{$i}}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Guardar valoración</button>
                        </form>
                    </div>
                    @endauth

                    <div class="lista-valoraciones">
                        <h5>Últimas valoraciones:</h5>
                        @foreach($prenda->valoraciones->take(5) as $valoracion)
                        <div class="valoracion-card mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $valoracion->usuario->nombre }}</strong>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $valoracion->puntuacion ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $valoracion->created_at->diffForHumans() }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection