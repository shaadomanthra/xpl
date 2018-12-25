    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PacketPrep') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    </head>
    <body>
    <div  style="max-width:400px;margin:0px auto;">
    @yield('content-main')
    </div>
    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
