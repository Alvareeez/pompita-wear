document.addEventListener('DOMContentLoaded', () => {
    // Buscamos el botón de solicitud en la página
    const btn   = document.getElementById('solicitud-btn');
    if (!btn) return; // Si no existe, salimos

    // Obtenemos el token CSRF y la URL base
    const token = document.head.querySelector('meta[name="csrf-token"]').content;
    const base  = document.head.querySelector('meta[name="base-url"]').content;
    const isPrivate       = document.head.querySelector('meta[name="is-private"]').content === '1';
    const followersCount = document.getElementById('followers-count');
    const outfitsSection  = document.getElementById('outfits-section');


    // Asociamos el evento click al botón
    btn.addEventListener('click', async (e) => {
        e.preventDefault(); // Evitamos recargar la página

        // Leemos datos del botón
        const userId      = btn.dataset.userId;
        let   status      = btn.dataset.status;       // 'pendiente', 'aceptada' o undefined
        const solicitudId = btn.dataset.solicitudId;  // solo si existe

        // Si hay solicitud (pendiente o aceptada), la borramos (DELETE)
        if (status === 'pendiente' || status === 'aceptada') {
            const res = await fetch(`${base}/solicitudes/${solicitudId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN':     token,
                    'Accept':           'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (res.ok) {
                // Volvemos a “Seguir”
                btn.textContent = 'Seguir';
                btn.className   = 'btn btn-primary';
                // Eliminamos atributos de estado anterior
                delete btn.dataset.status;
                delete btn.dataset.solicitudId;

                // Si antes seguíamos (aceptada), decrementamos contador
                if (status === 'aceptada' && followersCount) {
                    let count = parseInt(followersCount.textContent) || 0;
                    followersCount.textContent = Math.max(count - 1, 0);
                }
                if (isPrivate) {
                    outfitsSection.innerHTML = `
                      <div class="alert alert-warning mt-4">
                        Esta cuenta es privada. Envía una solicitud para ver su contenido.
                      </div>`;
                }
            } else {
                const err = await res.json();
                alert(err.error || 'No se pudo procesar la solicitud');
            }
            return;
        }

        // Si no hay solicitud, la creamos (POST)
        const res = await fetch(`${base}/solicitudes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':     token,
                'Content-Type':     'application/json',
                'Accept':           'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id_receptor: userId })
        });

        const data = await res.json();

        if (res.ok) {
            // Guardamos nuevo estado e ID
            status                  = data.status;  // 'pendiente' o 'aceptada'
            btn.dataset.status      = status;
            btn.dataset.solicitudId = data.solicitud_id;

            // Actualizamos texto y estilo
            if (status === 'pendiente') {
                btn.textContent = 'Pendiente';
                btn.className   = 'btn btn-warning';
            } else {
                btn.textContent = 'Siguiendo';
                btn.className   = 'btn btn-success';
                // Incrementamos seguidores
                if (followersCount) {
                    let count = parseInt(followersCount.textContent) || 0;
                    followersCount.textContent = count + 1;
                }
            }
        } else {
            alert(data.error || 'No se pudo enviar la solicitud');
        }
    });
});
