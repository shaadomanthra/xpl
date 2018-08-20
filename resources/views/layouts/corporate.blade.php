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
     <link href="https://fonts.googleapis.com/css?family=Cabin|Lobster|Open+Sans" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />


    </head>
    <body>
    <div id="app" >
    @yield('content-main')

    </div>
 
    <div class="nav-bg-dark">
    <footer class=" wrapper  text-light footer">
        <div class="container py-3">
            @include('snippets.footer')
        </div>
    </footer>
</div>

    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
