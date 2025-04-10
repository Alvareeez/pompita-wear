document.addEventListener("DOMContentLoaded", function () {
    const nombreInput = document.getElementById("nombre");

    // Validar nombre al perder el foco
    if (nombreInput) {
        nombreInput.addEventListener("blur", function () {
            clearError(nombreInput);
            if (nombreInput.value.trim() === "") {
                showError(nombreInput, "El nombre de la etiqueta es obligatorio.");
            } else if (nombreInput.value.trim().length < 3) {
                showError(nombreInput, "El nombre de la etiqueta debe tener al menos 3 caracteres.");
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