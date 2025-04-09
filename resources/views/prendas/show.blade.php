@extends('layouts.header')

@section('title', 'Detalles de la Prenda')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleDetalles.css') }}">
@endsection
@section('content')
    <div class="container mt-4">
        <div class="prenda-detalle">
            <div class="prenda-imagenes">
                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" 
                     alt="Vista frontal" 
                     class="imagen-detalle">
                @if($prenda->img_trasera)
                <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" 
                     alt="Vista trasera" 
                     class="imagen-detalle">
                @endif
            </div>
            
            <div class="prenda-info">
                <h1>{{ $prenda->nombre }}</h1>
                <p class="precio">€{{ number_format($prenda->precio, 2) }}</p>
                <p class="descripcion">{{ $prenda->descripcion }}</p>
                <div class="likes">❤️ {{ $prenda->likes }} Likes</div>
                
                <!-- Botones de acción -->
                <div class="acciones">
                    <button class="btn-comprar">Comprar ahora</button>
                    <button class="btn-favorito">Añadir a favoritos</button>
                </div>
            </div>
        </div>
    </div>
@endsection