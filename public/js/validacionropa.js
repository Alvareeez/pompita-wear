document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const descripcionInput = document.getElementById("descripcion");
    const tipoPrendaSelect = document.getElementById("id_tipoPrenda");
    const imgFrontalInput = document.getElementById("img_frontal");
    const imgTraseraInput = document.getElementById("img_trasera");
    const estilosSelect = document.getElementById("estilos");
    const etiquetasSelect = document.getElementById("etiquetas");
    const coloresSelect = document.getElementById("colores");
    const nombreInput = document.getElementById("nombre");

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

        // Validar estilos
        if (estilosSelect && estilosSelect.selectedOptions.length === 0) {
            showError(estilosSelect, "Debes seleccionar al menos un estilo.");
            isValid = false;
        }

        // Validar etiquetas
        if (etiquetasSelect && etiquetasSelect.selectedOptions.length === 0) {
            showError(etiquetasSelect, "Debes seleccionar al menos una etiqueta.");
            isValid = false;
        }

        // Validar colores
        if (coloresSelect && coloresSelect.selectedOptions.length === 0) {
            showError(coloresSelect, "Debes seleccionar al menos un color.");
            isValid = false;
        }

        // Validar nombre
        if (nombreInput.value.trim() === "") {
            showError(nombreInput, "El nombre es obligatorio.");
            isValid = false;
        } else if (nombreInput.value.trim().length < 3) {
            showError(nombreInput, "El nombre debe tener al menos 3 caracteres.");
            isValid = false;
        }

        // Si hay errores, prevenir el envío del formulario
        if (!isValid) {
            event.preventDefault();
        }
    });

    descripcionInput.addEventListener("blur", function () {
        clearError(descripcionInput);
        if (descripcionInput.value.trim() === "") {
            showError(descripcionInput, "La descripción es obligatoria.");
        } else if (descripcionInput.value.trim().length < 10) {
            showError(descripcionInput, "La descripción debe tener al menos 10 caracteres.");
        }
    });

    tipoPrendaSelect.addEventListener("blur", function () {
        clearError(tipoPrendaSelect);
        if (tipoPrendaSelect.value === "") {
            showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
        }
    });

    estilosSelect.addEventListener("blur", function () {
        clearError(estilosSelect);
        if (estilosSelect.selectedOptions.length === 0) {
            showError(estilosSelect, "Debes seleccionar al menos un estilo.");
        }
    });

    etiquetasSelect.addEventListener("blur", function () {
        clearError(etiquetasSelect);
        if (etiquetasSelect.selectedOptions.length === 0) {
            showError(etiquetasSelect, "Debes seleccionar al menos una etiqueta.");
        }
    });

    coloresSelect.addEventListener("blur", function () {
        clearError(coloresSelect);
        if (coloresSelect.selectedOptions.length === 0) {
            showError(coloresSelect, "Debes seleccionar al menos un color.");
        }
    });

    nombreInput.addEventListener("blur", function () {
        clearError(nombreInput);
        if (nombreInput.value.trim() === "") {
            showError(nombreInput, "El nombre es obligatorio.");
        } else if (nombreInput.value.trim().length < 3) {
            showError(nombreInput, "El nombre debe tener al menos 3 caracteres.");
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