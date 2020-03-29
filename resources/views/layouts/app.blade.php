<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="bg-gray-100">
    <header class="py-4 bg-white">
        <div class="container mx-auto">
            @if (Route::has('login'))
                <div class="links flex justify-between">
                    <a href="{{ url('/notes') }}">Lifelong Notes</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="submit" value="Logout" />
                        </form>
                    @else
                        <div>
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">| Register</a>
                            @endif
                        </div>
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <main class="container mx-auto">
        @yield('content')
    </main>

    <footer></footer>
</body>
