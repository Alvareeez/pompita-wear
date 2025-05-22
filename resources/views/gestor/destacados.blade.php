@extends('layouts.header')

@section('title', 'CRUD Destacados')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/gestorAJAX.js') }}" defer></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
  <div class="container my-5">
    <div class="d-flex justify-content-between mb-4">
      <h2 class="section-title">CRUD de Prendas Destacadas</h2>
      <a href="{{ route('gestor.index') }}" class="btn btn-outline-secondary">
        ← Volver a Solicitudes
      </a>
    </div>

    {{-- Filtros --}}
    <form id="filtrosForm" class="row g-2 mb-4">
      <div class="col-auto">
        <input type="date" name="desde" id="f_desde" class="form-control" placeholder="Desde">
      </div>
      <div class="col-auto">
        <input type="date" name="hasta" id="f_hasta" class="form-control" placeholder="Hasta">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </div>
    </form>

    <div id="tabla-container">
      @include('gestor.partials.destacados-table', ['prendas' => $prendas])
    </div>
  </div>
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection
