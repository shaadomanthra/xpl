@extends('layouts.app')

@section('content')

<div class="jumbotron bg-white">

<div class="row">
	<div class="col-md-8 ">
		@if(auth::user())
		<h2>Hi, {{ auth::user()->name}}</h2>
		<p> Welcome aboard</p>

		 <p class="lead">We are here to make the learning simple, interesting and effective.</p>
		 
		<a class="btn border border-info text-info mt-2" href="{{ route('profile','@'.auth::user()->username) }}"> Profile</a>
		<a class="btn border border-success text-success mt-2" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" role="button">Logout</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
		@else

		<h1 class="display-4">Hello World !</h1>
		  <p class="lead">We are here to make the learning simple, interesting and effective.</p>
		  <hr class="my-4">
		  <p>If you believe in our mission and willing to contribute  then join us...<br> lets build an amazing product.</p>


		  <p class="lead">
		  	
		  	<a class="btn border border-primary btn-lg" href="{{ route('apply') }}" role="button">Apply Now</a>
		    <a class="btn border border-success text-success btn-lg" href="{{ route('login') }}" role="button">Login</a>
		  </p>
		  @endif

	</div>
	<div class="col-md-4">
		<div class="text-center">
		  <img src="{{ asset('/img/puzzle.png')}}" width="200px"/>
		</div>
	</div>
</div>
  </div>


</div>
@endsection           