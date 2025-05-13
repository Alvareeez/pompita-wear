document.addEventListener("DOMContentLoaded", function () {
    const nombreInput = document.querySelector("input[name='nombre']");
    const descripcionInput = document.querySelector("textarea[name='descripcion']");
    const tipoPrendaSelect = document.querySelector("select[name='id_tipoPrenda']");
    const precioInput = document.querySelector("input[name='precio']");
    const imgFrontalInput = document.querySelector("input[name='img_frontal']");
    const etiquetasCheckboxes = document.querySelectorAll("input[name='etiquetas[]']");
    const coloresCheckboxes = document.querySelectorAll("input[name='colores[]']");
    const estilosCheckboxes = document.querySelectorAll("input[name='estilos[]']");
    const form = document.querySelector("form");

    // Validar nombre
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

    // Validar descripción
    if (descripcionInput) {
        descripcionInput.addEventListener("blur", function () {
            clearError(descripcionInput);
            if (descripcionInput.value.trim() === "") {
                showError(descripcionInput, "La descripción es obligatoria.");
            } else if (descripcionInput.value.trim().length < 10) {
                showError(descripcionInput, "La descripción debe tener al menos 10 caracteres.");
            }
        });
    }

    // Validar tipo de prenda
    if (tipoPrendaSelect) {
        tipoPrendaSelect.addEventListener("blur", function () {
            clearError(tipoPrendaSelect);
            if (tipoPrendaSelect.value === "") {
                showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
            }
        });
    }

    // Validar precio
    if (precioInput) {
        precioInput.addEventListener("blur", function () {
            clearError(precioInput);
            if (precioInput.value.trim() === "") {
                showError(precioInput, "El precio es obligatorio.");
            } else if (isNaN(precioInput.value) || parseFloat(precioInput.value) <= 0) {
                showError(precioInput, "El precio debe ser un número mayor a 0.");
            }
        });
    }

    // Validar imagen frontal
    if (imgFrontalInput) {
        imgFrontalInput.addEventListener("change", function () {
            clearError(imgFrontalInput);
            if (imgFrontalInput.files.length === 0) {
                showError(imgFrontalInput, "Debes subir una imagen frontal.");
            }
        });
    }

    // Validar al menos una etiqueta seleccionada
    if (etiquetasCheckboxes.length > 0) {
        etiquetasCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(etiquetasCheckboxes[0]);
                if (!isAnyChecked(etiquetasCheckboxes)) {
                    showError(etiquetasCheckboxes[0], "Debes seleccionar al menos una etiqueta.");
                }
            });
        });
    }

    // Validar al menos un color seleccionado
    if (coloresCheckboxes.length > 0) {
        coloresCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(coloresCheckboxes[0]);
                if (!isAnyChecked(coloresCheckboxes)) {
                    showError(coloresCheckboxes[0], "Debes seleccionar al menos un color.");
                }
            });
        });
    }

    // Validar al menos un estilo seleccionado
    if (estilosCheckboxes.length > 0) {
        estilosCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(estilosCheckboxes[0]);
                if (!isAnyChecked(estilosCheckboxes)) {
                    showError(estilosCheckboxes[0], "Debes seleccionar al menos un estilo.");
                }
            });
        });
    }

    // Validar formulario antes de enviarlo
    if (form) {
        form.addEventListener("submit", function (event) {
            let isValid = true;

            // Validar todos los campos
            if (nombreInput && nombreInput.value.trim() === "") {
                showError(nombreInput, "El nombre es obligatorio.");
                isValid = false;
            }
            if (descripcionInput && descripcionInput.value.trim() === "") {
                showError(descripcionInput, "La descripción es obligatoria.");
                isValid = false;
            }
            if (tipoPrendaSelect && tipoPrendaSelect.value === "") {
                showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
                isValid = false;
            }
            if (precioInput && (precioInput.value.trim() === "" || parseFloat(precioInput.value) <= 0)) {
                showError(precioInput, "El precio debe ser un número mayor a 0.");
                isValid = false;
            }
            if (imgFrontalInput && imgFrontalInput.files.length === 0) {
                showError(imgFrontalInput, "Debes subir una imagen frontal.");
                isValid = false;
            }
            if (!isAnyChecked(etiquetasCheckboxes)) {
                showError(etiquetasCheckboxes[0], "Debes seleccionar al menos una etiqueta.");
                isValid = false;
            }
            if (!isAnyChecked(coloresCheckboxes)) {
                showError(coloresCheckboxes[0], "Debes seleccionar al menos un color.");
                isValid = false;
            }
            if (!isAnyChecked(estilosCheckboxes)) {
                showError(estilosCheckboxes[0], "Debes seleccionar al menos un estilo.");
                isValid = false;
            }

            // Si no es válido, prevenir el envío
            if (!isValid) {
                event.preventDefault();
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

    // Función para verificar si al menos un checkbox está seleccionado
    function isAnyChecked(checkboxes) {
        return Array.from(checkboxes).some(function (checkbox) {
            return checkbox.checked;
        });
    }
});