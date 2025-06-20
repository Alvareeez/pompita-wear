@extends('layouts.header')

@section('title', 'Panel de Analista')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/stylesAnalista.css') }}">
@endsection

@section('content')
<div class="container my-5 analista-container">
  {{-- Top 5 Prendas --}}
  <h3 class="mb-4">Top 5 Prendas más vistas (últimos 30 días)</h3>
  <div class="row mb-5 justify-content-center top5">
    @foreach($top5 as $prenda)
      <div class="col-md-2 mb-3">
        <div class="card h-100 analista-card">
          <a href="{{ route('analista.prendas.show', $prenda) }}">
            <img src="{{ asset('img/prendas/'.$prenda->img_frontal) }}"
                 class="card-img-top" alt="{{ $prenda->nombre }}">
          </a>
          <div class="card-body p-2 text-center">
            <p class="card-title small">{{ Str::limit($prenda->nombre, 20) }}</p>
            <span class="badge bg-primary">
              {{ $prenda->views_last_30_days }} vistas
            </span>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Listado paginado --}}
  <h3 class="mb-4">Todas las Prendas (por vistas totales)</h3>
  <div class="row">
    @foreach($prendas as $prenda)
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm analista-card">
          <a href="{{ route('analista.prendas.show', $prenda) }}">
            <img src="{{ asset('img/prendas/'.$prenda->img_frontal) }}"
                 class="card-img-top" alt="{{ $prenda->nombre }}">
          </a>
          <div class="card-body p-2">
            <h5 class="card-title small">
              {{ Str::limit($prenda->nombre, 25) }}
            </h5>
            <p class="mb-1">
              <i class="fas fa-eye"></i>
              {{ $prenda->vistas_count }} vistas
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Paginación --}}
  @if($prendas->hasPages())
    <nav aria-label="Paginación de prendas">
        <ul class="pagination justify-content-center my-4" id="pagination-links">
            {{-- Botón Anterior --}}
            <li class="page-item {{ $prendas->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $prendas->previousPageUrl() }}">&laquo;</a>
            </li>

            {{-- Números de página --}}
            @foreach ($prendas->getUrlRange(1, $prendas->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $prendas->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Botón Siguiente --}}
            <li class="page-item {{ !$prendas->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $prendas->nextPageUrl() }}">&raquo;</a>
            </li>
        </ul>
    </nav>
@endif
</div>
@endsection