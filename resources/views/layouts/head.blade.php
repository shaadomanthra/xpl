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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#236fb1"/>
    <link rel="manifest" href="/manifest.json">
    <meta property="og:url"           content="{{ request()->url() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="@yield('title')" />
    <meta property="og:description"   content="@yield('description')" />
    <meta property="og:image"         content="@yield('image')" />
    @if(isset($autoads))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
       (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-9550642194256443",
          enable_page_level_ads: true
      });
    </script>
    @endif
  <title>@yield('title')</title>
  
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
  @if(isset($highlight))
  <link href="{{ asset('css/styles2.css') }}?new=2" rel="stylesheet">
  @else
  <link href="{{ asset('css/styles.css') }}?new=2" rel="stylesheet">
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
