// createPlantilla.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('createPlantilla.js cargado');

    const form             = document.getElementById('plantillaForm');
    if (!form) return;

    const slug             = document.getElementById('slug');
    const nombre           = document.getElementById('nombre');
    const foto             = document.getElementById('foto');
    const enlace           = document.getElementById('enlace');
    const colorPrimario    = document.getElementById('color_primario');
    const colorSecundario  = document.getElementById('color_secundario');
    const colorTerciario   = document.getElementById('color_terciario');

    function showError(input, message) {
        clearError(input);
        input.classList.add('is-invalid');
        const fb = document.createElement('div');
        fb.className = 'invalid-feedback d-block';
        fb.textContent = message;
        input.parentNode.appendChild(fb);
    }

    function clearError(input) {
        input.classList.remove('is-invalid');
        const fb = input.parentNode.querySelector('.invalid-feedback');
        if (fb) fb.remove();
    }

    function validateSlug() {
        clearError(slug);
        const v = slug.value.trim();
        if (!v) {
            showError(slug, 'El campo slug es obligatorio.');
            return false;
        }
        if (!/^[a-zA-Z0-9\-]+$/.test(v)) {
            showError(slug, 'El slug solo puede contener letras, números y guiones.');
            return false;
        }
        return true;
    }

    function validateNombre() {
        clearError(nombre);
        const v = nombre.value.trim();
        if (!v) {
            showError(nombre, 'El campo nombre es obligatorio.');
            return false;
        }
        if (!/^[a-zA-Z0-9\- ]+$/.test(v)) {
            showError(nombre, 'El nombre solo puede contener letras, números, espacios y guiones.');
            return false;
        }
        if (v.length < 3) {
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
        const v = enlace.value.trim();
        if (v && !/^https?:\/\/.+\..+/.test(v)) {
            showError(enlace, 'El enlace debe ser una URL válida (ej: https://tusitio.com).');
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

    // Onblur / onchange
    slug.addEventListener('blur',   validateSlug);
    nombre.addEventListener('blur', validateNombre);
    foto.addEventListener('change', validateFoto);
    enlace.addEventListener('blur', validateEnlace);
    colorPrimario.addEventListener('change', () => validateColor(colorPrimario));
    colorSecundario.addEventListener('change', () => validateColor(colorSecundario));
    colorTerciario.addEventListener('change', () => validateColor(colorTerciario));

    // Submit
    form.addEventListener('submit', function (e) {
        let ok = true;

        if (!validateSlug())          ok = false;
        if (!validateNombre())        ok = false;
        if (!validateFoto())          ok = false;
        if (!validateEnlace())        ok = false;
        if (!validateColor(colorPrimario))   ok = false;
        if (!validateColor(colorSecundario)) ok = false;
        if (!validateColor(colorTerciario))  ok = false;

        if (!ok) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                text: 'Por favor, corrige los campos resaltados.',
                confirmButtonText: 'Entendido'
            });
        }
    });
});
