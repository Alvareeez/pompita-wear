// public/js/filtrarPrendasAjax.js

document.addEventListener('DOMContentLoaded', function() {
    const form    = document.getElementById('filter-form');
    const results = document.getElementById('results');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            results.innerHTML = html;
            attachPaginationLinks();
        })
        .catch(console.error);
    });

    function attachPaginationLinks() {
        document.querySelectorAll('#pagination-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageUrl = new URL(this.href);
                const page    = pageUrl.searchParams.get('page');

                // Asegurarse de que exista un input oculto para la página
                let pageInput = form.querySelector('input[name=page]');
                if (!pageInput) {
                    pageInput = document.createElement('input');
                    pageInput.type = 'hidden';
                    pageInput.name = 'page';
                    form.appendChild(pageInput);
                }
                pageInput.value = page;

                // Re-disparar el envío del formulario para recargar vía AJAX
                form.dispatchEvent(new Event('submit'));
            });
        });
    }

    // Inicializar enlaces de paginación AJAX al cargar
    attachPaginationLinks();
});
