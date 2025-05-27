@extends('layouts.header')
@section('title', $plantilla->nombre)

@section('css')
<style>
  /* === Reset y base === */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Ubuntu', sans-serif;
    line-height: 1.6;
    background-color: #f4f8fb;
    color: #333;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  /* === Header de la marca === */
  .store-header {
    background-color: {{ $plantilla->color_primario }};
    color: #fff;
    text-align: center;
    padding: 4rem 2rem 3rem;
  }

  .store-header h1 {
    font-size: 2.8rem;
    font-weight: 500;
    letter-spacing: 1px;
    margin-bottom: 1rem;
  }

  .store-header img {
    max-width: 200px;
    border-radius: 8px; /* Bordes suaves, pero NO circular */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 1rem;
  }
.store-header img:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }
  /* === Contenedor principal === */
  .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  /* === Título de productos === */
  .section-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 500;
    color: {{ $plantilla->color_secundario }};
    margin-bottom: 2.5rem;
    position: relative;
    padding-bottom: 0.5rem;
  }

  .section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background-color: {{ $plantilla->color_secundario }};
    margin: 0.5rem auto 0;
  }

  /* === Tarjetas de producto === */
  .product-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    background-color: #ffffff;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .product-card img {
    object-fit: cover;
    height: 240px;
    width: 100%;
  }

  .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.75rem;
  }

  .card-text {
    font-size: 0.95rem;
    color: #666;
    flex-grow: 1;
  }

  .btn-primary {
    align-self: flex-start;
    background-color: {{ $plantilla->color_terciario }} !important;
    border: none;
    border-radius: 5px;
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    font-weight: 500;
    transition: background-color 0.2s ease;
  }
 main {
    padding: 0px;
}
  .btn-primary:hover {
    opacity: 0.9;
  }

  /* === Footer opcional === */
  .footer {
    background-color: {{ $plantilla->color_primario }};
    color: white;
    padding: 2rem 1rem;
    text-align: center;
    font-size: 0.9rem;
    margin-top: 3rem;
  }

  @media (max-width: 768px) {
    .store-header h1 {
      font-size: 2rem;
    }

    .section-title {
      font-size: 1.5rem;
    }

    .product-card img {
      height: 200px;
    }
  }
</style>
@endsection

@section('content')
  <!-- Encabezado -->
  <header class="store-header">
    @if($plantilla->foto)
      <img src="{{ asset($plantilla->foto) }}" alt="Logo de {{ $plantilla->nombre }}">
    @endif
  </header>

  <!-- Contenido principal -->
  <main class="container">
    <h2 class="section-title">Nuestros Productos</h2>

    @if($prendas->isEmpty())
      <p style="text-align:center; font-size:1.1rem;">No hay productos disponibles en este momento.</p>
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
                  {{ \Illuminate\Support\Str::limit($prenda->descripcion, 100) }}
                </p>
                <a href="{{ route('prendas.show', $prenda->id_prenda) }}"
                   class="btn btn-sm btn-primary mt-auto">
                  Ver detalle
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </main>

  <!-- Footer opcional -->
  <footer class="footer">
    &copy; {{ date('Y') }} {{ $plantilla->nombre }} - Todos los derechos reservados
  </footer>
@endsection