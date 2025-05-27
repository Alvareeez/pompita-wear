document.addEventListener('DOMContentLoaded', function() {
    // Toggle para mostrar/ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        const input = document.getElementById(toggle.dataset.target);
        const icon = toggle.querySelector('i');
        toggle.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    // Mostrar/ocultar campos de empresa y activar/desactivar validaciones nativas
    const rolSelect = document.getElementById('rol');
    const datosEmpresa = document.getElementById('datos-empresa');
    const razonInput = document.querySelector('input[name="razon_social"]');
    const nifInput   = document.querySelector('input[name="nif"]');

    function toggleEmpresa() {
        const esEmpresa = rolSelect.value === 'empresa';
        datosEmpresa.style.display = esEmpresa ? 'block' : 'none';

        // Deshabilita/activa y required/no-required
        razonInput.disabled = !esEmpresa;
        nifInput.disabled   = !esEmpresa;

        razonInput.required = esEmpresa;
        nifInput.required   = esEmpresa;

        // Limpia mensaje de error si deshabilitado
        if (!esEmpresa) {
            razonInput.parentElement.querySelector('.error').textContent = '';
            nifInput.parentElement.querySelector('.error').textContent = '';
        }
    }

    rolSelect.addEventListener('change', toggleEmpresa);
    toggleEmpresa();

    // Validaciones onBlur
    function validateNombre() {
        const input = document.querySelector('input[name="nombre"]');
        const err   = input.parentElement.querySelector('.error');
        if (!input.value.trim()) {
            err.textContent = 'El nombre completo es obligatorio.';
            return false;
        }
        if (input.value.length < 2) {
            err.textContent = 'El nombre debe tener al menos 2 caracteres.';
            return false;
        }
        if (input.value.length > 255) {
            err.textContent = 'El nombre no puede superar los 255 caracteres.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    function validateEmail() {
        const input = document.querySelector('input[name="email"]');
        const err   = input.parentElement.querySelector('.error');
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!input.value.trim()) {
            err.textContent = 'El correo electrónico es obligatorio.';
            return false;
        }
        if (!regex.test(input.value)) {
            err.textContent = 'El correo electrónico no es válido.';
            return false;
        }
        if (input.value.length > 255) {
            err.textContent = 'El correo no puede superar los 255 caracteres.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    function validatePassword() {
        const input = document.getElementById('password');
        const err   = input.parentElement.parentElement.querySelector('.error');
        if (!input.value) {
            err.textContent = 'La contraseña es obligatoria.';
            return false;
        }
        if (input.value.length < 8) {
            err.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    function validatePasswordConfirmation() {
        const pass  = document.getElementById('password');
        const input = document.getElementById('password_confirmation');
        const err   = input.parentElement.parentElement.querySelector('.error');
        if (!input.value) {
            err.textContent = 'Por favor, repite la contraseña.';
            return false;
        }
        if (pass.value !== input.value) {
            err.textContent = 'Las contraseñas no coinciden.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    function validateRazonSocial() {
        if (rolSelect.value !== 'empresa') return true;
        const input = razonInput;
        const err   = input.parentElement.querySelector('.error');
        if (!input.value.trim()) {
            err.textContent = 'El nombre de la marca es obligatorio.';
            return false;
        }
        if (input.value.length > 255) {
            err.textContent = 'El nombre de la marca no puede superar los 255 caracteres.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    function validateNIF() {
        if (rolSelect.value !== 'empresa') return true;
        const input = nifInput;
        const err   = input.parentElement.querySelector('.error');
        const regex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
        if (!input.value.trim()) {
            err.textContent = 'El NIF es obligatorio.';
            return false;
        }
        if (input.value.length < 9) {
            err.textContent = 'El NIF debe tener al menos 9 caracteres.';
            return false;
        }
        if (input.value.length > 20) {
            err.textContent = 'El NIF no puede superar los 20 caracteres.';
            return false;
        }
        if (!regex.test(input.value)) {
            err.textContent = 'El formato del NIF no es válido.';
            return false;
        }
        err.textContent = '';
        return true;
    }

    // Asignar eventos onblur
    document.querySelector('input[name="nombre"]').addEventListener('blur', validateNombre);
    document.querySelector('input[name="email"]').addEventListener('blur', validateEmail);
    document.getElementById('password').addEventListener('blur', validatePassword);
    document.getElementById('password_confirmation').addEventListener('blur', validatePasswordConfirmation);
    razonInput.addEventListener('blur', validateRazonSocial);
    nifInput.addEventListener('blur', validateNIF);

    // Validación antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const nombreOk    = validateNombre();
        const emailOk     = validateEmail();
        const passOk      = validatePassword();
        const pass2Ok     = validatePasswordConfirmation();
        const marcaOk     = validateRazonSocial();
        const nifOk       = validateNIF();

        if (!nombreOk || !emailOk || !passOk || !pass2Ok || !marcaOk || !nifOk) {
            e.preventDefault();
        }
    });
});
