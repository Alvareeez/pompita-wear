@extends('layouts.header')

@section('title', 'Prendas Populares')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
@endsection

@section('content')
    <h1>Top 5 Prendas con Más Likes</h1>

    <div class="prendas">
        @foreach ($prendasPopulares as $prenda)
            <div class="prenda">
                <img src="{{ asset('storage/' . $prenda->img_frontal) }}" alt="Imagen de {{ $prenda->descripcion }}">
                <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                <p><strong>Likes:</strong> {{ $prenda->likes }}</p>
            </div>
        @endforeach
    </div>

    <h2>Explora por Estilos</h2>

    <div class="estilos">
        @foreach ($estilos as $estilo)
            <a href="{{ route('prendas.porEstilo', $estilo->id_estilo) }}">
                <button>{{ $estilo->nombre }}</button>
            </a>
        @endforeach
    </div>
@endsection
