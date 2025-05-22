@extends('layouts.header')

@section('title', 'Outfits')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/showOutfits.css') }}">
@endsection

@section('content')
  <div class="container mt-5">
    <h1 class="text-center mb-4">Todos los Outfits</h1>

    {{-- Filtros --}}
    <div class="row gx-2 mb-4">
      <div class="col-sm-6">
        <input type="text" id="nombreFilter" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
      </div>
      <div class="col-sm-6">
        <input type="text" id="creadorFilter" class="form-control" placeholder="Buscar por creador" value="{{ request('creador') }}">
      </div>
    </div>

    {{-- Contenedor donde inyectamos listado + paginación --}}
    <div id="outfitsContainer">
      @include('outfit.partials.outfits_list', ['outfits' => $outfits])
    </div>
  </div>
@include('layouts.footer')
@endsection

@section('scripts')
  <script src="{{ asset('js/filtrosShowOutfits.js') }}"></script>
@endsection
