document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    
    // Función de validación
    function validateForm() {
        let isValid = true;

        // Validar email
        const emailValue = emailInput.value.trim();
        const emailError = document.getElementById('email-error');
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailValue) {
            emailError.textContent = "El correo electrónico no puede estar vacío";
            isValid = false;
        } else if (!emailRegex.test(emailValue)) {
            emailError.textContent = "Por favor, introduce un correo electrónico válido";
            isValid = false;
        } else {
            emailError.textContent = "";
        }

        // Validar contraseña
        const passwordValue = passwordInput.value.trim();
        const passwordError = document.getElementById('password-error');
        if (!passwordValue) {
            passwordError.textContent = "La contraseña no puede estar vacía";
            isValid = false;
        } else if (passwordValue.length < 6) {
            passwordError.textContent = "La contraseña debe tener al menos 6 caracteres";
            isValid = false;
        } else {
            passwordError.textContent = "";
        }

        return isValid;
    }

    // Validar en el evento onblur
    emailInput.addEventListener("blur", validateForm);
    passwordInput.addEventListener("blur", validateForm);
});
