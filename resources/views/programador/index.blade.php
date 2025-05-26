@extends('layouts.header')

@section('title', 'Panel Programador')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/programador.css') }}">
@endsection

@section('content')
<div class="container my-5">
  <h2 class="mb-4">Solicitudes de Plantilla Pendientes</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($solicitudes->isEmpty())
    <p>No hay solicitudes pendientes.</p>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Id</th>
          <th>Empresa</th>
          <th>Slug</th>
          <th>Solicitada en</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach($solicitudes as $s)
          <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->empresa->usuario->nombre }} ({{ $s->empresa->razon_social }})</td>
            <td>{{ $s->slug }}</td>
            <td>{{ $s->solicitada_en->format('d/m/Y H:i') }}</td>
            <td>
              <a href="{{ route('programador.plantillas.show', $s) }}"
                 class="btn btn-sm btn-primary">
                Ver / Procesar
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@include('layouts.footer')
@endsection
