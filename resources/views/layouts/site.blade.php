<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="{{ $page->meta_description ? $page->meta_description : getEnvValue('APP_META_DESC') }}" />
        <link rel="manifest" href="{{ asset('mix-manifest.json') }}" crossorigin="use-credentials">
        <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="{{ asset('img/favicons/favicon.ico') }}">

        @stack('css')

        @if(getEnvValue('APP_ENV') === 'local')
            <link rel="stylesheet" href="<?= asset('/css/main.css') ?>">
        @else
            <link rel="stylesheet" href="<?= asset('/css/main.min.css') ?>">
        @endif

        <title>{{ $page->title ? $page->title : getEnvValue('APP_NAME') }}</title>

    </head>
    <body>
        <nav class="container">
            <div class="wrapper main-navigation">
                <div class="logo">
                    <img src="{{ asset('/img/svg/logo.svg') }}" alt="Logo">
                </div>
                <ul class="menu">
                    <li>Item</li>
                    <li>item</li>
                    <li>item</li>
                    <li>item</li>
                    <li>item</li>
                    <li>item</li>
                </ul>
            </div>
        </nav>
        <header class="container">
            <div class="wrapper header">
                <h1>{!! $page->header_title !!}</h1>
            </div>
        </header>

        <main class="content container">
            <div class="wrapper">
                @yield('content')
            </div>
        </main>
        <footer class="container">
            <div class="wrapper">
                <p>pied de gabarit</p>
            </div>
        </footer>

        @stack('scripts')

        @if(getEnvValue('APP_ENV') === 'local')
            <script type="text/javascript" src="{{ asset('/js/main.js') }}"></script>
        @else
            <script type="text/javascript" src="{{ asset('/js/main.min.js') }}"></script>
        @endif

    </body>
</html>
