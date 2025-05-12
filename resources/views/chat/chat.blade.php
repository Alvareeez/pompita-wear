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
    // Pasamos al chat.js los IDs de usuario para saber quién envía y quién recibe
    window.Laravel = {
      meId: {{ auth()->id() }},
      otroId: {{ $otro->id_usuario }}
    };
  </script>
  <script src="{{ asset('js/chat.js') }}"></script>
@endsection

@section('content')
<div class="container mt-4">
  {{-- Header con avatar y nombre del otro usuario --}}
  <div class="d-flex align-items-center mb-3">
    <img src="{{ asset($otro->foto_perfil ?: 'img/default-profile.png') }}"
         alt="Avatar {{ $otro->nombre }}"
         class="rounded-circle"
         style="width:40px; height:40px; object-fit:cover; margin-right:0.75rem;">
    <h4 class="m-0">{{ $otro->nombre }}</h4>
  </div>

  {{-- Ventana de chat --}}
  <div id="messages" class="chat-window mb-3">
    {{-- Los mensajes se cargarán aquí dinámicamente --}}
  </div>

  {{-- Campo de texto y botón --}}
  <div class="input-group">
    <input id="messageInput"
           type="text"
           class="form-control"
           placeholder="Escribe un mensaje...">
    <button id="sendBtn" class="btn btn-primary">Enviar</button>
  </div>
</div>
@endsection
