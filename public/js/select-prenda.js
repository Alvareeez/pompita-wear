document.addEventListener('DOMContentLoaded', function () {
    // Filtro de prendas
    const inputSearch = document.getElementById('prenda-search');
    const btnFilter = document.getElementById('btn-filter');
    const select = document.getElementById('prenda_id');
    const btnFiscal = document.getElementById('btn-fiscal');
    const btnPagar = document.getElementById('btn-pagar');

    function aplicarFiltro() {
        const q = inputSearch.value.trim().toLowerCase();
        Array.from(select.options).forEach(function (opt) {
            // placeholder siempre visible
            if (!opt.value) {
                opt.hidden = false;
                return;
            }
            // si está disabled (ya destacada) también debe verse siempre
            if (opt.disabled) {
                opt.hidden = false;
                return;
            }
            const texto = opt.textContent.toLowerCase();
            opt.hidden = q !== '' && !texto.includes(q);
        });
        // si la opción seleccionada queda oculta, la deseleccionamos
        const sel = select.selectedOptions[0];
        if (sel && sel.hidden) {
            select.value = '';
        }
    }

    // Solo añade listeners si existen los elementos
    if (inputSearch && btnFilter && select) {
        inputSearch.addEventListener('input', aplicarFiltro);
        btnFilter.addEventListener('click', aplicarFiltro);
    }

    // SweetAlert para dirección fiscal
    btnFiscal.addEventListener('click', function () {
        const df = window.datosFiscales || {};

        Swal.fire({
            title: 'Dirección fiscal',
            html: `
                <label for="swal-razon" class="swal2-label w-100">Razón social:</label>
                <input id="swal-razon" class="swal2-input" placeholder="Razón social" value="${df.razon_social ?? ''}">
                <div id="error-razon" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-nif" class="swal2-label w-100">NIF/CIF:</label>
                <input id="swal-nif" class="swal2-input" placeholder="NIF/CIF" value="${df.nif ?? ''}">
                <div id="error-nif" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-direccion" class="swal2-label w-100">Dirección:</label>
                <input id="swal-direccion" class="swal2-input" placeholder="Dirección" value="${df.direccion ?? ''}">
                <div id="error-direccion" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-cp" class="swal2-label w-100">Código Postal:</label>
                <input id="swal-cp" type="number" class="swal2-input" placeholder="Código Postal" value="${df.cp ?? ''}">
                <div id="error-cp" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-ciudad" class="swal2-label w-100">Ciudad:</label>
                <input id="swal-ciudad" class="swal2-input" placeholder="Ciudad" value="${df.ciudad ?? ''}">
                <div id="error-ciudad" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-provincia" class="swal2-label w-100">Provincia:</label>
                <input id="swal-provincia" class="swal2-input" placeholder="Provincia" value="${df.provincia ?? ''}">
                <div id="error-provincia" class="text-danger small mt-1" style="display: none;"></div>
                
                <label style="margin-top:20px" for="swal-pais" class="swal2-label w-100">País:</label>
                <input id="swal-pais" class="swal2-input" placeholder="País" value="${df.pais ?? ''}">
                <div id="error-pais" class="text-danger small mt-1" style="display: none;"></div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-dark-popup',
                title: 'swal-dark-title',
                htmlContainer: 'swal-dark-html',
                confirmButton: 'swal-dark-confirm',
                cancelButton: 'swal-dark-cancel',
                input: 'swal-dark-input'
            },
            didOpen: () => {
                // Validaciones en tiempo real
                document.getElementById('swal-razon').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                    validarRazonSocial();
                });

                document.getElementById('swal-nif').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
                    validarNIF();
                });

                document.getElementById('swal-direccion').addEventListener('input', validarDireccion);
                document.getElementById('swal-cp').addEventListener('input', validarCP);

                document.getElementById('swal-ciudad').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                    validarCiudad();
                });

                document.getElementById('swal-provincia').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                    validarProvincia();
                });

                document.getElementById('swal-pais').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                    validarPais();
                });
            },
            preConfirm: () => {
                // Validación final
                const razon = document.getElementById('swal-razon').value.trim();
                const nif = document.getElementById('swal-nif').value.trim();
                const direccion = document.getElementById('swal-direccion').value.trim();
                const cp = document.getElementById('swal-cp').value.trim();
                const ciudad = document.getElementById('swal-ciudad').value.trim();
                const provincia = document.getElementById('swal-provincia').value.trim();
                const pais = document.getElementById('swal-pais').value.trim();

                let isValid = true;

                if (!validarRazonSocial(true)) isValid = false;
                if (!validarNIF(true)) isValid = false;
                if (!validarDireccion(true)) isValid = false;
                if (!validarCP(true)) isValid = false;
                if (!validarCiudad(true)) isValid = false;
                if (!validarProvincia(true)) isValid = false;
                if (!validarPais(true)) isValid = false;

                if (!isValid) {
                    Swal.showValidationMessage('Por favor, corrige los errores en el formulario');
                    return false;
                }

                return {
                    razon,
                    nif,
                    direccion,
                    cp,
                    ciudad,
                    provincia,
                    pais
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(window.routeDatosFiscalesStore, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": window.csrfToken
                    },
                    body: JSON.stringify(result.value)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Guardado!', 'Dirección fiscal guardada correctamente.', 'success')
                                .then(() => {
                                    btnPagar.disabled = false;
                            });
                        } else {
                            Swal.fire('Error', data.message || 'No se pudo guardar.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo guardar.', 'error');
                    });
            }
        });
    });

    // Funciones de validación específicas para cada campo
    function validarRazonSocial(finalValidation = false) {
        const input = document.getElementById('swal-razon');
        const error = document.getElementById('error-razon');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'La razón social es obligatoria';
                error.style.display = 'block';
            }
            return false;
        }

        if (value.length < 3) {
            error.textContent = 'La razón social debe tener al menos 3 caracteres';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }

    function validarNIF(finalValidation = false) {
        const input = document.getElementById('swal-nif');
        const error = document.getElementById('error-nif');
        const value = input.value.trim().toUpperCase();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'El NIF/CIF es obligatorio';
                error.style.display = 'block';
            }
            return false;
        }

        // Expresión regular para validar NIF (personas físicas)
        const nifRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;

        // Expresión regular para validar CIF (personas jurídicas)
        const cifRegex = /^[ABCDEFGHJKLMNPQRSUVW][0-9]{7}[0-9A-J]$/i;

        // Expresión regular para validar NIE (extranjeros)
        const nieRegex = /^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;

        if (!nifRegex.test(value) && !cifRegex.test(value) && !nieRegex.test(value)) {
            error.textContent = 'El NIF/CIF no tiene un formato válido';
            error.style.display = 'block';
            return false;
        }

        // Validación de la letra del NIF
        if (nifRegex.test(value)) {
            const numero = value.substr(0, 8);
            const letra = value.substr(8, 1).toUpperCase();
            const letrasValidas = 'TRWAGMYFPDXBNJZSQVHLCKE';
            const letraCorrecta = letrasValidas.charAt(parseInt(numero) % 23);

            if (letra !== letraCorrecta) {
                error.textContent = 'La letra del NIF no es correcta';
                error.style.display = 'block';
                return false;
            }
        }

        error.style.display = 'none';
        return true;
    }

    function validarDireccion(finalValidation = false) {
        const input = document.getElementById('swal-direccion');
        const error = document.getElementById('error-direccion');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'La dirección es obligatoria';
                error.style.display = 'block';
            }
            return false;
        }

        if (value.length < 5) {
            error.textContent = 'La dirección debe tener al menos 5 caracteres';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }

    function validarCP(finalValidation = false) {
        const input = document.getElementById('swal-cp');
        const error = document.getElementById('error-cp');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'El código postal es obligatorio';
                error.style.display = 'block';
            }
            return false;
        }

        if (!/^\d{5}$/.test(value)) {
            error.textContent = 'El código postal debe tener 5 dígitos';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }

    function validarCiudad(finalValidation = false) {
        const input = document.getElementById('swal-ciudad');
        const error = document.getElementById('error-ciudad');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'La ciudad es obligatoria';
                error.style.display = 'block';
            }
            return false;
        }

        if (value.length < 3) {
            error.textContent = 'La ciudad debe tener al menos 3 caracteres';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }

    function validarProvincia(finalValidation = false) {
        const input = document.getElementById('swal-provincia');
        const error = document.getElementById('error-provincia');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'La provincia es obligatoria';
                error.style.display = 'block';
            }
            return false;
        }

        if (value.length < 3) {
            error.textContent = 'La provincia debe tener al menos 3 caracteres';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }

    function validarPais(finalValidation = false) {
        const input = document.getElementById('swal-pais');
        const error = document.getElementById('error-pais');
        const value = input.value.trim();

        if (!value) {
            if (finalValidation) {
                error.textContent = 'El país es obligatorio';
                error.style.display = 'block';
            }
            return false;
        }

        if (value.length < 3) {
            error.textContent = 'El país debe tener al menos 3 caracteres';
            error.style.display = 'block';
            return false;
        }

        error.style.display = 'none';
        return true;
    }
});