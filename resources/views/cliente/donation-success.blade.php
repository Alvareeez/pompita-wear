@extends('layouts.header')

@section('content')
    <div class="container mt-4">
        <h1>¡Gracias por tu donación! 💖</h1>
        <p>Tu apoyo significa mucho para nosotros.</p>
        <a href="{{ route('home') }}" class="donate-button">Volver al Inicio</a>
    </div>
@endsection