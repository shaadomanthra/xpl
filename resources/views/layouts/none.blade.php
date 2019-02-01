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
    
    @yield('content')

    <!-- Scripts -->
     @include('snippets.scripts')
    </body>
    </html>
