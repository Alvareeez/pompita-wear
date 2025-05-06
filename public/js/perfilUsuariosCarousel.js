document.addEventListener("DOMContentLoaded", function() {
    const carouselList = document.querySelector('.carousel__list');
    const carouselItems = document.querySelectorAll('.carousel__item');
    const elems = Array.from(carouselItems);
    const totalItems = elems.length;

    if (!carouselList || totalItems <= 0) {
        document.querySelectorAll('.carousel-control').forEach(btn => {
            btn.style.display = 'none';
        });
        return;
    }

    // Paleta de colores predefinidos para los fondos de las tarjetas
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

    // Aplicar color aleatorio a cada tarjeta
    elems.forEach((item, index) => {
        const colorIndex = index % predefinedColors.length;
        item.style.background = predefinedColors[colorIndex];
    });

    // Rango visible: -1, 0, 1 (solo 3 tarjetas visibles)
    const visibleRange = 1;

    // Distribuye posiciones iniciales
    function setup() {
        elems.forEach((item, index) => {
            item.dataset.pos = index - Math.floor(totalItems / 2);
            item.dataset.index = index;
        });
        updatePositions();
    }

    // Actualiza posición visual según dataset.pos
    function updatePositions() {
        elems.forEach((item) => {
            const pos = parseInt(item.dataset.pos);
            const index = parseInt(item.dataset.index);

            if (Math.abs(pos) > visibleRange || index < 0 || index >= totalItems) {
                item.style.opacity = "0";
                item.style.transform = "translateX(0) scale(0.7)";
                item.style.pointerEvents = "none";
                item.style.zIndex = "0";
            } else {
                item.style.opacity = "1";
                item.style.transform = `translateX(${pos * 120}px) scale(${1 - Math.abs(pos) * 0.1})`;
                item.style.pointerEvents = "auto";
                item.style.zIndex = visibleRange - Math.abs(pos) + 1;
            }
        });
    }

    // Manejador de clics en tarjetas
    carouselList.addEventListener('click', function(event) {
        const clickedItem = event.target.closest('.carousel__item');
        if (!clickedItem) return;

        const clickedPos = parseInt(clickedItem.dataset.pos);
        if (clickedPos === 0) return;

        moveCarousel(clickedPos > 0 ? -1 : 1);
    });

    // Manejadores de botones
    const btnPrev = document.querySelector('.carousel-control.prev');
    const btnNext = document.querySelector('.carousel-control.next');

    function moveCarousel(direction) {
        const currentCenterIndex = elems.findIndex(item => parseInt(item.dataset.pos) === 0);
        if (currentCenterIndex === -1) return;

        const newCenterIndex = currentCenterIndex + direction;

        // Verificar límites
        if (newCenterIndex < 0 || newCenterIndex >= totalItems) {
            return;
        }

        // Actualizar posiciones
        elems.forEach((item, index) => {
            item.dataset.pos = index - newCenterIndex;
        });

        updatePositions();
    }

    if (btnPrev && btnNext) {
        btnPrev.addEventListener('click', () => {
            const currentCenterIndex = elems.findIndex(item => parseInt(item.dataset.pos) === 0);
            if (currentCenterIndex > 0) {
                moveCarousel(-1);
            }
        });

        btnNext.addEventListener('click', () => {
            const currentCenterIndex = elems.findIndex(item => parseInt(item.dataset.pos) === 0);
            if (currentCenterIndex < totalItems - 1) {
                moveCarousel(1);
            }
        });
    }

    setup();
});

document.addEventListener('DOMContentLoaded', function() {
    const followBtn = document.getElementById('follow-btn');

    if (followBtn) {
        followBtn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const circle = document.createElement('span');
            circle.classList.add('circle');
            circle.style.left = `${x}px`;
            circle.style.top = `${y}px`;
            this.appendChild(circle);

            const btnLoader = this.querySelector('.btn-loader');
            if (btnLoader) btnLoader.classList.remove('d-none');
            this.disabled = true;

            setTimeout(() => circle.remove(), 600);

            const userId = this.dataset.userId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/seguir/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.textContent = data.buttonText;
                        this.className = 'follow-btn';
                        if (data.buttonState) {
                            this.classList.add(data.buttonState);
                        }
                        this.dataset.state = data.buttonState || '';
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    this.disabled = false;
                    const loader = this.querySelector('.btn-loader');
                    if (loader) loader.classList.add('d-none');
                });
        });
    }
});