function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

function getUrlParameter(name, url) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    let regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    let results = regex.exec(url);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

$(document).ready(function () {
    // Helper para mostrar/ocultar spinner
    function showSpinner() {
        $('#loading-spinner').show();
    }
    function hideSpinner() {
        $('#loading-spinner').hide();
    }

    // Limpiar filtros
    $('#clear-filters-btn').on('click', function () {
        $('#filtro-nombre').val('');
        $('#filtro-estilos').val('');
        $('#filtro-etiquetas').val('');
        $('#filtro-colores').val('');

        showSpinner();
        $.ajax({
            url: ropaIndexUrl,
            method: 'GET',
            data: {},
            success: function (response) {
                $('#tabla-prendas-contenedor').html($(response).find('#tabla-prendas-contenedor').html());
                hideSpinner();
            },
            error: function (error) {
                console.error('Error:', error);
                hideSpinner();
            }
        });
    });

    // Filtros automáticos
    $('#filtro-nombre, #filtro-estilos, #filtro-etiquetas, #filtro-colores').on('input change', function () {
        const nombre = $('#filtro-nombre').val();
        const estilos = $('#filtro-estilos').val();
        const etiquetas = $('#filtro-etiquetas').val();
        const colores = $('#filtro-colores').val();

        showSpinner();
        $.ajax({
            url: ropaIndexUrl,
            method: 'GET',
            data: {
                nombre: nombre,
                estilos: estilos,
                etiquetas: etiquetas,
                colores: colores,
            },
            success: function (response) {
                $('#tabla-prendas-contenedor').html($(response).find('#tabla-prendas-contenedor').html());
                hideSpinner();
            },
            error: function (error) {
                console.error('Error:', error);
                hideSpinner();
            }
        });
    });

    // Paginación con filtros
    $(document).on('click', '.pagination-container .pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let nombre = $('#filtro-nombre').val();
        let estilos = $('#filtro-estilos').val();
        let etiquetas = $('#filtro-etiquetas').val();
        let colores = $('#filtro-colores').val();

        let params = [];
        if (nombre) params.push('nombre=' + encodeURIComponent(nombre));
        if (estilos) params.push('estilos=' + encodeURIComponent(estilos));
        if (etiquetas) params.push('etiquetas=' + encodeURIComponent(etiquetas));
        if (colores) params.push('colores=' + encodeURIComponent(colores));

        if (params.length > 0) {
            url = url.split('?')[0] + '?' + params.join('&') + '&page=' + (getUrlParameter('page', url) || 1);
        }

        showSpinner();
        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                $('#tabla-prendas-contenedor').html($(response).find('#tabla-prendas-contenedor').html());
                hideSpinner();
            },
            error: function (error) {
                console.error('Error:', error);
                hideSpinner();
            }
        });
    });
});