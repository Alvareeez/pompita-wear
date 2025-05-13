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
        <a href="{{ route('outfit.show', $outfit->id_outfit) }}" class="outfit-link">
            <div class="outfit">
                <div class="card-body">
                    <h5 class="card-title">{{ $outfit->nombre }}</h5>
                    <p>Creado por: {{ $outfit->usuario->nombre }}</p>

                    @foreach($outfit->prendas->sortBy('tipo.id_tipoPrenda') as $prenda)
                        <div class="prenda-row">
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                            <p>{{ $prenda->nombre }} </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </a>
    @endforeach
    </div>
</div>
@endsection
