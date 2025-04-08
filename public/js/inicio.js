    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.carousel-image'); // Todas las imágenes
        let currentIndex = 0; // Índice de la imagen actual

        // Función para cambiar de imagen
        function changeSlide() {
            // Ocultar la imagen actual
            if (images[currentIndex]) {
                images[currentIndex].classList.remove('active');
            }

            // Calcular el nuevo índice
            currentIndex++;

            // Volver al inicio si se pasa del límite
            if (currentIndex >= images.length) {
                currentIndex = 0;
            }

            // Mostrar la nueva imagen
            if (images[currentIndex]) {
                images[currentIndex].classList.add('active');
            }
        }

        // Asignar la primera imagen como activa
        if (images[currentIndex]) {
            images[currentIndex].classList.add('active');
        }

        // Cambiar automáticamente cada 5 segundos
        setInterval(changeSlide, 5000);
    });