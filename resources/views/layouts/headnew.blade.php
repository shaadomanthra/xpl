    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Packet Prep') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    <link href="https://fonts.googleapis.com/css?family=Oswald:700|Pacifico|Shadows+Into+Light" rel="stylesheet">
    </head>
    <body>
    
    @yield('content-main')
    
    <!-- Scripts -->

     @include('snippets.scripts')
    </body>
    </html>
