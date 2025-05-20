document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const results    = document.getElementById('carousel-results');
    const createForm = document.getElementById('create-outfit-form');

    // ————— Inicialización de carruseles y selección de prendas —————
    function actualizarSeleccion() {
        document.querySelectorAll('.carousel').forEach(carousel => {
            const parte  = carousel.dataset.parte;
            const activa = carousel.querySelector('.carousel-item.active');
            const prendaId = activa ? activa.dataset.prendaId : '';
            const hidden = document.getElementById('prenda_' + parte);
            if (hidden) hidden.value = prendaId;
        });
    }

    function initCarousels() {
        document.querySelectorAll('.carousel').forEach(carousel => {
            carousel.addEventListener('slid.bs.carousel', actualizarSeleccion);
        });
        actualizarSeleccion();
    }

    initCarousels();

    // ————— Filtrado AJAX —————
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Mostrar spinner mientras carga
        results.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border" role="status"></div>
            </div>
        `;

        const url = filterForm.action + '?' + new URLSearchParams(new FormData(filterForm)).toString();
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                results.innerHTML = html;
                initCarousels();
            })
            .catch(err => {
                console.error(err);
                results.innerHTML = '<p class="text-danger text-center">Error al cargar las prendas.</p>';
            });
    });

    // ————— Validaciones antes de crear el outfit —————
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            // Validar nombre no vacío
            const nombre = document.getElementById('nombre_outfit').value.trim();
            if (!nombre) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Nombre vacío',
                    text: 'Debes darle un nombre a tu outfit.'
                });
                return;
            }

            // Validar que cada parte tenga al menos una prenda seleccionada
            const partes = ['cabeza', 'torso', 'piernas', 'pies'];
            for (let parte of partes) {
                const val = document.getElementById('prenda_' + parte).value;
                if (!val) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Falta prenda',
                        text: `Selecciona al menos una prenda para "${parte}".`
                    });
                    return;
                }
            }
        });
    }
});
