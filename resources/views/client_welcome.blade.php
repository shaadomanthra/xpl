<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{request()->session()->get('client')->name}}</title>
  <meta name="description" content="An advanced assessments platform designed and developed by an expert team.">
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
   @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
      <link rel="shortcut icon" href="{{asset('/favicon_hs.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xplore.in.net' )
    <link rel="shortcut icon" href="{{asset('/favicon_xplore.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || domain() == 'piofx' || $_SERVER['HTTP_HOST'] == 'piofx.in')
    <link rel="shortcut icon" href="{{asset('/favicon_piofx.ico')}}" />
  @elseif($_SERVER['HTTP_HOST'] == 'gradable.test' || env('APP_NAME') =='Gradable')
    <link rel="shortcut icon" href="{{asset('/favicon_gradable.ico')}}" />
  @else
     <link rel="shortcut icon" href="{{asset('/favicon_client.ico')}}" />
  @endif
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">

        
        <div class="col-sm-6 login-section-wrapper ">
          <div class="brand-wrapper">
            <img  src="{{ request()->session()->get('client')->logo }} "  class="ml-md-0 w-50 mb-5"  alt=" logo " type="image/png" style="">
          </div>
          @if(request()->session()->get('settings'))
            @if(request()->session()->get('settings')->message_l)
              <div class="alert alert-warning alert-important mt-3">
                <div class=" h5 mt-2">{{request()->session()->get('settings')->message_l}}</div>
                @if(request()->session()->get('settings')->timer_l)
                 <p id="d" class="my-2 text-danger blink countdown_timer" data-timer="{{request()->session()->get('settings')->timer_l}}"></p>
                @endif
              </div>
            @endif
          @endif
          
          <div class=" my-auto">
             @include('auth.pages.login')
             <div class="mt-5">
              <div class="p-2"></div>
             <hr >
             Incase of any query you can reach out to our resource person, details in the <a href="{{ route('contactpage')}}">contact page</a>
           </div>
          </div>
        </div>
       
       
        <div class="col-sm-6 px-0 d-none d-sm-block">
          @if(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_header.png'))
          <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_header.png')}}?time={{ microtime()}}" alt="login image" class="login-img" />
          @elseif(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_header.jpg'))
          <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_header.jpg')}}?time={{ microtime()}}" alt="login image" class="login-img" />
          @else

            @if(domain()=='piofx')
            <img src="{{ asset('img/bg_login_piofx.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @elseif(domain()=='gradable')
            <img src="{{ asset('img/bg_login_gradable.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @else
            <img src="{{ asset('img/bg_login.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @endif
          @endif
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="{{ asset('js/client.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php session()->put( 'redirect.url',request()->url().'/dashboard'); ?>