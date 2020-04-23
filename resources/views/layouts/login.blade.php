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
      <link href="{{ asset('css/styles.css') }}?new=11" rel="stylesheet">
      
      @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
  <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @else
  <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
  @endif
  
    </head>
    <body>
      <div  style="max-width:400px;margin:0px auto;">
        @yield('content-main')
      </div>
      


    </body>
    </html>
