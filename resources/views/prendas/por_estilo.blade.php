@extends('layouts.header')

@section('title', 'Prendas de Estilo: ' . $estilo->nombre)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasporestilo.css') }}">
@endsection

@section('content')
    <h1 class="center-title_estilos">Prendas del Estilo: {{ $estilo->nombre }}</h1>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('prendas.porEstilo', ['id' => $estilo->id_estilo]) }}" class="search-form">
        <input type="text" name="nombre" placeholder="Filtrar por nombre" value="{{ request('nombre') }}">
        
        <select name="orden">
            <option value="">Ordenar por...</option>
            <option value="mas_likes" {{ request('orden') == 'mas_likes' ? 'selected' : '' }}>Más likes</option>
            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: Menor a mayor</option>
            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: Mayor a menor</option>
        </select>

        <button type="submit">Aplicar filtros</button>
    </form>

    @if ($prendas->count() > 0)
        <div class="prendas">
            @foreach ($prendas as $prenda)
                <div class="prenda">
                    <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Imagen de {{ $prenda->descripcion }}">
                    </a>
                    <p><strong>{{ $prenda->nombre }}</strong></p>
                    <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                    <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="no-prendas">No hay prendas para este estilo.</p>
    @endif

    <a href="{{ route('prendas.index') }}" class="back-link">← Volver a todas las prendas</a>
@endsection
