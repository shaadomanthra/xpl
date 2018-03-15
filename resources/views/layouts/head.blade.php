    <!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PacketPrep') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    <style>
    .ck-editor__editable {
        min-height: 200px;
    }
    </style>
    
    @if(isset($mathjax))
    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        extensions: ["tex2jax.js"],
        jax: ["input/TeX","output/HTML-CSS"],
        tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
      });
    </script>

    <script type="text/javascript"
         src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
      </script>
    @endif

    </head>
    <body>
    <div id="app" >
    @yield('content-main')
    </div>
    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
