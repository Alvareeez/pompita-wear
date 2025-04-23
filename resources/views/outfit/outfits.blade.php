@extends('layouts.header')

@section('title', 'Mis Outfits')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/showOutfits.css') }}">
@endsection

@section('content')
<div class="title-container">
    <h1 class="center-title_outfit">Todos los Outfits</h1>
</div>

<div class="centered-container">
    <div class="outfits">
        @foreach($outfits as $outfit)
            <div class="outfit">
                <div class="card-body">
                    <h5 class="card-title">Outfit de {{ $outfit->usuario->nombre }}</h5>
                    
                    {{-- Mostrar las prendas del outfit --}}
                    @foreach($outfit->prendas as $prenda)
                        <div class="prenda-row">
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                            <p>{{ $prenda->nombre }} - Precio: €{{ number_format($prenda->precio, 2) }}</p>
                        </div>
                    @endforeach

                    {{-- Mostrar el precio total del outfit --}}
                    <h6 class="card-subtitle mt-3">Precio Total: €{{ number_format($outfit->precio_total, 2) }}</h6>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
