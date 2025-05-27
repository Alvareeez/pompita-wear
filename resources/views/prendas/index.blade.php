@extends('layouts.header')

@section('title', 'Todas las Prendas')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/prendasEstilos.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/filtrarPrendasAjax.js') }}"></script>
    <script>
    // Lógica simple para las flechas del slider
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('destacadas-container');
      document.getElementById('slide-left').addEventListener('click', () => {
        container.scrollBy({ left: -200, behavior: 'smooth' });
      });
      document.getElementById('slide-right').addEventListener('click', () => {
        container.scrollBy({ left:  200, behavior: 'smooth' });
      });
    });
  </script>
@endsection

@section('content')

    {{-- Top 5 prendas --}}
    @if ($topPrendas->count())
        <div class="top-prendas-container">
            <h2 class="center-title">Top 5 Prendas con Más Likes</h2>
            <div class="top-prendas">
                @foreach ($topPrendas as $prenda)
                    <div class="prenda">
                        <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                            <img
                              src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
                              alt="{{ $prenda->descripcion }}"
                            >
                        </a>
                        <p><strong>{{ $prenda->nombre }}</strong></p>
                        <p><strong>Likes:</strong> {{ $prenda->likes_count }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    {{-- Slider de destacadas --}}
    @if($destacadas->count())
    <div class="destacadas-slider">
        <h2 class="center-title">Prendas Destacadas</h2>
        <button class="slider-arrow left" id="slide-left">&lsaquo;</button>
        <div class="destacadas-container" id="destacadas-container">
            @foreach($destacadas as $prenda)
            <div class="destacada-item">
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                    <span class="destacada-badge">Destacada</span> 
                    <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                    <div class="destacada-item-content">
                        <p><strong>{{ $prenda->nombre }}</strong></p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <button class="slider-arrow right" id="slide-right">&rsaquo;</button>
    </div>
    @endif    
    <div class="title-container">
        <h1 class="center-title">Todas las Prendas</h1>
    </div>

    {{-- FILTROS --}}
    <div class="filter-container">
        <form id="filter-form" method="GET" action="{{ route('prendas.index') }}">
            <input
                type="text"
                name="nombre"
                placeholder="Buscar por nombre..."
                value="{{ request('nombre') }}"
            >

            <select name="id_estilo">
                <option value="">Todos los estilos</option>
                @foreach($estilos as $estilo)
                    <option
                        value="{{ $estilo->id_estilo }}"
                        {{ request('id_estilo') == $estilo->id_estilo ? 'selected' : '' }}
                    >
                        {{ $estilo->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="id_color">
                <option value="">Todos los colores</option>
                @foreach($colores as $color)
                    <option
                        value="{{ $color->id_color }}"
                        {{ request('id_color') == $color->id_color ? 'selected' : '' }}
                    >
                        {{ $color->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="id_tipoPrenda">
                <option value="">Tipo de prenda</option>
                @foreach($tiposPrenda as $tipo)
                    <option
                        value="{{ $tipo->id_tipoPrenda }}"
                        {{ request('id_tipoPrenda') == $tipo->id_tipoPrenda ? 'selected' : '' }}
                    >
                        {{ $tipo->tipo }}
                    </option>
                @endforeach
            </select>

            <select name="orden">
                <option value="">Ordenar por</option>
                <option value="likes"      {{ request('orden') === 'likes'      ? 'selected' : '' }}>Más Likes</option>
                <option value="valoracion" {{ request('orden') === 'valoracion' ? 'selected' : '' }}>Mejor Valoración</option>
            </select>

            <button type="submit" class="action-button">Filtrar</button>
        </form>
    </div>

    {{-- RESULTADOS Y PAGINACIÓN AJAX --}}
    <div id="results">
        @include('prendas.partials.product-list')
    </div>
@include('layouts.footer')
@endsection

