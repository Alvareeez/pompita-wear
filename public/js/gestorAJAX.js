// public/js/gestorAJAX.js

document.addEventListener('DOMContentLoaded', function() {
    var tablaContainer = document.getElementById('tabla-container');
    var filtrosForm    = document.getElementById('filtrosForm');
  
    // Recarga la tabla vía fetch + promises
    function loadTable(url) {
      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(response) { return response.text(); })
        .then(function(html) {
          tablaContainer.innerHTML = html;
          attachHandlers();
        })
        .catch(function() {
          Swal.fire('Error', 'No se pudo cargar la tabla.', 'error');
        });
    }
  
    // Manejo de filtros
    filtrosForm.addEventListener('submit', function(e) {
      e.preventDefault();
      var desde = document.getElementById('f_desde').value;
      var hasta = document.getElementById('f_hasta').value;
      var params = [];
      if (desde) params.push('desde=' + encodeURIComponent(desde));
      if (hasta) params.push('hasta=' + encodeURIComponent(hasta));
      var url = '/gestor/destacados' + (params.length ? ('?' + params.join('&')) : '');
      loadTable(url);
    });
  
    // Paginación con delegación
    tablaContainer.addEventListener('click', function(e) {
      var link = e.target.closest('.pagination a');
      if (link) {
        e.preventDefault();
        loadTable(link.href);
      }
    });
  
    // Asigna manejadores a botones de toggle
    function attachHandlers() {
      var buttons = document.querySelectorAll('.btn-toggle');
      Array.prototype.forEach.call(buttons, function(btn) {
        btn.addEventListener('click', function() {
          var tr        = btn.closest('tr');
          var id        = tr.getAttribute('data-id');
          var destacada = btn.getAttribute('data-destacada');
          var fecha     = tr.querySelector('.inp-hasta').value;
  
          Swal.fire({
            title: '¿Confirmas el cambio?',
            text: 'Se actualizará el destacado de esta prenda.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
          }).then(function(result) {
            if (result.isConfirmed) {
              updateHighlight(id, destacada, fecha);
            }
          });
        });
      });
    }
  
    // Llamada POST para actualizar destacado
    function updateHighlight(id, destacada, fecha) {
      var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var body  = 'destacada=' + encodeURIComponent(destacada) +
                  '&destacado_hasta=' + encodeURIComponent(fecha) +
                  '&_token=' + encodeURIComponent(token);
  
      fetch('/gestor/destacados/' + id + '/update', {
        method:  'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body:    body
      })
      .then(function(response) {
        if (response.ok) {
          Swal.fire('¡Listo!', 'Se ha actualizado correctamente.', 'success');
          // recarga la tabla con los mismos parámetros de URL
          loadTable(window.location.href);
        } else {
          throw new Error('Error en la actualización');
        }
      })
      .catch(function() {
        Swal.fire('Error', 'No se pudo actualizar.', 'error');
      });
    }
  
    // Inicial
    attachHandlers();
  });
  