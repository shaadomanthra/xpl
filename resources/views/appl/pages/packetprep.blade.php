@extends('layouts.app')

@section('content')

<img src="{{ asset('img/about_cover.jpg')}}" class="w-100"/>

<div class="bg-white">

	<div class="card-body p-4 ">
		<h1 class="display-2 mt-3 text-center ">Mission </h1>
		<p class="lead p-3 text-center">
		  To develop comprehensive content that makes learning <br>simple, interesting and effective. 
		</p>

		<h1 class="display-4 mt-3 text-center ">About </h1>
		<div class="p-3 pr-md-5 pb-5 pl-md-5">
		<p class="text-center ">At Packetprep, we all come to work every day because we want to make learning super simple, interesting and effective. And we chose video as the right medium to connect to the learners. </p>
		<p class="text-center">Here at Packetprep, we produce visually appealing, crisp content driven educational videos for competitive exams like GATE, GRE, CAT, JEE, NEET etc. To make the learning effective and comprehensive, we also develop support material like study notes, worksheets, practice questions and mock tests.</p>
		</div>
		
		</div>
	</div>
	@endsection           