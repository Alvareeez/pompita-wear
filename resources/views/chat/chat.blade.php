@extends('layouts.header')

@section('title', 'Chat con ' . $otro->nombre)

@section('css')
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('scripts')
  @parent
  <!-- CSRF Token para las peticiones fetch -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    // Aquí le pasamos a nuestro chat.js los IDs de usuario
    // para que sepa quién es el emisor (meId) y con quién chateamos (otroId), esto nos ayuda dsps para vali
    window.Laravel = {
      meId: {{ auth()->id() }},
      otroId: {{ $otro->id_usuario }}
    };
  </script>
  <script src="{{ asset('js/chat.js') }}"></script>
@endsection


@section('content')
<div class="container mt-4">
  <h3>Chat con {{ $otro->nombre }}</h3>

  <div id="messages" class="chat-window mb-3">
    <!-- Aquí se insertan los mensajes dinámicamente -->
  </div>

  <div class="input-group">
    <input id="messageInput"
           type="text"
           class="form-control"
           placeholder="Escribe un mensaje...">
    <button id="sendBtn" class="btn btn-primary">Enviar</button>
  </div>
</div>
@endsection
