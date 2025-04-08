@extends('layouts.header')

@section('title', 'Prendas de Estilo: ' . $estilo->nombre)

@section('content')
    <h1>Prendas del Estilo: {{ $estilo->nombre }}</h1>

    @if ($prendas->count() > 0)
        <div class="prendas">
            @foreach ($prendas as $prenda)
                <div class="prenda">
                    <img src="{{ asset('storage/' . $prenda->img_frontal) }}" alt="Imagen de {{ $prenda->descripcion }}" style="width: 200px;">
                    <p><strong>Descripción:</strong> {{ $prenda->descripcion }}</p>
                    <p><strong>Precio:</strong> {{ $prenda->precio }}€</p>
                    <p><strong>Likes:</strong> {{ $prenda->likes }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay prendas para este estilo.</p>
    @endif

    <a href="{{ route('prendas.index') }}">← Volver a todas las prendas</a>
@endsection
