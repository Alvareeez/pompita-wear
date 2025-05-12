document.addEventListener('DOMContentLoaded', () => {
    const chatWindow = document.getElementById('chatWindow');
    const prompt     = document.getElementById('prompt');
    const sendBtn    = document.getElementById('sendBtn');
    const token      = document.querySelector('meta[name="csrf-token"]').content;
  
    // Inicio de la conversación con un mensaje system
    let history = [
      { role: 'system', content: 'Eres un asistente que ayuda a buscar ropa.' }
    ];
  
    function renderMessage(msg) {
      const wrapper = document.createElement('div');
      wrapper.className = msg.role === 'user' ? 'user-msg' : 'assistant-msg';
      const span = document.createElement('span');
      span.textContent = msg.content;
      wrapper.appendChild(span);
      chatWindow.appendChild(wrapper);
      chatWindow.scrollTop = chatWindow.scrollHeight;
    }
  
    sendBtn.addEventListener('click', async () => {
      const text = prompt.value.trim();
      if (!text) return alert('Escribe tu petición.');
      // muestras tu propio mensaje
      history.push({ role: 'user', content: text });
      renderMessage({ role: 'user', content: text });
      prompt.value = '';
  
      // pides la respuesta al backend
      const res = await fetch("/ia/msg", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN':  token,
        },
        body: JSON.stringify({ messages: history })
      });
  
      if (!res.ok) {
        return alert('Error de servidor: ' + res.status);
      }
      const data = await res.json();
      const reply = data.reply || 'Sin respuesta.';
      history.push({ role: 'assistant', content: reply });
      renderMessage({ role: 'assistant', content: reply });
    });
  });
  