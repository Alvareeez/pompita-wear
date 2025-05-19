$(document).ready(function() {
    function applyFilters() {
        const nombre = $('#nombreFilter').val();
        const creador = $('#creadorFilter').val();

        $.ajax({
            url: '/outfits/filtrar',
            type: "GET",
            data: {
                nombre: nombre,
                creador: creador
            },
            success: function(response) {
                $('#outfitsContainer').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                $('#outfitsContainer').html('<div class="error">Error al cargar los resultados</div>');
            }
        });
    }

    // Debounce para evitar muchas solicitudes
    let timeout;
    $('#nombreFilter, #creadorFilter').on('keyup', function() {
        clearTimeout(timeout);
        timeout = setTimeout(applyFilters, 500);
    });

    // Aplicar filtros al cargar la página si hay parámetros en la URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('nombre') || urlParams.has('creador')) {
        $('#nombreFilter').val(urlParams.get('nombre') || '');
        $('#creadorFilter').val(urlParams.get('creador') || '');
        applyFilters();
    }
});