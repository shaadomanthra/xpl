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
    @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
    <meta name="theme-color" content="#236fb1"/>
    @else
    <meta name="theme-color" content="#c25054"/>
    @endif
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
  
  @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
      <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' )
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
  @else
     <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
  @endif

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
  <link href="{{ asset('css/styles2.css') }}?new=13" rel="stylesheet">
  @elseif(domain()=='piofx')
  @if(request()->segment(1)=='dashboard' || request()->segment(1)=='training')
  <link href="{{ asset('css/styles.css') }}?new=13" rel="stylesheet">
  <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('css/bfs.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('assets/css/themes/layout/header/base/light.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/header/menu/light.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/brand/light.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/themes/layout/aside/light.css?v=7.0.4')}}" rel="stylesheet" type="text/css" />
  @else
    <link href="{{ asset('css/styles.css') }}?new=13" rel="stylesheet">
  @endif
  @else
  <link href="{{ asset('css/styles.css') }}?new=13" rel="stylesheet">
  @endif

  @if(isset($sketchpad))
  <link href="{{ asset('css/sketchpad.css') }}?new=13" rel="stylesheet">
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
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetime/jquery-ui-timepicker-addon.min.css')}}">
@endif

</head>
<body >
    <div id="app" >

        @yield('content-main')
    </div>
    <div class="bg-dark">
        <footer class="text-light footer">
            <div class="container py-3">
             

              @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
                  @include('snippets.bottommenu')
              @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
                @include('snippets.footer')
              @else
                 @include('snippets.bottommenu-client')
              @endif

            </div>
        </footer>
    </div>
    <!-- Scripts -->
    @include('snippets.scripts')
</body>
</html>
