@extends('layouts.app')

@section('title', $user->name.' - '.$course->name.' - Campus Course| PacketPrep')
@section('description', 'Packetprep Campus Course Page')
@section('keywords', 'packetprep, campus page')


@section('content')

@include('flash::message')
<div  class="row ">
  <div class="col-12 col-md-10">
  	<!-- Course Header-->
	  <div class="w-100  rounded p-4 " style="background: rgb(242, 237, 218);border :1px solid rgb(216, 209, 182);">
	  		<div class="row">
	  			<div class="col-12 col-md-1">
	  				<img class=" w-100 mt-2" src="{{ asset('/img/user_college.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-11">
	  					<div class="display-3">{{ $user->name }}</div>
	  					@if($category->name != $course->name) 
	  					<div class=" display-5  mb-1" >	
	  						<b>Course </b>: {{ $course->name }} &nbsp; <b>Topic</b> : {{ $category->name }}
	  						
	  					</div>
	  					@else
	  					<div class=" display-5 mb-1"><b> Course</b> : {{ $course->name }}</div>
	  					
	  					@endif
	  				
	  				<div class="mb-1"><b> College</b> : {{ $college->name }}</div>
	  			</div>
	  		</div>
	  </div>

	  <div class="row">

	  	<div class="col-12 col-md-12">
	  		<div class="analytics">
	  	@include('appl.college.campus.course_student_analytics')
	  </div>
	  	</div>

	  </div>
	  
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


