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
        <div class="comentarios-section mt-5">
            <h3>Comentarios</h3>
        
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
            <div class="comentario-card mb-3 p-3 border rounded">
                <div class="d-flex justify-content-between">
                    <strong>{{ $comentario->usuario->nombre }}</strong>
                    <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                </div>
                <p class="mt-2">{{ $comentario->comentario }}</p>
                
                <div class="comentario-acciones">
                    <button class="btn-like-comentario {{ $comentario->isLikedByUser(auth()->id() ?? 0) ? 'liked' : '' }}" 
                            data-comentario-id="{{ $comentario->id_comentario }}">
                        ❤️ <span class="likes-count">{{ $comentario->likesCount() }}</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection