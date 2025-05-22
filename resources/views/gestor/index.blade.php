{{-- resources/views/gestor/index.blade.php --}}
@extends('layouts.header')

@section('title', 'Panel de Gestión')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('scripts')
  <script src="{{ asset('js/inicio.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid px-0 mt-4">
  <div class="container my-5">
    <h2 class="section-title text-center mb-4">Gestión de Solicitudes</h2>

    {{-- Botón para CRUD de destacados --}}
    <div class="d-flex justify-content-end mb-4">
      <a href="{{ route('gestor.destacados') }}" class="btn btn-outline-secondary">
        Administrar Destacados
      </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="alert alert-success text-center my-3">
        {{ session('success') }}
      </div>
    @endif

    {{-- Nav tabs --}}
    <ul class="nav nav-tabs justify-content-center mb-4" id="gestorTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active"
                id="pendientes-tab"
                data-bs-toggle="tab"
                data-bs-target="#pendientes"
                type="button"
                role="tab">
          Pendientes ({{ $pendientes->count() }})
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link"
                id="aprobadas-tab"
                data-bs-toggle="tab"
                data-bs-target="#aprobadas"
                type="button"
                role="tab">
          Aprobadas ({{ $aceptadas->count() }})
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link"
                id="rechazadas-tab"
                data-bs-toggle="tab"
                data-bs-target="#rechazadas"
                type="button"
                role="tab">
          Rechazadas ({{ $rechazadas->count() }})
        </button>
      </li>
    </ul>

    <div class="tab-content" id="gestorTabsContent">
      {{-- Pendientes --}}
      <div class="tab-pane fade show active" id="pendientes" role="tabpanel">
        <div class="row">
          @forelse($pendientes as $sol)
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $sol->prenda->nombre }}</h5>
                  <p><strong>Empresa:</strong> {{ $sol->empresa->nombre }}</p>
                  <p><strong>Plan:</strong> {{ $sol->plan->nombre }}</p>
                  <img src="{{ asset('img/prendas/' . $sol->prenda->img_frontal) }}"
                       alt="{{ $sol->prenda->nombre }}"
                       class="img-fluid mb-3 flex-grow-1">
                  <div class="d-flex">
                    <form action="{{ route('gestor.approve', $sol) }}" method="POST" class="me-2">
                      @csrf
                      <button class="btn btn-sm btn-success w-100">Aprobar</button>
                    </form>
                    <form action="{{ route('gestor.reject', $sol) }}" method="POST">
                      @csrf
                      <button class="btn btn-sm btn-danger w-100">Rechazar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <p class="text-center">No hay solicitudes pendientes.</p>
          @endforelse
        </div>
      </div>

      {{-- Aprobadas --}}
      <div class="tab-pane fade" id="aprobadas" role="tabpanel">
        <div class="row">
          @forelse($aceptadas as $sol)
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $sol->prenda->nombre }}</h5>
                  <p><strong>Empresa:</strong> {{ $sol->empresa->nombre }}</p>
                  <p><strong>Plan:</strong> {{ $sol->plan->nombre }}</p>
                  <img src="{{ asset('img/prendas/' . $sol->prenda->img_frontal) }}"
                       alt="{{ $sol->prenda->nombre }}"
                       class="img-fluid mb-3 flex-grow-1">
                  @if(! $sol->prenda->destacada)
                    <form action="{{ route('gestor.highlight', $sol) }}" method="POST">
                      @csrf
                      <button class="btn btn-primary w-100 mt-auto">Destacar Prenda</button>
                    </form>
                  @else
                    <button class="btn btn-success w-100 mt-auto" disabled>Ya Destacada</button>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <p class="text-center">No hay solicitudes aprobadas.</p>
          @endforelse
        </div>
      </div>

      {{-- Rechazadas --}}
      <div class="tab-pane fade" id="rechazadas" role="tabpanel">
        <div class="row">
          @forelse($rechazadas as $sol)
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $sol->prenda->nombre }}</h5>
                  <p><strong>Empresa:</strong> {{ $sol->empresa->nombre }}</p>
                  <p><strong>Plan:</strong> {{ $sol->plan->nombre }}</p>
                  <img src="{{ asset('img/prendas/' . $sol->prenda->img_frontal) }}"
                       alt="{{ $sol->prenda->nombre }}"
                       class="img-fluid mb-3 flex-grow-1">
                  <span class="badge bg-danger mt-auto">Rechazada</span>
                </div>
              </div>
            </div>
          @empty
            <p class="text-center">No hay solicitudes rechazadas.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection
