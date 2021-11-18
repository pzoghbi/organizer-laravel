<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('layouts.partials.nav')
    {{--    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
    {{--        <div class="container">--}}
    {{--            <a class="navbar-brand" href="{{ url('/') }}">--}}
    {{--                {{ config('app.name', 'Laravel') }}--}}
    {{--            </a>--}}

    {{--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
    {{--                    aria-controls="navbarSupportedContent" aria-expanded="false"--}}
    {{--                    aria-label="{{ __('Toggle navigation') }}">--}}
    {{--                <span class="navbar-toggler-icon"></span>--}}
    {{--            </button>--}}

    {{--            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">--}}
    {{--                <!-- Left Side Of Navbar -->--}}
    {{--                <ul class="navbar-nav mr-auto">--}}

    {{--                </ul>--}}

    {{--                <div class="dropdown">--}}
    {{--                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">--}}
    {{--                        Linkovi--}}
    {{--                    </button>--}}
    {{--                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">--}}
    {{--                        <li><a class="dropdown-item" href="{{ route('schedule.index') }}">Schedules</a></li>--}}
    {{--                        <li><a class="dropdown-item" href="{{ route('task.index') }}">Tasks</a></li>--}}
    {{--                        <li><a class="dropdown-item" href="{{ route('material.index') }}">Materials</a></li>--}}
    {{--                        <li><a class="dropdown-item" href="{{ route('subject.index') }}">Subjects</a></li>--}}
    {{--                    </ul>--}}
    {{--                </div>--}}

    {{--                <!-- Right Side Of Navbar -->--}}
    {{--                <ul class="navbar-nav ms-auto">--}}
    {{--                    <!-- Authentication Links -->--}}
    {{--                    @guest--}}
    {{--                        @if (Route::has('login'))--}}
    {{--                            <li class="nav-item">--}}
    {{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
    {{--                            </li>--}}
    {{--                        @endif--}}

    {{--                        @if (Route::has('register'))--}}
    {{--                            <li class="nav-item">--}}
    {{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
    {{--                            </li>--}}
    {{--                        @endif--}}
    {{--                    @else--}}
    {{--                        <li class="nav-item dropdown">--}}
    {{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
    {{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
    {{--                                {{ Auth::user()->name }}--}}
    {{--                            </a>--}}

    {{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
    {{--                                <a class="dropdown-item" href="{{ route('logout') }}"--}}
    {{--                                   onclick="event.preventDefault();--}}
    {{--                                                     document.getElementById('logout-form').submit();">--}}
    {{--                                    {{ __('Logout') }}--}}
    {{--                                </a>--}}

    {{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
    {{--                                    @csrf--}}
    {{--                                </form>--}}
    {{--                            </div>--}}
    {{--                        </li>--}}
    {{--                    @endguest--}}
    {{--                </ul>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </nav>--}}

    <main class="py-4 container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-10 col-sm-12">
                @yield('content')
            </div>
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>
