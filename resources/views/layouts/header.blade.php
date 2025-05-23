<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHeader.css') }}">

    @yield('css')
    @yield('scripts')
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('img/pompita-negro.png') }}" alt="Logo" class="logo-img">
                </a>
                <!-- Hamburguesa -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Contenido del menú -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Versión móvil (dropdown) -->
                    <div class="d-lg-none mobile-menu">
                        @auth
                            <div class="search-container mb-3">
                                <input type="text" id="mobile-user-search" placeholder="Buscar usuarios…"
                                    autocomplete="off" />
                                <div id="mobile-search-results" class="search-results"></div>
                            </div>
                        @endauth

                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/prendas') }}">Prendas</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/outfit') }}">Crear Outfit</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/outfits') }}">Outfits</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/calendario') }}">Calendario</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/solicitar-ropa') }}">Solicitar
                                    Ropa</a></li>

                            @if(optional(auth()->user()->rol)->nombre === 'empresa')
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('empresas.index') }}">
                                        <i class="fas fa-building"></i> Modo Empresa
                                    </a>
                                </li>
                            @endif

                            @if(optional(auth()->user()->rol)->nombre === 'gestor')
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('gestor.index') }}">
                                        <i class="fas fa-tasks"></i> Modo Gestor
                                    </a>
                                </li>
                            @endif

                            @if(optional(auth()->user()->rol)->nombre === 'programador')
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('programador.index') }}">
                                        <i class="fas fa-laptop-code"></i> Modo Programador
                                    </a>
                                </li>
                            @endif

                        </ul>
                        <!-- Mover el toggle switch aquí -->
                        <div class="toggle-switch ms-3">
                            <label class="switch-label mb-0">
                                <input type="checkbox" class="checkbox" id="theme-toggle-mobile">
                                <span class="slider"></span>
                            </label>
                        </div>
                        @auth
                            <div class="mobile-user-section mt-3 pt-3 border-top">
                                <a href="{{ route('perfil') }}"
                                    class="d-flex align-items-center mb-3 text-white text-decoration-none">
                                    <img src="{{ auth()->user()->foto_perfil && Str::startsWith(auth()->user()->foto_perfil, 'http')
                                        ? auth()->user()->foto_perfil
                                        : asset(auth()->user()->foto_perfil ?? 'img/default-profile.png') }}"
                                        alt="Perfil" class="profile-small me-2">
                                    <span>Mi perfil</span>
                                </a>

                                <!-- Notificaciones -->
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100 text-start" id="mobile-notification-button">
                                        <i class="fas fa-bell me-2"></i> Notificaciones
                                        ({{ auth()->user()->unreadNotifications->count() }})
                                    </button>
                                    <div id="mobile-notification-panel" class="notification-panel mt-2">
                                        <h3>Notificaciones</h3>
                                        <ul>
                                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">@csrf
                                                <button type="submit" class="mark-read-button w-100 mb-2">Marcar todo como
                                                    leído</button>
                                            </form>
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                                <li>
                                                    {{ $notification->data['message'] }}
                                                    <form
                                                        action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="mark-read-button">Leída</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Admin -->
                                @if (optional(auth()->user()->rol)->nombre === 'admin')
                                    <a href="{{ route('admin.usuarios.index') }}"
                                        class="btn btn-primary w-100 text-start mb-3">
                                        <i class="fas fa-tools me-2"></i> Panel Admin
                                    </a>
                                @endif

                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>

                    <!-- Versión desktop (igual que antes) -->
                    <div
                        class="d-none d-lg-flex w-100 align-items-center justify-content-between flex-wrap flex-lg-nowrap">
                        @auth
                            <div style="margin-left: 0px"
                                class="search-container ms-lg-5 me-lg-3 order-1 order-lg-0 d-flex align-items-center">
                                <input type="text" id="user-search" placeholder="Buscar usuarios…" autocomplete="off" />
                                <div id="search-results" class="search-results"></div>

                            </div>
                            <!-- Mover el toggle switch aquí -->
                            <div class="toggle-switch ms-3">
                                <label class="switch-label mb-0">
                                    <input type="checkbox" class="checkbox" id="theme-toggle-desktop">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        @endauth

                        <ul class="navbar-nav mx-auto order-2 text-center flex-grow-1 justify-content-center">
                            <li class="nav-item"><a class="nav-link" href="{{ url('/prendas') }}">Prendas</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/outfit') }}">Crear Outfit</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/outfits') }}">Outfits</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/calendario') }}">Calendario</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/solicitar-ropa') }}">Solicitar
                                    Ropa</a></li>

                            @if(optional(auth()->user()->rol)->nombre === 'empresa')
                               <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('empresas.index') }}">
                                        <i class="fas fa-building"></i> Modo Empresa
                                    </a>
                                </li>
                            @endif

                            @if(optional(auth()->user()->rol)->nombre === 'gestor')
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('gestor.index') }}">
                                        <i class="fas fa-tasks"></i> Modo Gestor
                                    </a>
                                </li>
                            @endif

                            @if(optional(auth()->user()->rol)->nombre === 'programador')
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="{{ route('programador.index') }}">
                                        <i class="fas fa-laptop-code"></i> Modo Programador
                                    </a>
                                </li>
                            @endif
                            
                        </ul>
                        @auth
                            <div class="user-section d-flex align-items-center gap-2 order-3 ms-lg-auto">
                                <!-- Notificaciones -->
                                <div class="input me-2">
                                    <button class="value" id="notification-button">
                                        <i class="fas fa-bell"></i>
                                        <span
                                            class="d-none d-md-inline">({{ auth()->user()->unreadNotifications->count() }})</span>
                                    </button>
                                    <div id="notification-panel" class="notification-panel">
                                        <h3>Notificaciones</h3>
                                        <ul>
                                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="mark-read-button">Marcar todo como
                                                    leído</button>
                                            </form>
                                            @foreach (auth()->user()->unreadNotifications as $notification)
                                                <li>
                                                    {{ $notification->data['message'] }}
                                                    <form
                                                        action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="mark-read-button">Leída</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Admin -->
                                @if (optional(auth()->user()->rol)->nombre === 'admin')
                                    <a href="{{ route('admin.usuarios.index') }}" class="admin-button">
                                        <i class="fas fa-tools"></i> <span class="d-none d-md-inline">Panel Admin</span>
                                    </a>
                                @endif

                                <!-- Perfil -->
                                <div class="profile-large me-2">
                                    <a href="{{ route('perfil') }}">
                                        <img src="{{ auth()->user()->foto_perfil && Str::startsWith(auth()->user()->foto_perfil, 'http')
                                            ? auth()->user()->foto_perfil
                                            : asset(auth()->user()->foto_perfil ?? 'img/default-profile.png') }}"
                                            alt="Perfil">
                                    </a>
                                </div>

                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="logout-icon" title="Cerrar sesión">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>@yield('content')</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.Laravel = window.Laravel || {};
        window.Laravel.searchRoute = "{{ route('users.search') }}";
    </script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Funcionalidad para ambos interruptores
            function setupThemeToggle(toggleId) {
                const toggle = document.getElementById(toggleId);
                if (!toggle) return;

                // Aplica el modo guardado al cargar
                if (localStorage.getItem('theme') === 'dark') {
                    document.body.classList.add('dark-mode');
                    toggle.checked = true;
                }

                toggle.addEventListener('change', function() {
                    if (this.checked) {
                        document.body.classList.add('dark-mode');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.body.classList.remove('dark-mode');
                        localStorage.setItem('theme', 'light');
                    }

                    // Sincroniza el estado del otro interruptor
                    const otherToggleId = toggleId === 'theme-toggle-mobile' ? 'theme-toggle-desktop' :
                        'theme-toggle-mobile';
                    const otherToggle = document.getElementById(otherToggleId);
                    if (otherToggle) {
                        otherToggle.checked = this.checked;
                    }
                });
            }

            // Configura ambos interruptores
            setupThemeToggle('theme-toggle-mobile');
            setupThemeToggle('theme-toggle-desktop');
        });
    </script>
</body>

</html>
