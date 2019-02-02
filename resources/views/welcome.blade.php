@extends('layouts.plainnew')

@section('title', 'PacketPrep - Prepare for Campus Placements, Bank Exams and Government Jobs')

@section('description', 'PacketPrep is an online video learning preparation platform for quantitative aptitude, logical reasoning, mental ability, general english and interview skills.')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')

<div class="container pt-3">
	<div class="pt-5 p-3 p-md-0 pt-md-5" >
    <h2 class="heading3 text-white " >Prepare for </h2>
    <h1 class="heading1 text-white mt-2 mb-1" >Campus Placements</h1>
    <h2 class="heading2 text-white mb-5" >Bank Exams and Government Jobs</h2>
    <a href="{{ route('register.type')}}"><button class="btn btn-outline-light btn-lg">Register Now</button></a>
	</div>
</div>
@endsection         

