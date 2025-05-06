document.addEventListener('DOMContentLoaded', function() {
    const form    = document.getElementById('filter-form');
    const results = document.getElementById('carousel-results');

    // Actualiza los inputs hidden según el slide activo
    function actualizarSeleccion() {
        document.querySelectorAll('.carousel').forEach(car => {
            const parte    = car.dataset.parte;
            const activa   = car.querySelector('.carousel-item.active');
            const prendaId = activa.dataset.prendaId;
            document.getElementById('prenda_' + parte).value = prendaId;
        });
    }

    // Inicia listeners de Bootstrap y selección inicial
    function initCarousels() {
        document.querySelectorAll('.carousel').forEach(carousel => {
            carousel.addEventListener('slid.bs.carousel', actualizarSeleccion);
        });
        actualizarSeleccion();
    }

    // Envía filtros vía AJAX y re-renderiza el carrusel
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const url = form.action + '?' + new URLSearchParams(new FormData(form));
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                results.innerHTML = html;
                initCarousels();
            })
            .catch(console.error);
    });

    // Inicialización al cargar
    initCarousels();
});
