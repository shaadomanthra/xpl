

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
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">

        @if($_SERVER['HTTP_HOST'] == 'eamcet.xplore.co.in' )
        <div class="col-sm-6 ">
          <div class="brand-wrapper">
            <img 
        src="{{ request()->session()->get('client')->logo }} "  class="ml-md-0 w-100"  alt=" logo " type="image/png" style="">
          </div>

          <div class="login-section-wrapper my-auto">
            @if($_SERVER['HTTP_HOST'] == 'eamcet.xplore.co.in' || $_SERVER['HTTP_HOST'] == 'www.eamcet.xplore.co.in')
          <div class="alert alert-warning alert-important mt-3">
          <div class=" h4 ">The mock test link will be active on 19th July 2020, 9:00 Am.</div>
          
        <p id="d" class="my-2 text-danger blink"></p>
        </div>
          @endif
             @include('auth.pages.login')
             <div class="mt-5">
              <div class="p-2"></div>
             <hr >
             Incase of any query you can reach out to our resource person, details in the <a href="{{ route('contactpage')}}">contact page</a>
           </div>
          </div>
        </div>
        @else
        <div class="col-sm-6 login-section-wrapper ">
          <div class="brand-wrapper">
            <img 
        src="{{ request()->session()->get('client')->logo }} "  class="ml-md-0 w-100"  alt=" logo " type="image/png" style="">
          </div>
          @if($_SERVER['HTTP_HOST'] == 'vaagdevi.xplore.co.in'  || $_SERVER['HTTP_HOST'] == 'demo.onlinelibrary.test')
          <div class="alert alert-warning alert-important mt-3">
          <div class=" h4 ">We have postponed our 03/07/2020 mock test , as TS government postponed TS EAMCET in the view of this only we have postponed ...third mock test exam date will be announced shortly</div>
          
        </div>
          @elseif($_SERVER['HTTP_HOST'] == 'eamcet.xplore.co.in' || $_SERVER['HTTP_HOST'] == 'www.eamcet.xplore.co.in')
          <div class="alert alert-warning alert-important mt-3">
          <div class=" h4 ">The mock test link will be active on 19th July 2020, 9:00 Am.</div>
          
        <p id="d" class="my-2"></p>
        </div>
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
        @endif
        <div class="col-sm-6 px-0 d-none d-sm-block">
          @if(Storage::disk('public')->exists('companies/'.request()->session()->get('client')->slug.'_header.png'))
              <img src="{{ asset('/storage/companies/'.request()->session()->get('client')->slug.'_header.png')}}?time={{ microtime()}}" alt="login image" class="login-img" />
              @elseif(Storage::disk('public')->exists('companies/'.request()->session()->get('client')->slug.'_header.jpg'))
              <img src="{{ asset('/storage/companies/'.request()->session()->get('client')->slug.'_header.jpg')}}?time={{ microtime()}}" alt="login image" class="login-img" />
              @else
              <img src="{{ asset('img/bg_login.jpg') }}?time={{ microtime()}}" alt="login image" class="login-img">
              @endif
          
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script>
    function blink_text() {
      if($('.blink').length){
        $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
      }
    
}
setInterval(blink_text, 1000);



// Set the date we're counting down to
var countDownDate = new Date("July 19, 2020 09:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;


    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  if(document.getElementById("d"))
  document.getElementById("d").innerHTML = days + "days " + hours + "hours "
  + minutes + "min " + seconds + "sec ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    if(document.getElementById("d"))
    document.getElementById("d").innerHTML = "";
  }
}, 1000);

  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>





 <?php
    session()->put( 'redirect.url',request()->url().'/dashboard');
  ?>
 