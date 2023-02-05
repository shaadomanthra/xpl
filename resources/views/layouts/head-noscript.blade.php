<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">    
  <meta name="description" content="@yield('description')">
  <meta name="keywords" content="@yield('keywords')">
  <meta name="author" content="Krishna Teja G S">
  <!-- CSRF Token -->
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <!-- Styles -->
  <link href="{{ asset('css/styles.css') }}?new=11" rel="stylesheet">
  @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
      <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />
    @elseif($_SERVER['HTTP_HOST'] == 'myparakh.test' || $_SERVER['HTTP_HOST'] == 'myparakh.com' || env('APP_NAME') =='Gradable')
      <link rel="shortcut icon" href="{{asset('/favicon-parakh.png')}}" />
  @else
     <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
  @endif

</head>
<body>
  @yield('content-main')
 
</body>
</html>
