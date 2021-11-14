<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->
  <title>@yield('title','Xplore')</title>
  <!-------google font-------->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Quattrocento&display=swap" rel="stylesheet">
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
      <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' )
    <link rel="shortcut icon" href="{{asset('/favicon_xplore.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || domain() == 'piofx' || $_SERVER['HTTP_HOST'] == 'piofx.in')
    <link rel="shortcut icon" href="{{asset('/favicon_piofx.ico')}}" />
  @else
     <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
  @endif

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assetsfront/vendor/font-awesome/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assetsfront/vendor/cubeportfolio/css/cubeportfolio.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assetsfront/vendor/hs-mega-menu/dist/hs-mega-menu.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assetsfront/vendor/dzsparallaxer/dzsparallaxer.css') }}">

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/front.css') }}">
        <!-- CSS Front Template -->
  <link rel="stylesheet" href="{{ asset('assetsfront/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsfront/css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('assetsfront/css/changes.css') }}">


    <link rel="stylesheet" href="{{ asset('assetsfront/vendor/slick-carousel/slick/slick.css') }}">
  

  <!-- CSS Front Template -->
  <style>
    .hero_btn button{
    border: 1.5px solid #e24d4b; color:#e24d4b;
    }
    .hero_btn button:hover{
      background-color:#e24d4b ;
      color: #ffff;
    }
  </style>
</head>

<body>