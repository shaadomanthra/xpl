    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OnlineLibrary') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    <style>
    html,body{
      height: 200px;
    }
    .container {
      width: auto;
      max-width: 680px;
    }
    </style>
    </head>
    <body>
    
    @yield('content')

    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
