@extends('layouts.app')

@section('content')


<div class="bg-white ">
	<img src="https://xplore.co.in/img/jobs.jpg" class="w-100"></img>
<div class="card-body p-5 text-center demo">

<h1>India's First Virtual Career Fair</h1>
<p>Gurunanak Institutions in association with Xplore is organizing career fair 2020 for all the graduates and postgraduates. </p>

<button class="btn btn-lg btn-success btn-launch" id="startConfetti">Launch</button>

<h1 class="text-primary py-3 pt-5 message blink_me" style="display: none">Now the candidates can apply for the job openings</h1>


</div>		
</div>

<style>
	.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset('js/jquery.confetti.js') }}"></script>

<script>
$(function(){
	$(document).on('click','.btn-launch',function(e){
		console.log('clicked');
		$('.message').show();
	});
});

</script>
@endsection           