<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nostalgram') }}</title>

    <!-- favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!--Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Carattere&family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Nostalgram
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li>
                            
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('image.public') }}">Subir imagen</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('user.index') }}">Buscar</a>
                            </li>
                            <li>
                                <div class="avatar-nav">
                                    @if(Auth::user()->image)
                                    <img src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" alt="">   
                                    @else
                                    <img src="{{ asset('images/no-disponible.jpg') }}" alt="sin imagen">
                                    @endif
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.perfil', ['id' => Auth::user()->id]) }}">
                                        Mi perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('config') }}">
                                        Editar perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('like.index') }}">
                                        Favoritas
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
