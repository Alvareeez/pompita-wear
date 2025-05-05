@extends('layouts.header')

@section('title', 'Solicitudes de Seguimiento')

@section('content')
    <div class="container mt-4">
        <h2>Solicitudes Pendientes</h2>

        @if ($solicitudes->isEmpty())
            <div class="alert alert-info">No tienes solicitudes pendientes</div>
        @else
            <div class="list-group">
                @foreach ($solicitudes as $solicitud)
                    <div class="solicitud-card">
                        <img src="{{ $solicitud->foto_perfil ? asset($solicitud->foto_perfil) : asset('img/default-profile.png') }}"
                            alt="Foto de perfil" width="60">

                        <div>
                            <h5>{{ $solicitud->nombre }}</h5>
                            <form action="{{ route('solicitudes.aceptar', $solicitud->id_seguimiento) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                            </form>
                            <form action="{{ route('solicitudes.rechazar', $solicitud->id_seguimiento) }}" method="POST"
                                class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
