document.addEventListener('DOMContentLoaded', function() {
    var meId   = window.Laravel.meId;   // lo asignaremos desde Blade
    var otroId = window.Laravel.otroId;
    var token  = document.querySelector('meta[name="csrf-token"]').content;
    var box    = document.getElementById('messages');
    var input  = document.getElementById('messageInput');
    var btn    = document.getElementById('sendBtn');
  
    // Carga de mensajes
    function loadMessages() {
      fetch('/chat/' + otroId + '/mensajes')
        .then(function(res) { return res.json(); })
        .then(function(datos) {
          box.innerHTML = '';
          datos.forEach(function(m) {
            var div = document.createElement('div');
            div.classList.add('message');
            div.classList.add(m.emisor_id === meId ? 'sent' : 'received');
            div.textContent = m.contenido;
            box.appendChild(div);
          });
          box.scrollTop = box.scrollHeight;
        })
        .catch(function(err) { console.error(err); });
    }
  
    // Envío de mensaje
    btn.addEventListener('click', function() {
      var texto = input.value.trim();
      if (!texto) return;
      fetch('/chat/' + otroId + '/mensajes', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ contenido: texto })
      })
      .then(function(res) { return res.json(); })
      .then(function() {
        input.value = '';
        loadMessages();
      })
      .catch(function(err) { console.error(err); });
    });
  
    // Inicial y periódico
    loadMessages();
    setInterval(loadMessages, 3000);
  });
  