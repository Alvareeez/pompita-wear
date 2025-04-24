@extends('layouts.header')

@section('title', 'Página de Inicio')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="carousel-container">
            <div class="carousel">
                <img src="{{ asset('img/carrousel1.png') }}" alt="Imagen 1" class="carousel-image active">
                <img src="{{ asset('img/carrousel2.png') }}" alt="Imagen 2" class="carousel-image">
                <img src="{{ asset('img/carrousel3.png') }}" alt="Imagen 3" class="carousel-image">
                <img src="{{ asset('img/carrousel4.png') }}" alt="Imagen 3" class="carousel-image">
            </div>
        </div>

<!-- Fila de botones -->
<div class="button-row">
    <a href="{{ route('prendas.index') }}" class="action-button">Prendas</a>
    <a href="{{ route('outfit.index') }}" class="action-button">Crea tu outfit</a>
    <a href="{{ route('outfit.outfits') }}" class="action-button">Outfits</a>
</div>
        <div class="content-row">
            <div class="content-column left-column">
                <h2 class="section-title">Tendencias En Prendas 🔥</h2>
                <div class="image-row">
                    @foreach($prendasPopulares->take(3) as $prenda)
    <div class="prenda-item">
        <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" 
                 alt="Prendas más likes" 
                 class="small-image">
        </a>
        <div class="prenda-info">
            <span class="precio">€{{ number_format($prenda->precio, 2) }}</span>
            <span class="likes">❤️ {{$prenda->likes_count }}</span>
        </div>
    </div>
@endforeach
                </div>
                <div class="image-row">
                    @foreach($prendasPopulares->slice(3, 2) as $prenda)
                        <div class="prenda-item">
                            <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" 
                                 alt="Prendas más likes" 
                                 class="small-image">
                            </a>
                            <div class="prenda-info">
                                <span class="precio">€{{ number_format($prenda->precio, 2) }}</span>
                                <span class="likes">❤️ {{ $prenda->likes_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

    <!-- Columna derecha -->
    <div class="content-column right-column">
        <h2 class="section-title">Tendencias En Outfits 🔥</h2>
        <div class="image-container">
            <img src="{{ asset('img/sample4.jpg') }}" alt="Imagen grande 1" class="large-image">
            <img src="{{ asset('img/sample5.jpg') }}" alt="Imagen grande 2" class="large-image">
            <img src="{{ asset('img/sample6.jpg') }}" alt="Imagen grande 3" class="large-image">
        </div>
    </div>
</div>
    </div>
@endsection