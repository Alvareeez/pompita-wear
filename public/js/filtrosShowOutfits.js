document.addEventListener('DOMContentLoaded', function() {
    const nombreFilter = document.getElementById('nombreFilter');
    const creadorFilter = document.getElementById('creadorFilter');
    const outfitsContainer = document.getElementById('outfitsContainer');

    async function applyFilters() {
        const nombre = nombreFilter.value;
        const creador = creadorFilter.value;

        try {
            const params = new URLSearchParams({
                nombre: nombre || '',
                creador: creador || ''
            });

            const response = await fetch(`/outfits/filtrar?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html',
                }
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const html = await response.text();
            outfitsContainer.innerHTML = html;
        } catch (error) {
            console.error('Error:', error);
            outfitsContainer.innerHTML = '<div class="error">Error al cargar los resultados</div>';
        }
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