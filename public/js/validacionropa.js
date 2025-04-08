document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const descripcionInput = document.getElementById("descripcion");
    const precioInput = document.getElementById("precio");
    const tipoPrendaSelect = document.getElementById("id_tipoPrenda");
    const imgFrontalInput = document.getElementById("img_frontal");
    const imgTraseraInput = document.getElementById("img_trasera");

    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Limpiar mensajes de error previos
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach((msg) => msg.remove());

        // Validar descripción
        if (descripcionInput.value.trim() === "") {
            showError(descripcionInput, "La descripción es obligatoria.");
            isValid = false;
        } else if (descripcionInput.value.trim().length < 10) {
            showError(descripcionInput, "La descripción debe tener al menos 10 caracteres.");
            isValid = false;
        }

        // Validar precio
        if (precioInput.value.trim() === "") {
            showError(precioInput, "El precio es obligatorio.");
            isValid = false;
        } else if (isNaN(precioInput.value) || parseFloat(precioInput.value) <= 0) {
            showError(precioInput, "El precio debe ser un número mayor a 0.");
            isValid = false;
        }

        // Validar tipo de prenda
        if (tipoPrendaSelect.value === "") {
            showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
            isValid = false;
        }

        // Validar imagen frontal
        if (imgFrontalInput && imgFrontalInput.files.length === 0) {
            showError(imgFrontalInput, "Debes subir una imagen frontal.");
            isValid = false;
        }

        // Validar imagen trasera
        if (imgTraseraInput && imgTraseraInput.files.length === 0) {
            showError(imgTraseraInput, "Debes subir una imagen trasera.");
            isValid = false;
        }

        // Si hay errores, prevenir el envío del formulario
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Validar descripción al perder el foco
    descripcionInput.addEventListener("blur", function () {
        clearError(descripcionInput);
        if (descripcionInput.value.trim() === "") {
            showError(descripcionInput, "La descripción es obligatoria.");
        } else if (descripcionInput.value.trim().length < 10) {
            showError(descripcionInput, "La descripción debe tener al menos 10 caracteres.");
        }
    });

    // Validar precio al perder el foco
    precioInput.addEventListener("blur", function () {
        clearError(precioInput);
        if (precioInput.value.trim() === "") {
            showError(precioInput, "El precio es obligatorio.");
        } else if (isNaN(precioInput.value) || parseFloat(precioInput.value) <= 0) {
            showError(precioInput, "El precio debe ser un número mayor a 0.");
        }
    });

    // Validar tipo de prenda al perder el foco
    tipoPrendaSelect.addEventListener("blur", function () {
        clearError(tipoPrendaSelect);
        if (tipoPrendaSelect.value === "") {
            showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
        }
    });

    // Validar imagen frontal al perder el foco
    imgFrontalInput.addEventListener("blur", function () {
        clearError(imgFrontalInput);
        if (imgFrontalInput.files.length === 0) {
            showError(imgFrontalInput, "Debes subir una imagen frontal.");
        }
    });

    // Validar imagen trasera al perder el foco
    imgTraseraInput.addEventListener("blur", function () {
        clearError(imgTraseraInput);
        if (imgTraseraInput.files.length === 0) {
            showError(imgTraseraInput, "Debes subir una imagen trasera.");
        }
    });

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