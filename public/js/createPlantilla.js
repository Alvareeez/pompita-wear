document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action*="plantilla.submit"]');
    if (!form) return;

    // Campos
    const slug = document.getElementById('slug');
    const nombre = document.getElementById('nombre');
    const foto = document.getElementById('foto');
    const enlace = document.getElementById('enlace');
    const colorPrimario = document.getElementById('color_primario');
    const colorSecundario = document.getElementById('color_secundario');
    const colorTerciario = document.getElementById('color_terciario');

    // Helper para mostrar error
    function showError(input, message) {
        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('invalid-feedback')) {
            error = document.createElement('div');
            error.className = 'invalid-feedback d-block';
            input.parentNode.insertBefore(error, input.nextSibling);
        }
        error.textContent = message;
        input.classList.add('is-invalid');
    }

    function clearError(input) {
        let error = input.nextElementSibling;
        if (error && error.classList.contains('invalid-feedback')) {
            error.textContent = '';
        }
        input.classList.remove('is-invalid');
    }

    // Validaciones individuales
    function validateSlug() {
        clearError(slug);
        if (!slug.value.trim()) {
            showError(slug, 'El campo slug es obligatorio.');
            return false;
        }
        if (!/^[a-zA-Z0-9\-]+$/.test(slug.value)) {
            showError(slug, 'El slug solo puede contener letras, números y guiones.');
            return false;
        }
        return true;
    }

    function validateNombre() {
        clearError(nombre);
        if (!nombre.value.trim()) {
            showError(nombre, 'El campo nombre es obligatorio.');
            return false;
        }
        if (!/^[a-zA-Z0-9\-]+$/.test(nombre.value)) {
            showError(nombre, 'El nombre solo puede contener letras, números y guiones.');
            return false;
        }
        if (nombre.value.trim().length < 3) {
            showError(nombre, 'El nombre debe tener al menos 3 caracteres.');
            return false;
        }
        return true;
    }

    function validateFoto() {
        clearError(foto);
        if (foto.value) {
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (foto.files.length && !allowed.includes(foto.files[0].type)) {
                showError(foto, 'La imagen debe ser JPG, PNG o WEBP.');
                return false;
            }
        }
        return true;
    }

    function validateEnlace() {
        clearError(enlace);
        if (enlace.value.trim() && !/^https?:\/\/.+\..+/.test(enlace.value)) {
            showError(enlace, 'El enlace debe ser una URL válida (ejemplo: https://tusitio.com).');
            return false;
        }
        return true;
    }

    function validateColor(input) {
        clearError(input);
        if (!input.value) {
            showError(input, 'Este campo de color es obligatorio.');
            return false;
        }
        return true;
    }

    // Eventos blur para validación en tiempo real
    slug.addEventListener('blur', validateSlug);
    nombre.addEventListener('blur', validateNombre);
    foto.addEventListener('change', validateFoto);
    enlace.addEventListener('blur', validateEnlace);
    colorPrimario.addEventListener('blur', () => validateColor(colorPrimario));
    colorSecundario.addEventListener('blur', () => validateColor(colorSecundario));
    colorTerciario.addEventListener('blur', () => validateColor(colorTerciario));

    // Validación al enviar
    form.addEventListener('submit', function (e) {
        let valid = true;
        if (!validateSlug()) valid = false;
        if (!validateNombre()) valid = false;
        if (!validateFoto()) valid = false;
        if (!validateEnlace()) valid = false;
        if (!validateColor(colorPrimario)) valid = false;
        if (!validateColor(colorSecundario)) valid = false;
        if (!validateColor(colorTerciario)) valid = false;

        if (!valid) {
            e.preventDefault();
        }
    });
});