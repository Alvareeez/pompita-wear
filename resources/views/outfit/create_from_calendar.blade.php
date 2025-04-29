@extends('layouts.header')

@section('title', 'Añadir Outfit')

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
        <h2>Añadir Outfit para el {{ $fecha }}</h2>
        <form action="{{ route('outfits.storeFromCalendar') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha" value="{{ $fecha }}">

            <label for="outfit_usuario" class="form-label">Seleccionar Outfit Creado por Ti</label>
            <select class="form-select" id="outfit_usuario" name="outfit_usuario">
                <option value="">Seleccionar</option>
                @foreach($misOutfits as $outfit)
                    <option value="{{ $outfit->id_outfit }}">{{ $outfit->nombre }}</option>
                @endforeach
            </select>

            <label for="outfit_todos" class="form-label">Seleccionar de Todos los Outfits</label>
            <select class="form-select" id="outfit_todos" name="outfit_todos">
                <option value="">Seleccionar</option>
                @foreach($todosOutfits as $outfit)
                    <option value="{{ $outfit->id_outfit }}">{{ $outfit->nombre }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Añadir Outfit</button>
        </form>
    </div>

    <a href="{{ route('calendario') }}" class="redirect-button">Volver al Calendario</a>
</div>
@endsection