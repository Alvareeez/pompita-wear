@extends('layouts.header')

@section('title', 'Prendas de Estilo: ' . $estilo->nombre)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasporestilo.css') }}">
@endsection

@section('content')
    <h1 class="center-title_estilos">Prendas del Estilo: {{ $estilo->nombre }}</h1>

    @if ($prendas->count() > 0)
        <div class="prendas">
            @foreach ($prendas as $prenda)
                <div class="prenda">
                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen de {{ $prenda->descripcion }}">
                    <p><strong>{{ $prenda->nombre }}</strong></p>
                    <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                    <p><strong>Likes:</strong> {{ $prenda->likes }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="no-prendas">No hay prendas para este estilo.</p>
    @endif

    <a href="{{ route('prendas.index') }}" class="back-link">← Volver a todas las prendas</a>
@endsection
