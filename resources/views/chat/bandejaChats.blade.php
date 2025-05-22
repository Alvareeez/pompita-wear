@extends('layouts.header')

@section('title', 'Bandeja de Chats')

@section('css')
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="container mt-4">
  <div class="row chat-wrapper">
    {{-- Sidebar: lista de contactos --}}
    <div class="col-md-4 sidebar">
      <h5>Mis Chats</h5>
      <ul class="list-group">
        @forelse($contacts as $c)
          <li class="list-group-item p-2">
            <a href="{{ route('chat.index', $c->id_usuario) }}"
               class="d-flex align-items-center text-decoration-none">
              <img src="{{ $c->foto_perfil
                           ? asset($c->foto_perfil)
                           : asset('img/default-profile.png') }}"
                   class="rounded-circle me-2"
                   style="width:30px; height:30px; object-fit:cover;">
              <span>{{ $c->nombre }}</span>
            </a>
          </li>
        @empty
          <li class="list-group-item text-center text-muted">
            Sin conversaciones aún.
          </li>
        @endforelse
      </ul>
    </div>

    {{-- Panel de preview (vacío) --}}
    <div class="col-md-8 main-chat d-flex justify-content-center align-items-center">
      <p class="text-muted">Selecciona un chat para comenzar a chatear.</p>
    </div>
  </div>
</div>
<br>
@include('layouts.footer')
@endsection
