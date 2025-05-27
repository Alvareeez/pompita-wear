document.addEventListener('DOMContentLoaded', function () {
    console.log('createPlantilla.js iniciado');
    const form             = document.getElementById('plantillaForm');
    if (!form) return;

    const slug             = document.getElementById('slug');
    const nombre           = document.getElementById('nombre');
    const foto             = document.getElementById('foto');
    const enlace           = document.getElementById('enlace');
    const colorPrimario    = document.getElementById('color_primario');
    const colorSecundario  = document.getElementById('color_secundario');
    const colorTerciario   = document.getElementById('color_terciario');
    const csrfToken        = document.querySelector('meta[name="csrf-token"]').content;

    function showError(input, msg) {
        clearError(input);
        input.classList.add('is-invalid');
        const fb = document.createElement('div');
        fb.className = 'invalid-feedback d-block';
        fb.textContent = msg;
        input.parentNode.appendChild(fb);
    }
    function clearError(input) {
        input.classList.remove('is-invalid');
        const fb = input.parentNode.querySelector('.invalid-feedback');
        if (fb) fb.remove();
    }

    function validateSlugFormat() {
        clearError(slug);
        const v = slug.value.trim();
        if (!v) { showError(slug,'Slug obligatorio.'); return false; }
        if (!/^[a-zA-Z0-9\-]+$/.test(v)) {
            showError(slug,'Solo letras, números y guiones.'); return false;
        }
        return true;
    }
    async function checkSlugUnique() {
        if (!validateSlugFormat()) return false;
        const res = await fetch(window.checkSlugUrl, {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':csrfToken
            },
            body: JSON.stringify({ slug: slug.value.trim() })
        });
        const { exists } = await res.json();
        if (exists) { showError(slug,'Slug ya registrado.'); return false; }
        return true;
    }

    function validateNombreFormat() {
        clearError(nombre);
        const v = nombre.value.trim();
        if (!v) { showError(nombre,'Nombre obligatorio.'); return false; }
        if (v.length<3) { showError(nombre,'Mínimo 3 caracteres.'); return false; }
        return true;
    }
    async function checkNombreUnique() {
        if (!validateNombreFormat()) return false;
        const res = await fetch(window.checkNombreUrl, {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':csrfToken
            },
            body: JSON.stringify({ nombre: nombre.value.trim() })
        });
        const { exists } = await res.json();
        if (exists) { showError(nombre,'Nombre ya registrado.'); return false; }
        return true;
    }

    function validateFoto() {
        clearError(foto);
        if (foto.value) {
            const ok = ['image/jpeg','image/png','image/webp']
                .includes(foto.files[0].type);
            if (!ok) { showError(foto,'Solo JPG, PNG, WEBP.'); return false; }
        }
        return true;
    }
    function validateEnlace() {
        clearError(enlace);
        const v = enlace.value.trim();
        if (v && !/^https?:\/\/.+\..+/.test(v)) {
            showError(enlace,'URL inválida.'); return false;
        }
        return true;
    }
    function validateColor(input) {
        clearError(input);
        if (!input.value) { showError(input,'Color obligatorio.'); return false; }
        return true;
    }

    // onblur / onchange
    slug.addEventListener('blur',   () => checkSlugUnique());
    nombre.addEventListener('blur', () => checkNombreUnique());
    foto.addEventListener('change', validateFoto);
    enlace.addEventListener('blur', validateEnlace);
    colorPrimario.addEventListener('change', () => validateColor(colorPrimario));
    colorSecundario.addEventListener('change', () => validateColor(colorSecundario));
    colorTerciario.addEventListener('change', () => validateColor(colorTerciario));

    // submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        let ok = true;
        if (!await checkSlugUnique())        ok = false;
        if (!await checkNombreUnique())      ok = false;
        if (!validateFoto())                 ok = false;
        if (!validateEnlace())               ok = false;
        if (!validateColor(colorPrimario))   ok = false;
        if (!validateColor(colorSecundario)) ok = false;
        if (!validateColor(colorTerciario))  ok = false;

        if (!ok) {
            Swal.fire({
                icon: 'error',
                title: 'Corrige los errores',
                text: 'Revisa los campos resaltados.',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        form.submit();
    });
});
