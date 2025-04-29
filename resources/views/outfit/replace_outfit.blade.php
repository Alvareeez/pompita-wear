@extends('layouts.header')

@section('title', 'Sustituir Outfit')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="form-container">
        <h2>Sustituir Outfit para el {{ $fecha }}</h2>

        @if($existingOutfit)
            <div class="alert alert-info">
                <strong>Outfit Actual:</strong> {{ $existingOutfit->nombre }}
            </div>
        @else
            <div class="alert alert-warning">
                No hay ningún outfit asignado para esta fecha.
            </div>
        @endif

        <form action="{{ route('outfits.storeFromCalendar') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha" value="{{ $fecha }}">

            <label for="outfit_usuario" class="form-label">Seleccionar Nuevo Outfit</label>
            <select class="form-select" id="outfit_usuario" name="outfit_usuario">
                <option value="">Seleccionar</option>
                @foreach($misOutfits as $outfit)
                    <option value="{{ $outfit->id_outfit }}">{{ $outfit->nombre }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-warning">Sustituir Outfit</button>
        </form>
    </div>

    <a href="{{ route('calendario') }}" class="redirect-button">Volver al Calendario</a>
</div>
@endsection