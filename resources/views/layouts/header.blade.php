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

            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="d-flex w-100 align-items-center justify-content-between flex-wrap flex-lg-nowrap">
                    <!-- Izquierda: Buscador -->
                    @auth
                    <div class="search-container ms-lg-5 me-lg-3 order-1 order-lg-0">
                        <input type="text" id="user-search" placeholder="Buscar usuarios…" autocomplete="off" />
                            <div id="search-results" class="search-results"></div>
                        </div>
                    @endauth

                    <!-- Centro: Navegación -->
                    <ul class="navbar-nav mx-auto order-2 text-center flex-grow-1 justify-content-center">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/prendas') }}">Prendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/outfit') }}">Crear Outfit</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/outfits') }}">Outfits</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/calendario') }}">Calendario</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/solicitar-ropa') }}">Solicitar Ropa</a></li>
                    </ul>

                    <!-- Derecha: Usuario -->
                    <div class="user-section d-flex align-items-center gap-2 order-3 ms-lg-auto">
                        @auth
                            <!-- Notificaciones -->
                            <div class="input me-2">
                                <button class="value" id="notification-button">
                                    <i class="fas fa-bell"></i>
                                    <span class="d-none d-md-inline">({{ auth()->user()->unreadNotifications->count() }})</span>
                                </button>
                                <div id="notification-panel" class="notification-panel">
                                    <h3>Notificaciones</h3>
                                    <ul>
                                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">@csrf
                                            <button type="submit" class="mark-read-button">Marcar todo como leído</button>
                                        </form>
                                        @foreach (auth()->user()->unreadNotifications as $notification)
                                            <li>
                                                {{ $notification->data['message'] }}
                                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" style="display:inline;">
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
                                        : asset(auth()->user()->foto_perfil ?? 'img/default-profile.png') }}" alt="Perfil">
                                </a>
                            </div>

                            <!-- Logout -->
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="logout-icon" title="Cerrar sesión">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main>@yield('content')</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Notificaciones
    const btn = document.getElementById('notification-button');
    const panel = document.getElementById('notification-panel');
    if (btn && panel) {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            panel.classList.toggle('active');
        });
        document.addEventListener('click', e => {
            if (!panel.contains(e.target) && !btn.contains(e.target)) {
                panel.classList.remove('active');
            }
        });
    }

    // Buscador AJAX
    const input = document.getElementById('user-search');
    const results = document.getElementById('search-results');
    let timer;
    if (input) {
        input.addEventListener('keyup', () => {
            clearTimeout(timer);
            const q = input.value.trim();
            if (!q) {
                results.innerHTML = '';
                return;
            }
            timer = setTimeout(() => {
                fetch("{{ route('users.search') }}?query=" + encodeURIComponent(q), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.json())
                .then(users => {
                    results.innerHTML = users.map(u => `
                        <div class="search-item" data-id="${u.id_usuario}">
                            <img src="${u.avatar}" class="search-avatar">
                            <span>${u.nombre}</span>
                        </div>
                    `).join('');
                    document.querySelectorAll('.search-item').forEach(item => {
                        item.addEventListener('click', () => {
                            window.location.href = `/perfil/publico/${item.dataset.id}`;
                        });
                    });
                });
            }, 300);
        });

        document.addEventListener('click', e => {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.innerHTML = '';
            }
        });
    }
});
</script>

</body>
</html>
