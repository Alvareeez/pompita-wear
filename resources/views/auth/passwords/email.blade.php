@extends('layouts.header')

@section('content')
    <div class="container">
        <h2>Restablecer contraseña</h2>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" required class="form-control" autofocus>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Enviar enlace de restablecimiento</button>
        </form>
    </div>
@endsection
