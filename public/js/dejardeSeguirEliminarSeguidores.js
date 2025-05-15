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
  
    // Eliminar seguidor
    document.querySelectorAll('.remove-follower-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const li = btn.closest('li');
        const id = li.dataset.id;
  
        // Llamada AJAX sin confirm()
        ajaxDelete(`/perfil/follower/${id}`, () => {
          li.remove();
          const cnt = document.getElementById('count-followers');
          cnt.textContent = Math.max(parseInt(cnt.textContent) - 1, 0);
        });
      });
    });
  
    // Dejar de seguir
    document.querySelectorAll('.unfollow-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const li = btn.closest('li');
        const id = li.dataset.id;
  
        // Llamada AJAX sin confirm()
        ajaxDelete(`/perfil/unfollow/${id}`, () => {
          li.remove();
          const cnt = document.getElementById('count-following');
          cnt.textContent = Math.max(parseInt(cnt.textContent) - 1, 0);
        });
      });
    });
  });
  