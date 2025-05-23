@extends('layouts.header')

@section('title','Panel de Programador')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('content')
<div class="container my-5">
  <h2 class="section-title text-center mb-4">Solicitudes de Plantillas</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @forelse($pendientes as $plantilla)
    <div class="card mb-4 shadow-sm">
      <div class="card-body d-flex align-items-center">
        <div class="me-4">
          <strong>{{ $plantilla->empresa->nombre }}</strong><br>
          <small class="text-muted">
            Solicitada: {{ $plantilla->created_at->format('d/m/Y H:i') }}
          </small>
        </div>
        <div class="flex-grow-1">
          <p><strong>Nombre plantilla:</strong> {{ $plantilla->nombre }}</p>
          <p>
            <strong>Colores:</strong>
            @foreach($plantilla->colores as $c)
              <span class="badge" style="background:{{ $c }}">{{ $c }}</span>
            @endforeach
          </p>
          @if($plantilla->enlace)
            <p><strong>Enlace:</strong> <a href="{{ $plantilla->enlace }}" target="_blank">{{ $plantilla->enlace }}</a></p>
          @endif
        </div>
        <div class="d-flex flex-column">
          <form action="{{ route('programador.plantillas.aprobar', $plantilla) }}" method="POST" class="mb-2">
            @csrf
            <button class="btn btn-sm btn-success">Aprobar</button>
          </form>
          <form action="{{ route('programador.plantillas.rechazar', $plantilla) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-danger">Rechazar</button>
          </form>
        </div>
      </div>
    </div>
  @empty
    <p class="text-center">No hay solicitudes pendientes.</p>
  @endforelse
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection
