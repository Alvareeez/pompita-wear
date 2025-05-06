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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('css')
    @yield('scripts')
</head>

<style>
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
</style>

<body>
<header class="header">
    <div class="header-container">
        <div class="brand-section">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/pompita-negro.png') }}" alt="Logo">
                </a>
            </div>
        </div>

        <div class="user-section">
            @auth
                @if(optional(auth()->user()->rol)->nombre === 'admin')
                    <div class="input">
                        <button class="value">
                            <a href="{{ route('admin.usuarios.index') }}">Panel Admin</a>
                        </button>
                    </div>
                @else
                    <div class="input">
                        <button class="value" id="notification-button">
                            <!-- svg notificaciones -->
                            Notificaciones ({{ auth()->user()->unreadNotifications->count() }})
                        </button>
                        <div id="notification-panel" class="notification-panel">
                            <h3>Notificaciones</h3>
                            <ul>
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        {{ $notification->data['message'] }}
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                              method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="mark-read-button">
                                                Marcar como leída
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="mark-read-button">
                                    Marcar todo como leído
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Foto de perfil grande -->
                <div class="profile-large">
                    <a href="{{ route('perfil') }}">
                        @php
                            $foto = auth()->user()->foto_perfil;
                        @endphp
                        <img
                          src="{{ $foto && Str::startsWith($foto, 'http') 
                                    ? $foto 
                                    : ($foto 
                                        ? asset($foto) 
                                        : asset('img/default-profile.png')
                                      ) 
                                }}"
                          alt="Foto perfil grande"
                        >
                    </a>
                </div>

                <!-- Cerrar sesión -->
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
    document.addEventListener('DOMContentLoaded', function () {
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
    });
</script>
</body>
</html>
