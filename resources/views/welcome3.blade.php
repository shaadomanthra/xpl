@extends('layouts.app2')

@section('title', 'PacketPrep - Prepare for Campus Placements, Bank Exams and Government Jobs')

@section('description', 'PacketPrep is an online video learning preparation platform for quantitative aptitude, logical reasoning, mental ability, general english and interview skills.')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')

<div class="" style="background: #d5ebff57;border-bottom: 1px solid #c1d9ef">
<div class="container  pt-3">
	<div class="row " >
			<div class="col-12 col-md-8">
				<div class="pt-5 p-0 p-md-0 pt-md-5 " >
    <h2 class="h3 pl-4" style="font-family: Verdana">Prepare for </h2>
    <h1 class="h1 mt-2 mb-3 text-primary pl-4" style="font-family: Verdana;font-weight: 800">Campus Placements</h1>
    <h2 class=" mb-5 pl-4" style="line-height: 30px;">Bank Exams and Government Jobs</h2>
    <div class="pl-4 mb-5"><a href="{{ route('register.type')}}"><button class="btn btn-outline-primary btn-lg ">Register Now</button></a></div>
	</div>
			</div>
			<div class="col-4">
				<div class="float-right d-none d-md-block">
                <img src="{{ asset('/img/pp.png')}}" class="w-100 p-3 pt-0"/>
                
      </div>
			</div>
	</div>
	
</div>
</div>

<div class="bg-white mt-4">sample</div>

<p id="demo"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("May 15, 2019 09:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>  


@endsection    


