document.addEventListener('DOMContentLoaded', function() {
    // Obtener los campos y los elementos donde mostrar los errores
    const nombre = document.querySelector('input[name="nombre"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    const passwordConfirmation = document.querySelector('input[name="password_confirmation"]');
    const form = document.querySelector('form');

    // Función para crear y mostrar un mensaje de error
    function showError(input, message) {
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error')) {
            errorElement = document.createElement('span');
            errorElement.classList.add('error');
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }
        errorElement.textContent = message;
    }

    // Función para borrar el mensaje de error
    function clearError(input) {
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error')) {
            errorElement.remove();
        }
    }

    // Función para validar el nombre
    nombre.onblur = function() {
        if (nombre.value.trim() === '') {
            showError(nombre, 'El nombre no puede estar vacío.');
        } else {
            clearError(nombre);
        }
    };

    // Función para validar el email
    email.onblur = function() {
        if (email.value.trim() === '') {
            showError(email, 'El correo electrónico no puede estar vacío.');
        } else if (!email.value.includes('@')) {
            showError(email, 'Por favor, ingresa un correo electrónico válido.');
        } else {
            clearError(email);
        }
    };

    // Función para validar la contraseña
    password.onblur = function() {
        if (password.value.trim() === '') {
            showError(password, 'La contraseña no puede estar vacía.');
        } else if (password.value.length < 6) {
            showError(password, 'La contraseña debe tener al menos 6 caracteres.');
        } else {
            clearError(password);
        }
    };

    // Función para validar la confirmación de la contraseña
    passwordConfirmation.onblur = function() {
        if (passwordConfirmation.value.trim() === '') {
            showError(passwordConfirmation, 'Por favor, confirma tu contraseña.');
        } else if (password.value !== passwordConfirmation.value) {
            showError(passwordConfirmation, 'Las contraseñas no coinciden.');
        } else {
            clearError(passwordConfirmation);
        }
    };

    // Validación al enviar el formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Verificar si el nombre está vacío
        if (nombre.value.trim() === '') {
            showError(nombre, 'El nombre no puede estar vacío.');
            isValid = false;
        }

        // Verificar si el correo tiene una @
        if (email.value.trim() === '') {
            showError(email, 'El correo electrónico no puede estar vacío.');
            isValid = false;
        } else if (!email.value.includes('@')) {
            showError(email, 'Por favor, ingresa un correo electrónico válido.');
            isValid = false;
        }

        // Verificar si la contraseña tiene al menos 6 caracteres
        if (password.value.trim() === '') {
            showError(password, 'La contraseña no puede estar vacía.');
            isValid = false;
        } else if (password.value.length < 6) {
            showError(password, 'La contraseña debe tener al menos 6 caracteres.');
            isValid = false;
        }

        // Verificar si las contraseñas coinciden
        if (passwordConfirmation.value.trim() === '') {
            showError(passwordConfirmation, 'Por favor, confirma tu contraseña.');
            isValid = false;
        } else if (password.value !== passwordConfirmation.value) {
            showError(passwordConfirmation, 'Las contraseñas no coinciden.');
            isValid = false;
        }

        // Si alguna validación falla, prevenimos el envío del formulario
        if (!isValid) {
            e.preventDefault();
        }
    });
});
