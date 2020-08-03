@extends('layouts.app')

@section('content')


<div class="bg-white ">
	<img src="https://xplore.co.in/img/jobs.jpg" class="w-100"></img>
<div class="card-body p-5 text-center demo">

<h1>India's First Virtual Career Fair - Launch</h1>
<p>Gurunanak Institutions in association with Xplore is organizing career fair 2020 for all the graduates and postgraduates. </p>

<button class="btn btn-lg btn-success btn-launch">Launch</button>

<h3 class="text-primary py-3 " style="display:none">Now the candidates can apply for the job openings</h3>


</div>		
</div>

<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset('js/jquery.fireworks.js') }}"></script>
<script>
	$('.demo').fireworks();

</script>

@endsection           