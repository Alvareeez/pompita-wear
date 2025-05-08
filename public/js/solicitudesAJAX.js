document.addEventListener('DOMContentLoaded', () => {
    // Buscamos el botón de solicitud en la página
    const btn   = document.getElementById('solicitud-btn');
    if (!btn) return; // Si no existe, salimos

    // Obtenemos el token CSRF y la URL base de los metatags del <head>
    const token = document.head.querySelector('meta[name="csrf-token"]').content;
    const base  = document.head.querySelector('meta[name="base-url"]').content;

    // Asociamos el evento click al botón
    btn.addEventListener('click', async (e) => {
        e.preventDefault(); // Evitamos recargar la página

        // Leemos datos del botón: usuario receptor, estado actual y posible ID de solicitud
        const userId      = btn.dataset.userId;
        let   status      = btn.dataset.status;       // 'pendiente', 'aceptada' o undefined
        const solicitudId = btn.dataset.solicitudId;  // sólo existe si status==='pendiente'

        // Si ya hay una solicitud pendiente, la cancelamos (DELETE)
        if (status === 'pendiente') {
            const res = await fetch(`${base}/solicitudes/${solicitudId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN':      token,
                    'Accept':            'application/json',
                    'X-Requested-With':  'XMLHttpRequest'
                }
            });

            // Si el servidor responde OK, restauramos el botón a "Seguir"
            if (res.ok) {
                btn.textContent = 'Seguir';
                btn.className   = 'btn btn-primary';
                delete btn.dataset.status;      // eliminamos atributo de estado
                delete btn.dataset.solicitudId; // eliminamos atributo de ID
            } else {
                // Si hubo error, lo mostramos
                const err = await res.json();
                alert(err.error || 'No se pudo cancelar la solicitud');
            }
            return; // Salimos para no ejecutar la creación
        }

        // Si no hay solicitud pendiente, enviamos una nueva (POST)
        const res = await fetch(`${base}/solicitudes`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':      token,
                'Content-Type':      'application/json',
                'Accept':            'application/json',
                'X-Requested-With':  'XMLHttpRequest'
            },
            body: JSON.stringify({ id_receptor: userId })
        });

        // Leemos la respuesta JSON del servidor
        const data = await res.json();

        if (res.ok) {
            // Actualizamos datos del botón según el nuevo estado
            status = data.status;            // 'pendiente' o 'aceptada'
            btn.dataset.status      = status;
            btn.dataset.solicitudId = data.solicitud_id;

            // Cambiamos texto y estilo según si quedó pendiente o ya está aceptada
            if (status === 'pendiente') {
                btn.textContent = 'Pendiente';
                btn.className   = 'btn btn-warning';
            } else {
                btn.textContent = 'Siguiendo';
                btn.className   = 'btn btn-success';
            }
        } else {
            // En caso de fallo, avisamos al usuario
            alert(data.error || 'No se pudo enviar la solicitud');
        }
    });
});
