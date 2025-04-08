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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    @yield('css')
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
                        @if (auth()->user()->rol->nombre === 'Admin')
                            <a href="/admin/dashboard">Panel Admin</a>
                        @endif
                    @endauth
                </div>
                <div class="user-avatar">
                    <a href="profile">
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
