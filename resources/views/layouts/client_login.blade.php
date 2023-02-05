<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{(request()->session()->get('client'))?request()->session()->get('client')->name: domain()}}</title>
  <meta name="description" content="An advanced assessments platform designed and developed by an expert team.">
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
 
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
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="brand-wrapper">
            <img 
        src="{{ (request()->session()->get('client'))?request()->session()->get('client')->logo:'https://xplore.co.in/img/xplore.png' }} " width="200px" class="ml-md-0"  alt="Logo " type="image/png">
          </div>
          <div class="login-wrapper my-auto">
             @yield('content')
          </div>
        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          @if(isset(request()->session()->get('client')->slug))
              @if(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_header.png'))
              <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_header.png')}}?time={{ microtime()}}" alt="login image" class="login-img" />
              @elseif(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_header.jpg'))
              <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_header.jpg')}}?time={{ microtime()}}" alt="login image" class="login-img" />
              @else
                 @if(domain()=='piofx')
                <img src="{{ asset('img/bg_login_piofx.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
                @elseif(domain()=='myparakh')
            <img src="{{ asset('img/bg_login_piofx.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
                @else
                <img src="{{ asset('img/bg_login.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
                @endif
              @endif
          @else
            @if(domain()=='piofx')
            <img src="{{ asset('img/bg_login_piofx.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @elseif(domain()=='myparakh')
            <img src="{{ asset('img/bg_login_piofx.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @else
            <img src="{{ asset('img/bg_login.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
            @endif
          @endif
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>


 