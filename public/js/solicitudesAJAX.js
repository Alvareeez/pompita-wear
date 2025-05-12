document.addEventListener('DOMContentLoaded', () => {
    // Referencias al botón de seguir/pendiente y al contenedor donde irá el botón "Chatear"
    const btn           = document.getElementById('solicitud-btn');
    const chatContainer = document.getElementById('chat-btn-container');
    if (!btn) return; // Si no existe el botón, salimos
  
    // Leemos los tokens y URLs necesarios de las meta tags
    const token         = document.head.querySelector('meta[name="csrf-token"]').content;
    const base          = document.head.querySelector('meta[name="base-url"]').content;
    const mutualUrlTmpl = document.head.querySelector('meta[name="mutual-url"]').content;
    const chatUrlTmpl   = document.head.querySelector('meta[name="chat-url-tmpl"]').content;
  
    // Identificadores del otro usuario y estado actual de la solicitud
    const userId        = btn.dataset.userId;
    let   status        = btn.dataset.status;      // puede ser 'pendiente', 'aceptada' o undefined
    let   solicitudId   = btn.dataset.solicitudId; // el ID de la solicitud, si ya existe
  
    /**
     * Consulta al servidor si ambos usuarios se siguen mutuamente.
     * Si la respuesta es positiva, crea y muestra el botón "Chatear".
     */
    function updateChatButton() {
      const url = mutualUrlTmpl.replace('{other}', userId);
      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
          // Limpiamos cualquier botón previo
          chatContainer.innerHTML = '';
          // Si mutual = true, inyectamos el enlace al chat
          if (data.mutual) {
            const a = document.createElement('a');
            a.href        = chatUrlTmpl.replace('{other}', userId);
            a.className   = 'btn btn-outline-primary';
            a.textContent = 'Chatear';
            chatContainer.appendChild(a);
          }
        })
        .catch(err => console.error('Error comprobando mutual:', err));
    }
  
    // Llamamos al cargar la página para mostrar el botón si corresponde
    updateChatButton();
  
    /**
     * Envía la petición POST o DELETE según el método indicado.
     * Devuelve una promesa que resuelve { ok, data }.
     */
    function toggleSolicitud(method) {
      const url = method === 'POST'
        ? `${base}/solicitudes`
        : `${base}/solicitudes/${solicitudId}`;
      const opts = {
        method,
        headers: {
          'X-CSRF-TOKEN':     token,
          'Accept':           'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      };
      // Si es creación, añadimos el cuerpo JSON
      if (method === 'POST') {
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify({ id_receptor: userId });
      }
      return fetch(url, opts)
        .then(res => res.json().then(data => ({ ok: res.ok, data })));
    }
  
    // Al hacer clic en el botón de seguir/pendiente...
    btn.addEventListener('click', e => {
      e.preventDefault(); // evitamos recarga
  
      const originalStatus = status; // guardamos el estado antes de cambiar
  
      if (status === 'pendiente' || status === 'aceptada') {
        // Si ya hay solicitud, la eliminamos (DELETE)
        toggleSolicitud('DELETE')
          .then(({ ok, data }) => {
            if (!ok) {
              alert(data.error || 'Error al eliminar solicitud');
              return;
            }
            // Volvemos al estado inicial "Seguir"
            btn.textContent = 'Seguir';
            btn.className   = 'btn btn-primary';
            delete btn.dataset.status;
            delete btn.dataset.solicitudId;
            status = undefined;
  
            // Si antes estábamos siguiendo (aceptada), restamos un seguidor
            if (originalStatus === 'aceptada') {
              const fc = document.getElementById('followers-count');
              if (fc) {
                const count = parseInt(fc.textContent) || 1;
                fc.textContent = Math.max(count - 1, 0);
              }
            }
  
            // Y actualizamos el botón de chat
            updateChatButton();
          })
          .catch(err => console.error('Error borrando solicitud:', err));
      } else {
        // Si no hay solicitud, la creamos (POST)
        toggleSolicitud('POST')
          .then(({ ok, data }) => {
            if (!ok) {
              alert(data.error || 'Error al enviar solicitud');
              return;
            }
            // Actualizamos estado e ID
            status        = data.status;
            solicitudId   = data.solicitud_id;
            btn.dataset.status      = status;
            btn.dataset.solicitudId = solicitudId;
  
            // Cambiamos texto y estilo según pendiente o ya aceptada
            if (status === 'pendiente') {
              btn.textContent = 'Pendiente';
              btn.className   = 'btn btn-warning';
            } else {
              btn.textContent = 'Siguiendo';
              btn.className   = 'btn btn-success';
  
              // Incrementamos el contador de seguidores
              const fc = document.getElementById('followers-count');
              if (fc) {
                const count = parseInt(fc.textContent) || 0;
                fc.textContent = count + 1;
              }
            }
  
            // Y volvemos a comprobar el chat
            updateChatButton();
          })
          .catch(err => console.error('Error creando solicitud:', err));
      }
    });
  });
  