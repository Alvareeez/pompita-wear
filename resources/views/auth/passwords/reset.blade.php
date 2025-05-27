@extends('layouts.header')

@section('content')
    <div class="container">
        <h2>Restablecer contraseña</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email">Correo electrónico</label>
                <input readonly id="email" type="email" name="email" value="{{ old('email', $email) }}"
                    class="form-control @error('email') is-invalid @enderror" autofocus>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">Nueva contraseña</label>
                <input id="password" type="password" name="password" required
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm">Confirmar contraseña</label>
                <input id="password-confirm" type="password" name="password_confirmation" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
        </form>
    </div>
@endsection
