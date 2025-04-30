document.addEventListener("DOMContentLoaded", function() {
    const carouselList = document.querySelector('.carousel__list');
    const carouselItems = document.querySelectorAll('.carousel__item');
    const elems = Array.from(carouselItems);
    const totalItems = elems.length;

    if (!carouselList || !totalItems) {
        console.warn("No se encontró el carrusel o las tarjetas.");
        return;
    }

    // === Paleta de colores predefinidos para los fondos de las tarjetas ===
    const predefinedColors = [
        'linear-gradient(45deg, #2D35EB 0%, #904ED4 100%)',
        'linear-gradient(45deg, #2D35EB 0%, #fdbb2d 100%)',
        'linear-gradient(45deg, #2D35EB 0%, #22c1c3 100%)',
        'linear-gradient(45deg, #fdbb2d 0%, #904ED4 100%)',
        'linear-gradient(45deg, #22c1c3 0%, #904ED4 100%)',
        'linear-gradient(45deg, #FA709A, #FEE140)',
        'linear-gradient(45deg, #00C9FF, #92FE9D)',
        'linear-gradient(45deg, #a18cd1 0%, #fbc2eb 100%)'
    ];

    // === Aplicar color aleatorio a cada tarjeta ===
    elems.forEach((item, index) => {
        const colorIndex = index % predefinedColors.length;
        item.style.background = predefinedColors[colorIndex];
    });

    // Rango visible: -2, -1, 0, 1, 2
    const visibleRange = 2;

    // Distribuye posiciones iniciales
    function setup() {
        for (let i = 0; i < totalItems; i++) {
            elems[i].dataset.pos = i - Math.floor(totalItems / 2); // Centrado simétrico
        }
        updatePositions();
    }

    // Actualiza posición visual según dataset.pos
    function updatePositions() {
        for (const item of elems) {
            const pos = parseInt(item.dataset.pos);

            if (Math.abs(pos) > visibleRange) {
                item.style.opacity = "0";
                item.style.transform = `translateX(${pos * 100}%) scale(0.7)`;
            } else {
                item.style.opacity = 2 - (Math.abs(pos) * 0.2);
                item.style.transform = `translateX(${pos * 40}%) scale(${1 - Math.abs(pos) * 0.1})`;
                item.style.zIndex = visibleRange - Math.abs(pos);
                item.classList.toggle('carousel__item_active', pos === 0);
            }
        }
    }

    // Manejador de clics en tarjetas
    carouselList.addEventListener('click', function(event) {
        const clickedItem = event.target.closest('.carousel__item');

        if (!clickedItem || clickedItem.classList.contains('carousel__item_active')) {
            return;
        }

        const clickedPos = parseInt(clickedItem.dataset.pos);

        // Recalculamos la posición relativa desde la seleccionada
        for (const item of elems) {
            let currentPos = parseInt(item.dataset.pos);
            let newPos = currentPos - clickedPos;

            while (newPos < -visibleRange) newPos += totalItems;
            while (newPos > visibleRange) newPos -= totalItems;

            item.dataset.pos = newPos;
        }

        updatePositions();
    });

    // Manejadores de botones
    const btnPrev = document.querySelector('.carousel-control.prev');
    const btnNext = document.querySelector('.carousel-control.next');

    if (btnPrev && btnNext) {
        btnPrev.addEventListener('click', () => {
            moveCarousel(-1);
        });

        btnNext.addEventListener('click', () => {
            moveCarousel(1);
        });
    }

    // Función auxiliar para mover el carrusel
    function moveCarousel(direction) {
        const activeItem = document.querySelector('[data-pos="0"]');
        const activeIndex = parseInt(activeItem.dataset.pos);

        for (const item of elems) {
            let currentPos = parseInt(item.dataset.pos);
            let newPos = currentPos - direction;

            while (newPos < -visibleRange) newPos += totalItems;
            while (newPos > visibleRange) newPos -= totalItems;

            item.dataset.pos = newPos;
        }

        updatePositions();
    }

    setup();
});