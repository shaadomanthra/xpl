@extends('layouts.app')

@section('title', $course->name.' - Campus Course| PacketPrep')
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
	  				<img class=" w-100 mt-2" src="{{ asset('/img/branch.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-11">
	  				
	  					@if($category) 
	  					<div class=" display-3">{{ $category->name }}</div>
	  					<div class=" display-5  mb-3" ><b>Course </b>: {{ $course->name }}</div>
	  					@else
	  					<div class=" display-3">{{ $course->name }}</div>
	  					@endif
	  				
	  				<div class="">{{ $college->name }}</div>
	  				<div class="custom-control custom-switch ">
				  <input type="checkbox" class="custom-control-input batch" id="customSwitch1" name="batch" @if(request()->get('batch')) checked @endif>
				  <label class="custom-control-label" for="customSwitch1">Batch Mode</label>
				</div>
	  			</div>
	  		</div>
	  </div>

	  <div class="analytics">
	  	@include('appl.college.campus.course_analytics')
	  </div>
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


