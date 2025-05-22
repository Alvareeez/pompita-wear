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
    // Datos que necesita chat.js
    window.Laravel = {
      meId:    {{ auth()->id() }},
      otroId:  {{ $otro->id_usuario }},
      convId:  {{ $conv->id }}
    };
  </script>
  <script src="{{ asset('js/chat.js') }}"></script>
@endsection

@section('content')
<div class="container mt-4">
  <div class="row">
    {{-- Bandeja de chats (izquierda) --}}
    <div class="col-md-4">
      <h5>Mis Chats</h5>
      <ul class="list-group">
        @foreach($contacts as $c)
          <li class="list-group-item p-2 {{ $c->id_usuario === $otro->id_usuario ? 'active' : '' }}">
            <a href="{{ route('chat.index', $c->id_usuario) }}"
               class="d-flex align-items-center text-decoration-none {{ $c->id_usuario === $otro->id_usuario ? 'text-white' : '' }}">
              <img src="{{ $c->foto_perfil
                           ? asset($c->foto_perfil)
                           : asset('img/default-profile.png') }}"
                   class="rounded-circle me-2"
                   style="width:30px; height:30px; object-fit:cover;">
              <span>{{ $c->nombre }}</span>
            </a>
          </li>
        @endforeach
      </ul>
    </div>

    {{-- Panel de chat (derecha) --}}
    <div class="col-md-8">
      {{-- Header con avatar y nombre --}}
      <div class="d-flex align-items-center mb-3">
        <img src="{{ $otro->foto_perfil
                     ? asset($otro->foto_perfil)
                     : asset('img/default-profile.png') }}"
             alt="Avatar {{ $otro->nombre }}"
             class="rounded-circle me-2"
             style="width:40px; height:40px; object-fit:cover;">
        <h4 class="m-0">{{ $otro->nombre }}</h4>
      </div>

      {{-- Ventana de chat --}}
      <div id="messages" class="chat-window mb-3">
        {{-- Se llenará por chat.js --}}
      </div>

      {{-- Input y botón --}}
      <div class="input-group">
        <input id="messageInput"
               type="text"
               class="form-control"
               placeholder="Escribe un mensaje...">
        <button id="sendBtn" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>
<br>
@include('layouts.footer')
@endsection
