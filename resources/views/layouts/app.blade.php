<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        /* Dropdown inside collapsed navbar stays inline on mobile */
        @media (max-width: 767.98px) {
            .navbar-nav .dropdown-menu {
                position: static !important;
                border: none;
                box-shadow: none;
                padding-left: 1rem;
                background: transparent;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('logo.png') }}" alt="Lia Store">
                </a>

                <!-- Cart icon visible on mobile (outside collapse) -->
                <a href="{{ route('cart.showCart') }}" class="d-md-none ms-auto me-2" style="color: black;">
                    <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search bar: first on mobile, hidden on desktop (shown in right ul) -->
                    <form action="{{ route('product.catalogo') }}" method="GET" class="d-md-none mb-2 mt-2">
                        <input type="text" class="form-control" name="search" placeholder="Buscar producto" value="{{ request('search') }}">
                    </form>

                    <!-- Nav links -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="{{ route('contacto') }}">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="{{ route('product.catalogo') }}">Catálogo</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar (desktop) -->
                    <ul class="navbar-nav align-items-center">
                        <!-- Search: desktop only -->
                        <li class="nav-item me-2 d-none d-md-block">
                            <form action="{{ route('product.catalogo') }}" method="GET">
                                <input type="text" class="form-control" name="search" placeholder="Buscar producto" value="{{ request('search') }}">
                            </form>
                        </li>

                        <!-- Cart icon: desktop only -->
                        <li class="nav-item d-none d-md-flex align-items-center me-2">
                            <a href="{{ route('cart.showCart') }}" style="color: black;">
                                <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                            </a>
                        </li>

                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-md-end" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role === 'admin')
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Panel de administracion
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('edit-profile') }}">Informacion personal</a>
                                <a class="dropdown-item" href="{{ route('mostrar-informacion-pago') }}">Informacion de pago</a>
                                <a class="dropdown-item" href="{{ route('pedidos.historial') }}">Historial de pedidos</a>
                                <a class="dropdown-item" href="{{ route('mostrar-direcciones') }}">Direcciones</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Flash notifications --}}
        @if(session('success') || session('error'))
        <style>
            .app-flash {
                position: fixed; bottom: 24px; right: 24px; z-index: 9999;
                padding: 14px 20px; border-radius: 6px; font-size: 0.875rem;
                max-width: 340px; pointer-events: none;
                animation: flashIn 0.3s ease both, flashOut 0.4s ease 3.8s forwards;
            }
            .app-flash--success { background: #111; color: #fff; }
            .app-flash--error   { background: #dc3545; color: #fff; }
            @keyframes flashIn  { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
            @keyframes flashOut { from { opacity:1; } to { opacity:0; } }
        </style>
        <div class="app-flash {{ session('success') ? 'app-flash--success' : 'app-flash--error' }}">
            {{ session('success') ?? session('error') }}
        </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
