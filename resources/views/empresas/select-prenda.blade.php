@extends('layouts.header')

@section('title', 'Seleccionar Prenda')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styleInicio.css') }}">
@endsection

@section('content')
<div class="container my-5">
    <h2>Plan: {{ $plan->nombre }} — {{ number_format($plan->precio,2,',','.') }} €</h2>
    <p>{{ $plan->descripcion }}</p>

    <form action="{{ route('paypal.checkout') }}" method="POST">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

        <div class="form-group mb-3">
            <label for="prenda_id">Prenda a destacar:</label>
            <select name="prenda_id" id="prenda_id" class="form-control" required>
                <option value="">— Selecciona una prenda —</option>
                @foreach($prendas as $prenda)
                    <option value="{{ $prenda->id_prenda }}">{{ $prenda->nombre }}</option>
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
