<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styleHeader.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('scripts')
</head>

<body>
    <header class="header">
        <div class="header-container">
            <div class="brand-section">
                <div class="logo">
                    <a href="/"><img src="{{ asset('img/pompita-negro.png') }}" alt="Logo"></a>
                </div>
            </div>

            <div class="user-section">
                <div class="session-info">
                    <a href="/carro">
                        Carro
                    </a>
                    @auth
                        @if (auth()->user()->rol->nombre === 'admin')
                            <a href="/admin/usuarios">Panel Admin</a>
                        @endif

                    @endauth
                </div>

                <div class="user-avatar">
                    <a href="/perfil">
                        @if (Auth::check() && Auth::user()->foto_perfil)
                            <img src="{{ Auth::user()->foto_perfil ? asset(Auth::user()->foto_perfil) : asset('img/default-profile.png') }}"
                                alt="Foto perfil" class="profile-photo">
                        @else
                            <img src="{{ asset('img/default-profile.png') }}" alt="Foto perfil" class="profile-photo">
                        @endif
                    </a>
                </div>
                <!-- Botón Cerrar Sesión -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <div class="dropdown">
                        <button class="usuario-logueado dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li> <button type="submit" class="dropdown-item"><i
                                        class="fas fa-sign-out-alt"></i>Cerrar sesión
                                </button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
