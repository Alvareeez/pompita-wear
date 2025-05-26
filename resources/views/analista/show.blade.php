{{-- resources/views/analista/show.blade.php --}}
@extends('layouts.header')

@section('title', 'Detalle Analítica de Prenda')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('content')
<div class="container my-5">
  {{-- Botón Volver --}}
  <a href="{{ route('analista.index') }}" class="btn btn-outline-secondary mb-4">
    <i class="fas fa-arrow-left"></i> Volver al Panel de Analista
  </a>

  <div class="row mb-5">
    {{-- Imagen y descripción --}}
    <div class="col-md-4">
      <div class="card">
        <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}"
             class="card-img-top" alt="{{ $prenda->nombre }}">
        <div class="card-body">
          <h4 class="card-title">{{ $prenda->nombre }}</h4>
          @if($prenda->descripcion)
            <p class="card-text">{{ $prenda->descripcion }}</p>
          @endif
        </div>
      </div>
    </div>

    {{-- Métricas y gráfico --}}
    <div class="col-md-8">
      <h3 class="mb-3">Métricas Generales</h3>
      <ul class="list-group mb-4">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Total de vistas
          <span class="badge bg-primary">{{ $totalViews }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Vistas últimos 30 días
          <span class="badge bg-info">{{ $viewsLast30 }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Total de likes
          <span class="badge bg-success">{{ $totalLikes }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Total de comentarios
          <span class="badge bg-warning text-dark">{{ $totalComments }}</span>
        </li>
      </ul>

      {{-- Canvas para Chart.js --}}
      <canvas id="metricsChart" height="200"></canvas>
    </div>
  </div>
</div>

@include('layouts.footer')
<x-cookie-banner />

{{-- Incluir Chart.js desde CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('metricsChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Vistas totales', 'Vistas últimos 30 días', 'Likes', 'Comentarios'],
        datasets: [{
          label: '{{ $prenda->nombre }}',
          data: [
            {{ $totalViews }},
            {{ $viewsLast30 }},
            {{ $totalLikes }},
            {{ $totalComments }}
          ]
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });
  });
</script>
@endsection
