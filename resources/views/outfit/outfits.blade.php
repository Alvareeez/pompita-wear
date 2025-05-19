@extends('layouts.header')

@section('title', 'Mis Outfits')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/showOutfits.css') }}">
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/filtrosShowOutfits.js') }}"></script>
@endsection
@section('content')
<div class="title-container">
    <h1 class="center-title_outfit">Todos los Outfits</h1>
</div>
<div class="filter-container">
    <div class="filter-group">
        <input type="text" id="nombreFilter" placeholder="Buscar por nombre de outfit" class="filter-input">
    </div>
    <div class="filter-group">
        <input type="text" id="creadorFilter" placeholder="Buscar por creador" class="filter-input">
    </div>
</div>

<div class="centered-container">
    <div class="outfits" id="outfitsContainer">
        @include('outfit.partials.outfits_list', ['outfits' => $outfits])
    </div>
</div>

@endsection