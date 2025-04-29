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

    //SLIDER PROFILES
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector(".carousel-3d");
        const items = document.querySelectorAll(".carousel-3d .item-3d");
        const totalItems = items.length;
        let currentIndex = 0;

        // Configuración del carrusel
        const radius = 300; // Radio del círculo (ajustar si hace falta)
        const angleStep = 360 / totalItems;

        // Coloca cada item en su posición inicial en el círculo
        function setupCarousel() {
            for (let i = 0; i < totalItems; i++) {
                const angle = angleStep * i;
                items[i].style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
            }
        }

        function rotateCarousel() {
            currentIndex = (currentIndex + 1) % totalItems;
            for (let i = 0; i < totalItems; i++) {
                const angle = angleStep * ((i - currentIndex + totalItems) % totalItems);
                items[i].style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;

                if (i === currentIndex) {
                    items[i].classList.add("active");
                    items[i].style.opacity = "1";
                } else {
                    items[i].classList.remove("active");
                    items[i].style.opacity = "0.6";
                }
            }
        }

        setupCarousel(); // Posicionamiento inicial
        setInterval(rotateCarousel, 3000); // Gira cada 3 segundos
    });