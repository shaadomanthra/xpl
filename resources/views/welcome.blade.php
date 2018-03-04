@extends('layouts.app')

@section('content')

<div class="jumbotron bg-white">

<div class="row">
	<div class="col-md-8 ">
		<h1 class="display-4">Hello World !</h1>
		  <p class="lead">We are here to make the learning simple, interesting and effective.</p>
		  <hr class="my-4">
		  <p>If you believe in our mission and willing to contribute  then join us...<br> lets build an amazing product.</p>
		  <p class="lead">
		  	<a class="btn border border-primary btn-lg" href="{{ route('register') }}" role="button">Signup</a>
		    <a class="btn border border-success text-success btn-lg" href="{{ route('login') }}" role="button">Login</a>
		  </p>

	</div>
	<div class="col-md-4">
		<div class="text-center">
		  <img src="{{ asset('/img/puzzle.png')}}" width="200px"/>
		</div>
	</div>
</div>
  </div>
<div class="card bg-light">
	<div class="card-body">
<div class="links">
    <a href="{{url('/about')}}">About</a>
    <a href="{{url('/team')}}">Team</a>
    <a href="{{url('/docs')}}">Docs</a>
    <a href="{{url('/contact')}}">Contact</a>
</div>
</div>
</div>

</div>
@endsection           