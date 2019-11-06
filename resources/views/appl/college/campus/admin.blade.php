@extends('layouts.app')

@section('title', 'Campus | Xplore')
@section('description', 'Packetprep Campus Page')
@section('keywords', 'packetprep, campus page')


@section('content')

@include('flash::message')
<div  class="row ">
  <div class="col-12 col-md-10">

  	@if(\auth::user()->checkRole(['admin','administrator']))
  	<div class="bg-warning p-3 rounded mb-3">
  		<div class="h3">Session College : {{ request()->session()->get('college')['name'] }}</div>
  		<div class=" mb-3">MyCollege : {{ \auth::user()->colleges()->first()->name }}</div>
  		<a href="{{ route('campus.admin')}}?college={{ request()->get('college')}}&set_college=true">
  			<button class="btn btn-outline-dark">Add College</button></a>
  		<a href="{{ route('campus.admin')}}?college={{ request()->get('college')}}&unset_college=true">
  			<button class="btn btn-outline-dark">Remove College</button></a>
  		<a href="{{ route('college.show',$college->id)}}">
  			<button class="btn btn-outline-dark">View College</button></a>
  	</div>
  	@endif
  	<!-- College Header-->
  	@if($batch)
	  <div class="w-100  rounded p-4 " style="background: rgb(242, 237, 218);border :1px solid rgb(216, 209, 182);">
	  		<div class="row">
	  			<div class="col-12 col-md-1">
	  				<img class=" w-100 mt-2" src="{{ asset('/img/batch/'.$batch->image.'.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-11">
	  				<div class=" display-3  " >{{ $batch->name }} <a href="{{ route('batch.show',$batch->slug)}}"><button class="btn btn-outline-secondary float-right"><i class="fa fa-user"></i> Students</button></a></div>
	  				<div class="">{{ $college->name }}</div>
	  			</div>
	  		</div>
	  </div>
	 @elseif($branch)
	 <div class="w-100  rounded p-4 " style="background: rgb(242, 237, 218);border :1px solid rgb(216, 209, 182);">
	  		<div class="row">
	  			<div class="col-12 col-md-1">
	  				<img class=" w-100 mt-2" src="{{ asset('/img/branch.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-11">
	  				<div class=" display-3 mt-0 " >{{ $branch->name }} <a href="{{ route('campus.students')}}?branch={{$branch->name}}"><button class="btn btn-outline-secondary float-right"><i class="fa fa-user"></i> Students</button></a></div>
	  				<div class="">{{ $college->name }}</div>
	  			</div>
	  		</div>
	  </div>

	 @else
	  <div class="w-100  rounded p-5 " style="background: rgb(242, 237, 218);border :1px solid rgb(216, 209, 182);">
	  		<div class="row">
	  			<div class="col-12 col-md-2">
	  				<img class=" w-100" src="{{ asset('/img/university.png')}}" >
	  			</div>
	  			<div class="col-12 col-md-10">
	  				<div class=" display-4 ml-4 mt-3 mb-3" >{{ $college->name }}</div>
	  			<div class="custom-control custom-switch ml-4">
				  <input type="checkbox" class="custom-control-input batch" id="customSwitch1" name="batch" @if(request()->get('batch')) checked @endif>
				  <label class="custom-control-label" for="customSwitch1">Batch Mode</label>
				</div>
	  			</div>
	  		</div>
	  </div>
	 @endif

	  <div class="analytics">
	  	@include('appl.college.campus.analytics')
	  </div>
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


