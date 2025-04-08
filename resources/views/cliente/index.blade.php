@extends('layouts.header')

@section('title', 'Página de Inicio')

@section('content')
    <div class="container mt-4">
        <div class="carousel-container">
            <div class="carousel">
                <img src="{{ asset('img/carrousel1.jpg') }}" alt="Imagen 1" class="carousel-image active">
                <img src="{{ asset('img/carrousel2.png') }}" alt="Imagen 2" class="carousel-image">
                <img src="{{ asset('img/carrousel3.jpg') }}" alt="Imagen 3" class="carousel-image">
                <img src="{{ asset('img/carrousel4.png') }}" alt="Imagen 3" class="carousel-image">
            </div>
            <button class="carousel-button prev" onclick="changeSlide(-1)">
                <i class="fas fa-chevron-left"></i> <!-- Flecha izquierda -->
            </button>
            <button class="carousel-button next" onclick="changeSlide(1)">
                <i class="fas fa-chevron-right"></i> <!-- Flecha derecha -->
            </button>
        </div>
    </div>
    <style>
        .carousel-container {
            position: relative;
            width: 100%;
            height: 400px; /* Altura fija */
            overflow: hidden;
        }
    
        /* Carrusel */
        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
    
        /* Imágenes del carrusel */
        .carousel-image {
            width: 100%;
            display: none;
            object-fit: cover;
            height: 400px;
            border-radius: 8px;
        }
    
        /* Imagen activa */
        .carousel-image.active {
            display: block;
        }
    
        /* Botones de navegación */
        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 20px;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
        }
    
        .carousel-button.prev {
            left: 10px;
        }
    
        .carousel-button.next {
            right: 10px;
        }
    
        /* Hover en los botones */
        .carousel-button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
    <script>
        let currentIndex = 0; // Índice de la imagen actual
        const images = document.querySelectorAll('.carousel-image'); // Todas las imágenes
    
        // Función para cambiar de imagen
        function changeSlide(direction) {
            // Ocultar la imagen actual
            images[currentIndex].classList.remove('active');
    
            // Calcular el nuevo índice
            currentIndex += direction;
    
            if (currentIndex >= images.length) {
                currentIndex = 0; // Volver al inicio si se pasa del límite
            } else if (currentIndex < 0) {
                currentIndex = images.length - 1; // Ir al final si se retrocede demasiado
            }
    
            // Mostrar la nueva imagen
            images[currentIndex].classList.add('active');
        }
    
        // Cambiar automáticamente cada 5 segundos (opcional)
        setInterval(() => changeSlide(1), 5000);
    </script>
@endsection