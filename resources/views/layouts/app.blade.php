 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INSTRAGRAM') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    INSTRAGRAM
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.index') }}">Feed</a>
                            </li>
                    </ul>

                    <!-- Search Form -->
                    @if (!request()->is('login') && !request()->is('register'))
                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search users">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    @endif
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @auth
                        <!-- Notification button -->
                        <li class="nav-item me-2">
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary position-relative" title="Notifications">
                                <i class="fa fa-bell"></i>
                                <!-- Example badge -->
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                        @endauth
                        <button id="theme-toggle" class="btn btn-outline-secondary ms-2">🌙</button>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.create') }}">
                                    <i class="fa fa-plus-square"></i> New Post
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>
           
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}">
                                       Profile
                                    </a> --}}
                                    <a class="dropdown-item" href="{{ route('profile.show', ['user' => Auth::user()->username]) }}">
                                         Profile
                                    </a>


                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
