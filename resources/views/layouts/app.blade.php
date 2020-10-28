<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-gray-900 text-white">

    <header class="flex items-center justify-between mx-auto px-8 py-6">
        <div class="flex items-center space-x-10">
            <h1 class="text-uppercase text-3xl font-hairline">Virtual Wallets</h1>
        </div>

        <div class="flex justify-between items-center space-x-6">
            @guest
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @else
                <img src="/images/avatar.jpeg" alt="avatar" class="w-8 rounded-full">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                   class="hover:text-gray-400"
                >
                    Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </div>
    </header>


    <main class="px-8 py-6">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
