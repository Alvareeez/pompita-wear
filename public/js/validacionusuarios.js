document.addEventListener("DOMContentLoaded", function () {
    const nombreInput = document.getElementById("nombre");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const passwordConfirmationInput = document.getElementById("password_confirmation");
    const rolSelect = document.getElementById("id_rol");

    // Validar nombre al perder el foco
    if (nombreInput) {
        nombreInput.addEventListener("blur", function () {
            clearError(nombreInput);
            if (nombreInput.value.trim() === "") {
                showError(nombreInput, "El nombre es obligatorio.");
            } else if (nombreInput.value.trim().length < 3) {
                showError(nombreInput, "El nombre debe tener al menos 3 caracteres.");
            }
        });
    }

    // Validar email al perder el foco
    if (emailInput) {
        emailInput.addEventListener("blur", function () {
            clearError(emailInput);
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === "") {
                showError(emailInput, "El correo electrónico es obligatorio.");
            } else if (!emailRegex.test(emailInput.value.trim())) {
                showError(emailInput, "El correo electrónico no es válido.");
            }
        });
    }

    // Validar contraseña al perder el foco
    if (passwordInput) {
        passwordInput.addEventListener("blur", function () {
            clearError(passwordInput);
            if (passwordInput.value.trim() === "") {
                showError(passwordInput, "La contraseña es obligatoria.");
            } else if (passwordInput.value.trim().length < 8) {
                showError(passwordInput, "La contraseña debe tener al menos 8 caracteres.");
            }
        });
    }

    // Validar confirmación de contraseña al perder el foco
    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener("blur", function () {
            clearError(passwordConfirmationInput);
            if (passwordConfirmationInput.value.trim() !== passwordInput.value.trim()) {
                showError(passwordConfirmationInput, "Las contraseñas no coinciden.");
            }
        });
    }

    // Validar rol al perder el foco
    if (rolSelect) {
        rolSelect.addEventListener("blur", function () {
            clearError(rolSelect);
            if (rolSelect.value === "") {
                showError(rolSelect, "Debes seleccionar un rol.");
            }
        });
    }

    // Función para mostrar mensajes de error
    function showError(input, message) {
        const error = document.createElement("span");
        error.classList.add("error-message");
        error.style.color = "red";
        error.style.fontSize = "12px";
        error.style.marginTop = "5px";
        error.textContent = message;

        // Insertar el mensaje de error después del campo
        input.parentNode.appendChild(error);
    }

    // Función para limpiar mensajes de error previos
    function clearError(input) {
        const error = input.parentNode.querySelector(".error-message");
        if (error) {
            error.remove();
        }
    }
});