@extends('layouts.header')
@section('title', $plantilla->nombre)

@section('css')
  <style>
    .store-header { background: {{ $plantilla->color_primario }}; color: #fff; text-align: center; padding: 2rem; }
    .product-card img { max-height: 200px; object-fit: cover; }
  </style>
@endsection

@section('content')
  <div class="store-header">
    <h1>{{ $plantilla->nombre }}</h1>
    @if($plantilla->foto)
      <img src="{{ asset($plantilla->foto) }}" class="img-fluid" alt="">
    @endif
  </div>

  <div class="container my-5">
    <h2 style="color: {{ $plantilla->color_secundario }}">Productos Destacados</h2>

    @if($prendas->isEmpty())
      <p>No hay productos aceptados todavía.</p>
    @else
      <div class="row g-4">
        @foreach($prendas as $prenda)
          <div class="col-md-4">
            <div class="card product-card h-100 shadow-sm">
              <img src="{{ asset('img/prendas/'.$prenda->img_frontal) }}"
                   class="card-img-top"
                   alt="{{ $prenda->nombre }}">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $prenda->nombre }}</h5>
                <p class="card-text flex-grow-1">
                  {{ \Illuminate\Support\Str::limit($prenda->descripcion, 80) }}
                </p>
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}"
                   class="btn btn-sm btn-primary mt-auto"
                   style="background-color: {{ $plantilla->color_terciario }};">
                  Ver detalle
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
