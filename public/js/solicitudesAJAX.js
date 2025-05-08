document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('solicitud-btn');
    if (!btn) return;
  
    btn.addEventListener('click', async function(e) {
      e.preventDefault();
  
      const userId = this.dataset.userId;
      let status  = this.dataset.status;        // 'pendiente', 'aceptada' o undefined
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
      // Si ya está pendiente, cancelamos
      if (status === 'pendiente') {
        const solicitudId = this.dataset.solicitudId;
        const res = await fetch(`/solicitudes/${solicitudId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': token,
            'Accept':       'application/json'
          }
        });
        const data = await res.json();
        if (res.ok) {
          // Reset del botón
          this.dataset.status = '';
          this.removeAttribute('data-solicitud-id');
          this.textContent = 'Seguir';
          this.classList.remove('btn-warning', 'btn-outline-danger');
          this.classList.add('btn-primary');
        } else {
          alert(data.error || 'No se pudo cancelar la solicitud');
        }
        return;
      }
  
      // Si no hay pendiente, enviamos nueva solicitud
      const res = await fetch('/solicitudes', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN':  token,
          'Content-Type':  'application/json',
          'Accept':        'application/json'
        },
        body: JSON.stringify({ id_receptor: userId })
      });
      const data = await res.json();
      if (res.ok) {
        status = data.status;              // 'pendiente' o 'aceptada'
        this.dataset.status = status;
        this.dataset.solicitudId = data.solicitud_id;
  
        if (status === 'pendiente') {
          this.textContent = 'Pendiente';
          this.classList.remove('btn-primary');
          this.classList.add('btn-warning');
        } else {
          this.textContent = 'Siguiendo';
          this.classList.remove('btn-primary');
          this.classList.add('btn-success');
        }
      } else {
        alert(data.error || 'No se pudo enviar la solicitud');
      }
    });
  });
  