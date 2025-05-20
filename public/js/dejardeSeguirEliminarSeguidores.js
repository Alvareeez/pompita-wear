document.addEventListener('DOMContentLoaded', () => {
  const token = document.querySelector('meta[name="csrf-token"]').content;

  function ajaxDelete(url, onSuccess) {
    fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN':     token,
        'Accept':           'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => {
      if (!res.ok) throw new Error('Error en la petición');
      return res.json();
    })
    .then(onSuccess)
    .catch(err => console.error(err));
  }

  // —— Eliminar seguidor ——
  document.querySelectorAll('.remove-follower-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const container = btn.closest('[data-id]');
      if (!container) {
        console.error('No se encontró contenedor con data-id');
        return;
      }
      const id = container.dataset.id;

      ajaxDelete(`/perfil/follower/${id}`, () => {
        container.remove();
        // el contador se actualizará al cerrar el modal
      });
    });
  });

  // —— Dejar de seguir ——
  document.querySelectorAll('.unfollow-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const container = btn.closest('[data-id]');
      if (!container) {
        console.error('No se encontró contenedor con data-id');
        return;
      }
      const id = container.dataset.id;

      ajaxDelete(`/perfil/unfollow/${id}`, () => {
        container.remove();
        // el contador se actualizará al cerrar el modal
      });
    });
  });

  // —— Actualizar contadores al cerrar los modales —— 
  const followersModal = document.getElementById('followersModal');
  if (followersModal) {
    followersModal.addEventListener('hidden.bs.modal', () => {
      const remaining = document.querySelectorAll('#followersModal [data-id]').length;
      document.getElementById('count-followers').textContent = remaining;
    });
  }

  const followingModal = document.getElementById('followingModal');
  if (followingModal) {
    followingModal.addEventListener('hidden.bs.modal', () => {
      const remaining = document.querySelectorAll('#followingModal [data-id]').length;
      document.getElementById('count-following').textContent = remaining;
    });
  }
});
