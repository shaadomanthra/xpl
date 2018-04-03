@extends('layouts.app')

@section('content')

<div class="jumbotron bg-white border">

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
		  	
		  	<a class="btn border border-primary btn-lg" href="{{ route('job.index') }}" role="button">Apply Now</a>
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

@if(auth::user())
  	<div class="row">
  		<div class="col-md-2">
  			<div class="card text-center mb-3">
  				<a href="{{route('update.index')}}">
  				<div class="card-body">
  					<i class="fa fa-bullhorn fa-2x"></i><br>Updates
  				</div>
  				</a>
  			</div>

  			<div class="card text-center mb-3">
  				<a href="{{route('dataentry.index')}}">
  				<div class="card-body">
  					<i class="fa fas fa-inbox fa-2x"></i><br>Dataentry
  				</div>
  				</a>
  			</div>

  			<div class="card text-center mb-3">
  				<a href="{{route('blog.index')}}">
  				<div class="card-body">
  					<i class="fa fa-align-justify fa-2x"></i><br>Blog
  				</div>
  				</a>
  			</div>

  		</div>
  		<div class="col-md-2">
  			<div class="card text-center mb-3">
  				<a href="{{route('report.index')}}">
  				<div class="card-body">
  					<i class="fa fas fa-align-right fa-2x"></i><br>Reports
  				</div>
  				</a>
  			</div>

  			<div class="card text-center mb-3">
  				<a href="{{route('library.index')}}">
  				<div class="card-body">
  					<i class="fa fas fa-university fa-2x"></i><br>Library
  				</div>
  				</a>
  			</div>
  			<div class="card text-center mb-3">
  				<a href="{{route('media.index')}}">
  				<div class="card-body">
  					<i class="fa fa-camera-retro fa-2x"></i><br>Social 
  				</div>
  				</a>
  			</div>
  		</div>
  		<div class="col-md-8">
  			<div class="card mb-3">
		      <div class="card-body ">
		        <div class="row no-gutter">
		          <div class="col-6">
		           <h2>Vision</h2> 
		           <p class="mb-0">
		            To create a world-class learning platform for self study
		           </p>
		         </div>
		         <div class="col-6">
		          <h2>Mission</h2> 
		           <p class="mb-0">
		            To develop comprehensive content that makes learning simple, interesting and effective. 
		           </p>

		         </div>
		       </div>
		     </div>
		   </div>

		    <div class="card mb-3">
		      <div class="card-body bg-success text-white">
		        <h2><b>Goals</b></h2>
		        <p class="mb-0 pb-0">
		          <ol class="mb-0 pb-0">
		            @if(isset($goals))
		            @foreach($goals as $goal)
		            <li>{{ $goal->title }} <span class="s15 " style="color:rgb(37, 128, 102)">by {{\carbon\carbon::parse($goal->end_at)->format('M d Y')}}</span></li>
		            @endforeach
		            @endif
		          </ol>
		        </p>
		     </div>
		   </div>

		   <div class="card mb-3 mb-md-0">
		      <div class="card-body ">
		        <h2>Core Values</h2>
		        <p class="mb-0 pb-0">
		          <ol class="mb-0 pb-0">
		            <li>Passion driven</li>
		            <li>Creative Mindset</li>
		            <li>Original content</li>
		            <li>Empower learners</li>
		            <li>Student centric</li>
		          </ol>
		        </p>
		     </div>
		   </div>   
  		</div>
  	</div>
             
@endif

</div>
@endsection           