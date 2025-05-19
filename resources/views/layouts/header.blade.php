<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleHeader.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('css')
    @yield('scripts')
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <!-- Logo -->
                <div class="brand-section">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('img/pompita-negro.png') }}" alt="Logo" class="logo-img">
                    </a>
                </div>

                <!-- Botón hamburguesa -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenido colapsable -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Buscador AJAX usuarios - solo en pantallas grandes -->
                    @auth
                        <div class="search-container d-none d-lg-block mx-3">
                            <input type="text" id="user-search" placeholder="Buscar usuarios…" autocomplete="off" />
                            <div id="search-results" class="search-results"></div>
                        </div>
                    @endauth

                    <!-- Sección usuario / notificaciones -->
                    <div class="user-section ms-auto d-flex align-items-center">
                        @auth
                            @if (optional(auth()->user()->rol)->nombre === 'admin')
                                <div class="input me-2">
                                    <a href="{{ route('admin.usuarios.index') }}" style="text-decoration:none;">
                                        <button class="admin-button" type="button"
                                            style="width:100%;display:flex;align-items:center;gap:8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                                <path fill-rule="evenodd" fill="#ffffff"
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"
                                                    />
                                            </svg>
                                            Panel Admin
                                        </button>
                                    </a>
                                </div>
                            @endif

                            <div class="input me-2">
                                <button class="value" id="notification-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25" fill="none">
                                        <path fill-rule="evenodd" fill="#7D8590"
                                            d="m11.9572 4.31201c-3.35401 0-6.00906 2.59741-6.00906 5.67742v3.29037c0 .1986-.05916.3927-.16992.5576l-1.62529 2.4193-.01077.0157c-.18701.2673-.16653.5113-.07001.6868.10031.1825.31959.3528.67282.3528h14.52603c.2546 0 .5013-.1515.6391-.3968.1315-.2343.1117-.4475-.0118-.6093-.0065-.0085-.0129-.0171-.0191-.0258l-1.7269-2.4194c-.121-.1695-.186-.3726-.186-.5809v-3.29037c0-1.54561-.6851-3.023-1.7072-4.00431-1.1617-1.01594-2.6545-1.67311-4.3019-1.67311zm-8.00906 5.67742c0-4.27483 3.64294-7.67742 8.00906-7.67742 2.2055 0 4.1606.88547 5.6378 2.18455.01.00877.0198.01774.0294.02691 1.408 1.34136 2.3419 3.34131 2.3419 5.46596v2.97007l1.5325 2.1471c.6775.8999.6054 1.9859.1552 2.7877-.4464.795-1.3171 1.4177-2.383 1.4177h-14.52603c-2.16218 0-3.55087-2.302-2.24739-4.1777l1.45056-2.1593zm4.05187 11.32257c0-.5523.44772-1 1-1h5.99999c.5523 0 1 .4477 1 1s-.4477 1-1 1h-5.99999c-.55228 0-1-.4477-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Notificaciones ({{ auth()->user()->unreadNotifications->count() }})
                                </button>
                                <div id="notification-panel" class="notification-panel">
                                    <h3>Notificaciones</h3>
                                    <ul>
                                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="mark-read-button">Marcar todo como leído</button>
                                        </form>
                                        @foreach (auth()->user()->unreadNotifications as $notification)
                                            <li>
                                                {{ $notification->data['message'] }}
                                                <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mark-read-button">Marcar como
                                                        leída</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Foto perfil -->
                            <div class="profile-large me-2">
                                @php $foto = auth()->user()->foto_perfil; @endphp
                                <a href="{{ route('perfil') }}">
                                    <img src="{{ $foto && Str::startsWith($foto, 'http') ? $foto : ($foto ? asset($foto) : asset('img/default-profile.png')) }}"
                                        alt="Foto perfil grande">
                                </a>
                            </div>

                            <!-- Logout -->
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="logout-button">Cerrar sesión</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notificaciones toggle
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

            // AJAX buscador usuarios
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
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
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
                                        window.location.href =
                                            `/perfil/publico/${item.dataset.id}`;
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
