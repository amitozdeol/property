<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        //Use https when running in production
        $api_url = url('/api');
        $env = env('APP_ENV');
        if($env == 'Production'){
            $api_url = str_replace('http', 'https', $api_url);
        }
    @endphp
    <meta name="api-base-url" content="{{ $api_url }}" />
    <meta name="api-base-token" content="{{ auth()->user()->api_token ?? '' }}" />

    <title>{{ config('app.name', 'Laravel Test') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#008080">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css">
</head>

<body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-white" href="/dashboard">
                    <img src="/favicon/android-chrome-192x192.png"> <span class="ml-1">PROPERTY</span>
                </a>

                <a role="button" class="navbar-burger has-text-white" aria-label="menu" aria-expanded="false"
                    data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">

                <div class="navbar-end">
                    <div class="navbar-item">
                        @auth
                            <span class="mr-2 has-text-white">{{ Auth::user()->name }}</span>
                        @endauth

                        <div class="buttons">
                            @guest
                                <a class="button is-primary" href="{{ route('login') }}">
                                    <strong>{{ __('Login') }}</strong>
                                </a>
                                @if (Route::has('register'))
                                    <a class="button is-light" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @else
                                <a class="button is-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="wrapper">
        @yield('content')
    </main>

    <script>
        // Get all "navbar-burger" elements
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Check if there are any navbar burgers
        if ($navbarBurgers.length > 0) {

            // Add a click event on each of them
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });
        }
    </script>
</body>

</html>
