document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const nombreInput = document.querySelector("input[name='nombre']");
    const descripcionInput = document.querySelector("textarea[name='descripcion']");
    const tipoPrendaSelect = document.querySelector("select[name='id_tipoPrenda']");
    const imgFrontalInput = document.querySelector("input[name='img_frontal']");
    const etiquetasContainer = document.querySelector(".checkbox-grid[name='etiquetas']");
    const coloresContainer = document.querySelector(".checkbox-grid[name='colores']");
    const estilosContainer = document.querySelector(".checkbox-grid[name='estilos']");
    const etiquetasCheckboxes = document.querySelectorAll("input[name='etiquetas[]']");
    const coloresCheckboxes = document.querySelectorAll("input[name='colores[]']");
    const estilosCheckboxes = document.querySelectorAll("input[name='estilos[]']");

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

    // Validar descripción al perder el foco
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

    // Validar tipo de prenda al perder el foco
    if (tipoPrendaSelect) {
        tipoPrendaSelect.addEventListener("blur", function () {
            clearError(tipoPrendaSelect);
            if (tipoPrendaSelect.value === "") {
                showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
            }
        });
    }

    // Validar imagen frontal al cambiar
    if (imgFrontalInput) {
        imgFrontalInput.addEventListener("change", function () {
            clearError(imgFrontalInput);
            if (imgFrontalInput.files.length === 0) {
                showError(imgFrontalInput, "Debes subir una imagen frontal.");
            }
        });
    }

    // Validar etiquetas al cambiar
    if (etiquetasCheckboxes.length > 0) {
        etiquetasCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(etiquetasContainer);
                if (!isAnyChecked(etiquetasCheckboxes)) {
                    showError(etiquetasContainer, "Debes seleccionar al menos una etiqueta.");
                }
            });
        });
    }

    // Validar colores al cambiar
    if (coloresCheckboxes.length > 0) {
        coloresCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(coloresContainer);
                if (!isAnyChecked(coloresCheckboxes)) {
                    showError(coloresContainer, "Debes seleccionar al menos un color.");
                }
            });
        });
    }

    // Validar estilos al cambiar
    if (estilosCheckboxes.length > 0) {
        estilosCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                clearError(estilosContainer);
                if (!isAnyChecked(estilosCheckboxes)) {
                    showError(estilosContainer, "Debes seleccionar al menos un estilo.");
                }
            });
        });
    }

    // Validar al enviar el formulario
    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Validar nombre
        clearError(nombreInput);
        if (nombreInput.value.trim() === "") {
            showError(nombreInput, "El nombre es obligatorio.");
            isValid = false;
        } else if (nombreInput.value.trim().length < 3) {
            showError(nombreInput, "El nombre debe tener al menos 3 caracteres.");
            isValid = false;
        }

        // Validar descripción
        clearError(descripcionInput);
        if (descripcionInput.value.trim() === "") {
            showError(descripcionInput, "La descripción es obligatoria.");
            isValid = false;
        } else if (descripcionInput.value.trim().length < 10) {
            showError(descripcionInput, "La descripción debe tener al menos 10 caracteres.");
            isValid = false;
        }

        // Validar tipo de prenda
        clearError(tipoPrendaSelect);
        if (tipoPrendaSelect.value === "") {
            showError(tipoPrendaSelect, "Debes seleccionar un tipo de prenda.");
            isValid = false;
        }

        // Validar imagen frontal
        clearError(imgFrontalInput);
        if (imgFrontalInput.files.length === 0) {
            showError(imgFrontalInput, "Debes subir una imagen frontal.");
            isValid = false;
        }

        // Validar etiquetas
        clearError(etiquetasContainer);
        if (!isAnyChecked(etiquetasCheckboxes)) {
            showError(etiquetasContainer, "Debes seleccionar al menos una etiqueta.");
            isValid = false;
        }

        // Validar colores
        clearError(coloresContainer);
        if (!isAnyChecked(coloresCheckboxes)) {
            showError(coloresContainer, "Debes seleccionar al menos un color.");
            isValid = false;
        }

        // Validar estilos
        clearError(estilosContainer);
        if (!isAnyChecked(estilosCheckboxes)) {
            showError(estilosContainer, "Debes seleccionar al menos un estilo.");
            isValid = false;
        }

        // Si no es válido, prevenir el envío del formulario
        if (!isValid) {
            event.preventDefault();
            alert("Por favor, completa todos los campos obligatorios.");
        }
    });

    // Función para mostrar mensajes de error debajo del grupo
    function showError(container, message) {
        const error = document.createElement("span");
        error.classList.add("error-message");
        error.style.color = "red";
        error.style.fontSize = "12px";
        error.style.marginTop = "5px";
        error.textContent = message;

        // Insertar el mensaje de error después del contenedor
        container.insertAdjacentElement('afterend', error);
    }

    // Función para limpiar mensajes de error previos
    function clearError(container) {
        const error = container.nextElementSibling;
        if (error && error.classList.contains("error-message")) {
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
