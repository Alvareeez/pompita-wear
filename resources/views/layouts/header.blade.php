<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/styleHeader.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('css')
    @yield('scripts')

    <style>
        /* Perfil grande */
        .profile-large {
            position: absolute;
            top: 50%;
            right: 70px;
            transform: translateY(-50%);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .profile-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        /* Buscador AJAX */
        .search-container {
            position: relative;
            margin: 0 20px;
        }

        #user-search {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }

        .search-item {
            display: flex;
            align-items: center;
            padding: 8px;
            cursor: pointer;
        }

        .search-item:hover {
            background: #f5f5f5;
        }

        .search-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-container">

            <!-- Logo -->
            <div class="brand-section">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/pompita-negro.png') }}" alt="Logo">
                    </a>
                </div>
            </div>

            <!-- Buscador AJAX usuarios -->
            @auth
                <div class="search-container">
                    <input type="text" id="user-search" placeholder="Buscar usuarios…" autocomplete="off" />
                    <div id="search-results" class="search-results"></div>
                </div>
            @endauth

            <!-- Sección usuario / notificaciones -->
            <div class="user-section">
                @auth
                    @if (optional(auth()->user()->rol)->nombre === 'admin')
                        <div class="input">
                            <button class="admin-button">
                                <a href="{{ route('admin.usuarios.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" fill="#ffffff"
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                                    </svg>
                                    Panel Admin
                                </a>
                            </button>
                        </div>
                        <div class="input">
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
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        <li>
                                            {{ $notification->data['message'] }}
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="mark-read-button">Marcar como leída</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mark-read-button">Marcar todo como leído</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="input">
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
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        <li>
                                            {{ $notification->data['message'] }}
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="mark-read-button">Marcar como leída</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mark-read-button">Marcar todo como leído</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Foto perfil -->
                    <div class="profile-large">
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
    </header>

    <main>
        @yield('content')
    </main>

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