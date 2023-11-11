<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('logo.svg') }}">
        <title>Barbaer Shop</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">



        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="text-white">
            <div id="app">
               @yield('content')

            </div>

            <script src="{{ mix('js/app.js') }}"></script>
            @yield('scripts')
    </body>
</html>
