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
    @yield('css')
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
                    <a href="/">Buscar Outfits</a>
                    @auth
                    @if(auth()->user()->rol->nombre === 'admin') 
                        <a href="/admin/usuarios">Panel Admin</a>
                    @endif
                    @endauth
                </div>
                <div class="user-avatar">
                    <a href="perfil">
                        @if (Auth::check() && Auth::user()->foto_perfil)
                            <img src="{{ asset('img/' . Auth::user()->foto_perfil) }}" alt="Foto perfil"
                                class="profile-photo">
                        @else
                            <img src="{{ asset('img/predeterminada.png') }}" alt="Foto perfil" class="profile-photo">
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>


</body>

</html>