@extends('layouts.header')

@section('title', 'Seleccionar Prenda')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
    <style>
      .form-group { margin-bottom: 1rem; }
      /* Oculta completamente las opciones marcadas como hidden */
      select option[hidden] { display: none; }
    </style>
@endsection

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Seleccionar Prenda para Destacar</h1>

    <h2 class="h4">
      Plan: {{ $plan->nombre }} — {{ number_format($plan->precio,2,',','.') }} €
    </h2>
    <p>{{ $plan->descripcion }}</p>

    <form id="checkout-form" action="{{ route('paypal.checkout') }}" method="POST">
      @csrf
      <input type="hidden" name="plan_id" value="{{ $plan->id }}">

      {{-- Campo de búsqueda y botón Filtrar --}}
      <div class="input-group mb-4">
        <input type="text"
               id="prenda-search"
               class="form-control"
               placeholder="Escribe para filtrar…">
        <button class="btn btn-primary" id="btn-filter" type="button">
          Filtrar
        </button>
      </div>

      <div class="form-group">
        <label for="prenda_id">Prenda a destacar:</label>
        <select name="prenda_id"
                id="prenda_id"
                class="form-control"
                required>
          <option value="">— Selecciona una prenda —</option>
          @foreach($prendas as $prenda)
            <option value="{{ $prenda->id_prenda }}"
                    {{ $prenda->destacada ? 'disabled' : '' }}>
              {{ $prenda->nombre }}
              @if($prenda->destacada) — Ya destacada @endif
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit" class="btn btn-success">
        Pagar {{ number_format($plan->precio,2,',','.') }} €
      </button>
    </form>
</div>

@include('layouts.footer')
<x-cookie-banner />
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const inputSearch = document.getElementById('prenda-search');
  const btnFilter   = document.getElementById('btn-filter');
  const select      = document.getElementById('prenda_id');

  function aplicarFiltro() {
    const q = inputSearch.value.trim().toLowerCase();
    Array.from(select.options).forEach(function(opt){
      // placeholder siempre visible
      if (!opt.value) {
        opt.hidden = false;
        return;
      }
      // si está disabled (ya destacada) también debe verse siempre
      if (opt.disabled) {
        opt.hidden = false;
        return;
      }
      const texto = opt.textContent.toLowerCase();
      opt.hidden = q !== '' && !texto.includes(q);
    });
    // si la opción seleccionada queda oculta, la deseleccionamos
    const sel = select.selectedOptions[0];
    if (sel && sel.hidden) {
      select.value = '';
    }
  }

  inputSearch.addEventListener('input', aplicarFiltro);
  btnFilter.addEventListener('click', aplicarFiltro);
});
</script>
@endsection
