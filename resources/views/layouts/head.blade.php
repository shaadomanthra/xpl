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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    
    <link href="{{asset('js/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('js/codemirror/lib/codemirror.css')}}" rel="stylesheet">
    <link href="{{asset('js/codemirror/theme/mbo.css')}}" rel="stylesheet">

    <link href="{{asset('js/highlight/styles/default.css')}}" rel="stylesheet">
    <link href="{{asset('js/highlight/styles/tomorrow.css')}}" rel="stylesheet">
    
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


    @if(isset($recaptcha))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    @if(isset($jqueryui))
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    @endif

    </head>
    <body>
    <div id="app" >
    @yield('content-main')

    </div>
 
    <div class="bg-dark">
    <footer class=" wrapper  text-light footer">
        <div class="container py-3">
            @include('snippets.bottommenu')
        </div>
    </footer>
</div>

    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
