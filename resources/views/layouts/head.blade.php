    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="Krishna Teja G S">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Styles -->
    
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @if(isset($carousel))
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    @endif
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
  
    @if(isset($editor))
    <link href="{{asset('js/summernote/summernote-bs4.css')}}" rel="stylesheet">
    @endif

    @if(isset($code))
    <link href="{{asset('js/codemirror/lib/codemirror.css')}}" rel="stylesheet">
    <link href="{{asset('js/codemirror/theme/abcdef.css')}}" rel="stylesheet">

    <link href="{{asset('js/highlight/styles/default.css')}}" rel="stylesheet">
    <link href="{{asset('js/highlight/styles/tomorrow.css')}}" rel="stylesheet">
    @endif
    
    @if(isset($mathjax))
    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        extensions: ["tex2jax.js"],
        jax: ["input/TeX","output/HTML-CSS"],
        tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
      });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    @endif

    @if(isset($recaptcha))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    @if(isset($jqueryui))
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    @endif


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-43617911-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-43617911-7');
</script>

    </head>
    <body>
    <div id="app" >
    @yield('content-main')
    </div>
 

 <div class="bg-dark">
    <footer class="wrapper text-light footer">
        <div class="container py-3">
            @include('snippets.footer')
        </div>
    </footer>
</div>
    <!-- Scripts -->
     @include('snippets.scripts')
</body>
</html>
