document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkout-form');
    const selectPrenda = document.getElementById('prenda_id');

    if (!form || !selectPrenda) return;

    // Helper para mostrar error debajo del select
    function showError(message) {
        let error = selectPrenda.nextElementSibling;
        if (!error || !error.classList.contains('invalid-feedback')) {
            error = document.createElement('div');
            error.className = 'invalid-feedback d-block';
            selectPrenda.parentNode.insertBefore(error, selectPrenda.nextSibling);
        }
        error.textContent = message;
        selectPrenda.classList.add('is-invalid');
    }

    function clearError() {
        let error = selectPrenda.nextElementSibling;
        if (error && error.classList.contains('invalid-feedback')) {
            error.textContent = '';
        }
        selectPrenda.classList.remove('is-invalid');
    }

    // Validación al cambiar el select
    selectPrenda.addEventListener('change', function () {
        clearError();
        if (!selectPrenda.value) {
            showError('Debes seleccionar una prenda para destacar.');
        }
    });

    // Validación al enviar el formulario
    form.addEventListener('submit', function (e) {
        clearError();
        if (!selectPrenda.value) {
            showError('Debes seleccionar una prenda para destacar.');
            e.preventDefault();
        }
    });
});