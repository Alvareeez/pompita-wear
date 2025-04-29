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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <div class="notifications">
                <div class="notification-icon" id="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">{{ Auth::user()->unreadNotifications->count() }}</span>
                </div>
                <div class="notification-dropdown" id="notification-dropdown">
                    <div class="notification-header">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="mark-all-read">Marcar todo como leído</button>
                        </form>
                    </div>
                    <ul>
                        @foreach (Auth::user()->unreadNotifications as $notification)
                            <li>
                                {{ $notification->data['message'] }}
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="mark-as-read">Marcar como leída</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="user-section">
                <div class="session-info">
                    @auth
                    @if(auth()->user()->rol->nombre === 'admin') 
                        <a href="/admin/usuarios">Panel Admin</a>
                    @endif
            
                    <!-- Botón Cerrar Sesión -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-button">
                            Cerrar sesión
                        </button>
                    </form>
                    @endauth
                </div>
            
                <div class="user-avatar">
                    <a href="/perfil">
                        @if (Auth::check() && Auth::user()->foto_perfil)
                            <img src="{{ Auth::user()->foto_perfil ? asset(Auth::user()->foto_perfil) : asset('img/default-profile.png') }}" alt="Foto perfil" class="profile-photo">
                        @else
                            <img src="{{ asset('img/default-profile.png') }}" alt="Foto perfil" class="profile-photo">
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationIcon = document.getElementById('notification-icon');
        const notificationDropdown = document.getElementById('notification-dropdown');

        if (notificationIcon && notificationDropdown) {
            // Alternar la visibilidad del menú al hacer clic en el ícono
            notificationIcon.addEventListener('click', function () {
                notificationDropdown.classList.toggle('active');
            });

            // Cerrar el menú si se hace clic fuera de él
            document.addEventListener('click', function (event) {
                if (!notificationIcon.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.remove('active');
                }
            });
        }
    });
</script>
@endsection

</body>

</html>