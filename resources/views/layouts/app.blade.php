<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Script jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('pluggins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pluggins/bootstrap/css/bootstrap.min.css') }}">
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #EFF8FB;">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}" style="padding:0; margin:0;">
                    {{-- config('app.name', 'Laravel') --}}<img src="{{ asset('img/IPSP.ico') }}" alt="IPSP icon" width="20%" >
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li class="nav-item">
                                <a class="nav-link">Ayuda</a>
                            </li>
                        @else
                            <div class="dropdown-divider"></div>
                            <a class="nav-link" href="{{ route('perfil.show') }}"><i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                            
                            <div class="dropdown-divider"></div>
                            <a class="nav-link" href="{{ route('home') }}">Votaciones</a>
                            <a class="nav-link" href="{{ route('resultado.index') }}">Resultados</a>
                            @if (Auth::user()->user_type == 'Admin')
                                <a class="nav-link" href="{{ route('register') }}">Crear Usuario</a>
                            @endif
                            <div class="dropdown-divider"></div>

                            <div>
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('pluggins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
