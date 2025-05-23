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

    // Mostrar/ocultar campos de empresa
    const rolSelect = document.getElementById('rol');
    const datosEmpresa = document.getElementById('datos-empresa');

    function toggleEmpresa() {
        datosEmpresa.style.display = rolSelect.value === 'empresa' ? 'block' : 'none';
    }

    rolSelect.addEventListener('change', toggleEmpresa);
    toggleEmpresa();

    // Validaciones onBlur
    function validateNombre() {
        const nombreInput = document.querySelector('input[name="nombre"]');
        const errorElement = nombreInput.parentElement.querySelector('.error');

        if (!nombreInput.value.trim()) {
            errorElement.textContent = 'El nombre completo es obligatorio.';
            return false;
        }

        if (nombreInput.value.length > 255) {
            errorElement.textContent = 'El nombre no puede superar los 255 caracteres.';
            return false;
        }
        if (nombreInput.value.length < 2) {
            errorElement.textContent = 'El nombre debe tener al menos 2 caracteres.';
            return false;
        }
        errorElement.textContent = '';
        return true;
    }

    function validateEmail() {
        const emailInput = document.querySelector('input[name="email"]');
        const errorElement = emailInput.parentElement.querySelector('.error');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailInput.value.trim()) {
            errorElement.textContent = 'El correo electrónico es obligatorio.';
            return false;
        }

        if (!emailRegex.test(emailInput.value)) {
            errorElement.textContent = 'El correo electrónico no es válido.';
            return false;
        }

        if (emailInput.value.length > 255) {
            errorElement.textContent = 'El correo no puede superar los 255 caracteres.';
            return false;
        }

        errorElement.textContent = '';
        return true;
    }

    function validatePassword() {
        const passwordInput = document.getElementById('password');
        const errorElement = passwordInput.parentElement.parentElement.querySelector('.error');

        if (!passwordInput.value) {
            errorElement.textContent = 'La contraseña es obligatoria.';
            return false;
        }

        if (passwordInput.value.length < 8) {
            errorElement.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            return false;
        }

        errorElement.textContent = '';
        return true;
    }

    function validatePasswordConfirmation() {
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const errorElement = passwordConfirmationInput.parentElement.parentElement.querySelector('.error');

        if (!passwordConfirmationInput.value) {
            errorElement.textContent = 'Por favor, repite la contraseña.';
            return false;
        }

        if (passwordInput.value !== passwordConfirmationInput.value) {
            errorElement.textContent = 'Las contraseñas no coinciden.';
            return false;
        }

        errorElement.textContent = '';
        return true;
    }

    function validateRazonSocial() {
        if (rolSelect.value !== 'empresa') return true;

        const razonSocialInput = document.querySelector('input[name="razon_social"]');
        const errorElement = razonSocialInput.parentElement.querySelector('.error');

        if (!razonSocialInput.value.trim()) {
            errorElement.textContent = 'El nombre de la marca es obligatorio.';
            return false;
        }

        if (razonSocialInput.value.length > 255) {
            errorElement.textContent = 'El nombre de la marca no puede superar los 255 caracteres.';
            return false;
        }

        errorElement.textContent = '';
        return true;
    }

    function validateNIF() {
        if (rolSelect.value !== 'empresa') return true;

        const nifInput = document.querySelector('input[name="nif"]');
        const errorElement = nifInput.parentElement.querySelector('.error');
        const nifRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;

        if (!nifInput.value.trim()) {
            errorElement.textContent = 'El NIF es obligatorio.';
            return false;
        }
        if (nifInput.value && nifInput.value.length > 20) {
            errorElement.textContent = 'El NIF no puede superar los 20 caracteres.';
            return false;
        }
        if (nifInput.value.length < 9) {
            errorElement.textContent = 'El NIF debe tener al menos 9 caracteres.';
            return false;
        }

        if (!nifRegex.test(nifInput.value)) {
            errorElement.textContent = 'El formato del NIF no es válido.';
            return false;
        }

        errorElement.textContent = '';
        return true;
    }

    // Asignar eventos onblur
    document.querySelector('input[name="nombre"]').addEventListener('blur', validateNombre);
    document.querySelector('input[name="email"]').addEventListener('blur', validateEmail);
    document.getElementById('password').addEventListener('blur', validatePassword);
    document.getElementById('password_confirmation').addEventListener('blur', validatePasswordConfirmation);
    document.querySelector('input[name="razon_social"]').addEventListener('blur', validateRazonSocial);
    document.querySelector('input[name="nif"]').addEventListener('blur', validateNIF);

    // Validación antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const isNombreValid = validateNombre();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isPasswordConfirmationValid = validatePasswordConfirmation();
        const isRazonSocialValid = validateRazonSocial();
        const isNIFValid = validateNIF();

        if (!isNombreValid || !isEmailValid || !isPasswordValid ||
            !isPasswordConfirmationValid || !isRazonSocialValid || !isNIFValid) {
            e.preventDefault();
        }
    });
});