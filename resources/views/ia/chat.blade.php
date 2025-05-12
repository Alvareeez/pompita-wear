{{-- resources/views/ia/chat.blade.php --}}
@extends('layouts.header')

@section('title','Chat IA')

@section('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    /* Estilos de ejemplo para el chat */
    #chatWindow {
      height: 400px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 1rem;
      margin-bottom: 1rem;
      background: #f9f9f9;
    }
    .user-msg { text-align: right; margin: .5rem 0; }
    .assistant-msg { text-align: left; margin: .5rem 0; }
    .user-msg span,
    .assistant-msg span {
      display: inline-block;
      padding: .5rem 1rem;
      border-radius: .5rem;
    }
    .user-msg span { background: #007bff; color: #fff; }
    .assistant-msg span { background: #e2e3e5; color: #000; }
  </style>
@endsection

@section('content')
<div class="container py-5">
  <h2>🛍️ Asistente de ropa</h2>

  <div id="chatWindow"></div>

  <div class="mb-3">
    <textarea id="prompt" class="form-control" rows="2"
      placeholder="P. ej. Quiero algo rojo y casual…"></textarea>
  </div>
  <button id="sendBtn" class="btn btn-primary mb-4">Enviar</button>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const chatWindow = document.getElementById('chatWindow');
  const promptInput = document.getElementById('prompt');
  const sendBtn     = document.getElementById('sendBtn');
  const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

  // Historial inicial con mensaje system
  let history = [
    { role: 'system', content: 'Eres un asistente que ayuda a buscar ropa.' }
  ];

  function renderMessage(role, content) {
    const wrapper = document.createElement('div');
    wrapper.className = (role === 'user') ? 'user-msg' : 'assistant-msg';
    const span = document.createElement('span');
    span.textContent = content;
    wrapper.appendChild(span);
    chatWindow.appendChild(wrapper);
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }

  sendBtn.addEventListener('click', async () => {
    const text = promptInput.value.trim();
    if (!text) return alert('Escribe tu petición.');

    // Renderiza el mensaje del usuario
    history.push({ role: 'user', content: text });
    renderMessage('user', text);
    promptInput.value = '';

    try {
      const res = await fetch("{{ route('ia.message') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN':  csrfToken,
        },
        body: JSON.stringify({ history }),
      });

      if (!res.ok) throw new Error(`Server status ${res.status}`);

      const data = await res.json();
      const reply = data.reply || 'Sin respuesta.';
      history.push({ role: 'assistant', content: reply });
      renderMessage('assistant', reply);

    } catch (e) {
      console.error(e);
      renderMessage('assistant', 'Error de conexión al servidor.');
    }
  });
});
</script>
@endsection
