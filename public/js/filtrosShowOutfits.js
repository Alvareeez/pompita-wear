document.addEventListener('DOMContentLoaded', function() {
    const nombreFilter    = document.getElementById('nombreFilter');
    const creadorFilter   = document.getElementById('creadorFilter');
    const outfitsContainer = document.getElementById('outfitsContainer');
  
    // Realiza fetch de la URL (paginación o filtros) y reengancha paginación
    function fetchAndRender(url) {
      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => {
          if (!res.ok) throw new Error('Network response was not ok');
          return res.text();
        })
        .then(html => {
          outfitsContainer.innerHTML = html;
          attachPaginationLinks();
        })
        .catch(err => {
          console.error(err);
          outfitsContainer.innerHTML = `<div class="alert alert-danger">Error al cargar los datos</div>`;
        });
    }
  
    // Monta el listener en los enlaces de paginación
    function attachPaginationLinks() {
      document.querySelectorAll('#pagination-links a.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          fetchAndRender(this.href);
        });
      });
    }
  
    // Aplica filtros: construye la URL con query params
    function applyFilters() {
      const params = new URLSearchParams({
        nombre:  nombreFilter.value.trim(),
        creador: creadorFilter.value.trim(),
      });
      fetchAndRender(`/outfits?${params.toString()}`);
    }
  
    // Debounce de 500ms en inputs
    let timeout;
    [nombreFilter, creadorFilter].forEach(input => {
      input.addEventListener('keyup', () => {
        clearTimeout(timeout);
        timeout = setTimeout(applyFilters, 500);
      });
    });
  
    // Inicial: engancha paginación si ya la hay
    attachPaginationLinks();
  });
  