@extends('layouts.header')

@section('content')
    <div class="container mt-4">
        <h1>Donación Cancelada</h1>
        <p>Puedes intentarlo de nuevo cuando lo desees.</p>
        <a href="{{ route('home') }}" class="donate-button">Volver al Inicio</a>
    </div>
@endsection