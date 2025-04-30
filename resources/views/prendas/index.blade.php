@extends('layouts.header')

@section('title', 'Todas las Prendas')

@section('css')
<link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
@endsection

@section('content')

@if ($topPrendas->count())
<div class="top-prendas-container">
    <h2 class="center-title">Top 5 Prendas con Más Likes</h2>
    <div class="top-prendas">
        @foreach ($topPrendas as $prenda)
            <div class="prenda">
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->descripcion }}">
                </a>
                <p><strong>{{ $prenda->nombre }}</strong></p>
                <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="title-container">
    <h1 class="center-title">Todas las Prendas</h1>
</div>

{{-- Filtros --}}
<div class="filter-container">
    <form method="GET" action="{{ route('prendas.index') }}">
        <input type="text" name="nombre" placeholder="Buscar por nombre..." value="{{ request('nombre') }}">

        <select name="id_estilo">
            <option value="">Todos los estilos</option>
            @foreach($estilos as $estilo)
                <option value="{{ $estilo->id_estilo }}" {{ request('id_estilo') == $estilo->id_estilo ? 'selected' : '' }}>
                    {{ $estilo->nombre }}
                </option>
            @endforeach
        </select>

        <select name="id_color">
            <option value="">Todos los colores</option>
            @foreach($colores as $color)
                <option value="{{ $color->id_color }}" {{ request('id_color') == $color->id_color ? 'selected' : '' }}>
                    {{ $color->nombre }}
                </option>
            @endforeach
        </select>

        <select name="id_tipoPrenda">
            <option value="">Tipo de prenda</option>
            @foreach($tiposPrenda as $tipo)
                <option value="{{ $tipo->id_tipoPrenda }}" {{ request('id_tipoPrenda') == $tipo->id_tipoPrenda ? 'selected' : '' }}>
                    {{ $tipo->tipo }}
                </option>
            @endforeach
        </select>

        <select name="orden">
            <option value="">Ordenar por</option>
            <option value="likes" {{ request('orden') === 'likes' ? 'selected' : '' }}>Más Likes</option>
            <option value="valoracion" {{ request('orden') === 'valoracion' ? 'selected' : '' }}>Mejor Valoración</option>
        </select>

        <button type="submit" class="action-button">Filtrar</button>
    </form>
</div>

{{-- Lista de prendas --}}
<div class="centered-container">
    <div class="prendas">
        @forelse ($prendas as $prenda)
            <div class="prenda">
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->descripcion }}">
                </a>
                <p><strong>{{ $prenda->nombre }}</strong></p>
                <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
                <p><strong>Valoración:</strong> {{ number_format($prenda->valoraciones_avg_puntuacion, 1) ?? '-' }}</p>
            </div>
        @empty
            <p>No se encontraron prendas con esos criterios.</p>
        @endforelse
    </div>
</div>

<div class="pagination">
    {{ $prendas->links() }}
</div>
@endsection
