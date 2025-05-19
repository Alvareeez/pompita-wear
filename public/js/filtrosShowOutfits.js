document.addEventListener('DOMContentLoaded', function() {
    const nombreFilter = document.getElementById('nombreFilter');
    const creadorFilter = document.getElementById('creadorFilter');
    const outfitsContainer = document.getElementById('outfitsContainer');

    function applyFilters() {
        const nombre = nombreFilter.value;
        const creador = creadorFilter.value;

        const params = new URLSearchParams({
            nombre: nombre || '',
            creador: creador || ''
        });

        fetch(`/outfits/filtrar?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html',
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.text();
            })
            .then(function(html) {
                outfitsContainer.innerHTML = html;
            })
            .catch(function(error) {
                console.error('Error:', error);
                outfitsContainer.innerHTML = '<div class="error">Error al cargar los resultados</div>';
            });
    }

    // Debounce para evitar muchas solicitudes
    let timeout;

    function handleFilterChange() {
        clearTimeout(timeout);
        timeout = setTimeout(applyFilters, 500);
    }

    nombreFilter.addEventListener('keyup', handleFilterChange);
    creadorFilter.addEventListener('keyup', handleFilterChange);
});