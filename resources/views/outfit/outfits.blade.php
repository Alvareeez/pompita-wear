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
                        @foreach($outfit->prendas as $prenda)
                                <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="{{ $prenda->nombre }}">
                        @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
