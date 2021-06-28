    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <title>@yield('title')</title>


    @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
      <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' )
    <link rel="shortcut icon" href="{{asset('/favicon_xplore.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || domain() == 'piofx' || $_SERVER['HTTP_HOST'] == 'piofx.in')
    <link rel="shortcut icon" href="{{asset('/favicon_piofx.ico')}}" />
  @else
     <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
  @endif
  
  @if(isset($editor))
  <link href="{{asset('js/summernote/summernote-bs4.css')}}" rel="stylesheet">
  @endif
  @if(isset($code))
  <link href="{{asset('js/codemirror/lib/codemirror.css')}}" rel="stylesheet">
  <link href="{{asset('js/codemirror/theme/monokai.css')}}" rel="stylesheet">
  <link href="{{asset('js/highlight/styles/default.css')}}" rel="stylesheet">
  <link href="{{asset('js/highlight/styles/tomorrow.css')}}" rel="stylesheet">
  @endif
  @if(isset($highlight))
  <link href="{{ asset('css/styles2.css') }}?new=11" rel="stylesheet">
  @else
  <link href="{{ asset('css/styles.css') }}?new=11" rel="stylesheet">
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
    <body >
    
    @yield('content')

    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
