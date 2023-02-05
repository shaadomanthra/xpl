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
      
       @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'learn.packetprep.com' || $_SERVER['HTTP_HOST'] == 'learn.pp.test')
      <link rel="shortcut icon" href="{{asset('/favicon_pp.ico')}}" />
      @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' )
        <link rel="shortcut icon" href="{{asset('/favicon_xplore.ico')}}" />
      @elseif($_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || domain() == 'piofx' || $_SERVER['HTTP_HOST'] == 'piofx.in')
        <link rel="shortcut icon" href="{{asset('/favicon_piofx.ico')}}" />
      @elseif($_SERVER['HTTP_HOST'] == 'gradable.test' || env('APP_NAME') =='Gradable')
        <link rel="shortcut icon" href="{{asset('/favicon_gradable.ico')}}" />
        @elseif($_SERVER['HTTP_HOST'] == 'myparakh.test' || $_SERVER['HTTP_HOST'] == 'myparakh.com' || env('APP_NAME') =='Gradable')
      <link rel="shortcut icon" href="{{asset('/favicon-parakh.png')}}" />

      @else
         <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
      @endif
  
    </head>
    <body>
      <div  style="max-width:400px;margin:0px auto;">
        @yield('content-main')
      </div>
      


    </body>
    </html>
