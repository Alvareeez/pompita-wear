@extends('layouts.header')

@section('title', 'Página de Inicio')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/inicio.js') }}"></script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="carousel-container">
            <div class="carousel">
                <img src="{{ asset('img/carrousel1.jpg') }}" alt="Imagen 1" class="carousel-image active">
                <img src="{{ asset('img/carrousel2.png') }}" alt="Imagen 2" class="carousel-image">
                <img src="{{ asset('img/carrousel3.jpg') }}" alt="Imagen 3" class="carousel-image">
                <img src="{{ asset('img/carrousel4.png') }}" alt="Imagen 3" class="carousel-image">
            </div>
        </div>

        <!-- Fila de botones -->
        <div class="button-row">
            <button class="action-button">Botón 1</button>
            <button class="action-button">Botón 2</button>
            <button class="action-button">Botón 3</button>
        </div>

        <!-- Fila de contenido -->
        <div class="content-row">
            <!-- Columna izquierda -->
            <div class="content-column left-column">
                <h2 class="section-title">Título de la sección</h2>
                <div>
                    <img src="{{ asset('img/sample1.jpg') }}" alt="Imagen pequeña 1" class="small-image">
                    <img src="{{ asset('img/sample2.jpg') }}" alt="Imagen pequeña 2" class="small-image">
                    <img src="{{ asset('img/sample3.jpg') }}" alt="Imagen pequeña 3" class="small-image">
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="content-column right-column">
                <img src="{{ asset('img/sample4.jpg') }}" alt="Imagen grande 1" class="large-image">
                <img src="{{ asset('img/sample5.jpg') }}" alt="Imagen grande 2" class="large-image">
                <img src="{{ asset('img/sample6.jpg') }}" alt="Imagen grande 3" class="large-image">
            </div>
        </div>
    </div>
@endsection