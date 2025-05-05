@extends('layouts.header')

@section('title', 'Detalles del Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/outfitSolo.css') }}">
@endsection

@section('content')
<div class="title-container">
    <h1 class="center-title_outfit">Outfit de {{ $outfit->usuario->nombre }}</h1>
</div>

<div class="centered-container">
    <div class="outfit-detalle">
        <h3 class="outfit-title">Outfit: {{ $outfit->nombre }}</h3>

        <div class="prendas">
            @foreach ($outfit->prendas->sortBy('tipo.id_tipoPrenda') as $prenda)
                <div class="prenda-detalle">
                    <!-- Enlace a la prenda -->
                    <a href="{{ route('prendas.show', $prenda->id_prenda) }}">
                        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                    </a>
                    <div class="info-prenda">
                        <p><strong>{{ $prenda->nombre }}</strong></p>
                        <p>Tipo: {{ $prenda->tipo->nombre }}</p>
                        <p>Precio: €{{ number_format($prenda->precio, 2) }}</p>
                        <p>Descripción: {{ $prenda->descripcion }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-outfit">
            <h4>Precio Total: €{{ number_format($precioTotal, 2) }}</h4>
        </div>

        <!-- Botón de volver -->
        <div class="volver-btn-container">
            <a href="{{ route('outfit.outfits') }}" class="volver-btn">← Volver a todos los outfits</a>
        </div>
    </div>
</div>
@endsection
