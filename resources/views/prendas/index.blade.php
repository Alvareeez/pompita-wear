@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
@endsection

@section('content')
<div class="title-container">
    <h1 class="center-title">Top 5 Prendas con Más Likes</h1>
</div>

<div class="centered-container">
    <div class="prendas">
        @foreach ($prendasPopulares as $prenda)
            <div class="prenda">
                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen de {{ $prenda->descripcion }}" class="prenda-img">
                <p><strong>{{ $prenda->nombre }}</strong></p>
                <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
            </div>
        @endforeach
    </div>
</div>

<div class="title-container">
    <h1 class="center-title_estilos">Explora por estilos</h1>
</div>

<div class="button-row">
    @foreach ($estilos as $estilo)
        <a href="{{ route('prendas.porEstilo', $estilo->id_estilo) }}">
            <button class="action-button">{{ $estilo->nombre }}</button>
        </a>
    @endforeach
</div>
@endsection
