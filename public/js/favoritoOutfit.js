document.addEventListener('DOMContentLoaded', () => {
    const favBtn = document.getElementById('favorite-button');
    if (!favBtn) return;
  
    const outfitId = favBtn.dataset.outfitId;
    const token    = document.querySelector('meta[name="csrf-token"]').content;
    const countEl  = document.getElementById('favorites-count');
  
    favBtn.addEventListener('click', e => {
      e.preventDefault();
      fetch(`/outfits/${outfitId}/favorite`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN':     token,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept':           'application/json'
        }
      })
      .then(res => res.json())
      .then(json => {
        if (json.error) {
          return alert(json.error);
        }
        // Alternar clase 'favorited'
        favBtn.classList.toggle('favorited', json.favorited);
        // Actualizar contador
        countEl.textContent = json.favorites_count;
        // Actualizar texto del botón
        favBtn.innerHTML = (json.favorited ? '⭐ En favoritos' : 'Añadir a favoritos') +
          ' (<span id="favorites-count">' + json.favorites_count + '</span>)';
      })
      .catch(err => console.error('Error al alternar favorito:', err));
    });
});
