<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'μs¡k') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .footer {
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark shadow-lg">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img href="{{ url('/') }}" src="{{url('controller.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                Controller Musik
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <div class="container">
            <footer>
                <div class="footer">
                    <iframe src="https://tunein.com/embed/player/s25905/" style="width:100%; height:100px;" scrolling="no" frameborder="no"></iframe>
                </div>

                <div>
                    <iframe src="https://tunein.com/embed/player/s6984/" style="width:100%; height:100px;" scrolling="no" frameborder="no"></iframe>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>