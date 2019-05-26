@extends('layouts.app')

@section('title', 'Campus | PacketPrep')
@section('description', 'Packetprep Campus Page')
@section('keywords', 'packetprep, campus page')


@section('content')

@include('flash::message')
<div  class="row ">
  <div class="col-12 col-md-10">
    <nav aria-label="breadcrumb">
	  <ol class="breadcrumb border">
	    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
	    <li class="breadcrumb-item"><a href="{{ url('/campus')}}">Campus</a></li>
	    <li class="breadcrumb-item">Courses</li>
	  </ol>
	</nav>

        <nav class="navbar navbar-light bg-light justify-content-between border p-3 bg-white rounded mb-3">
          <a class="navbar-brand">
          @if($user)
            <i class="fa fa-user"></i>  {{$user->name }} - Courses 
          @else
            <i class="fa fa-bars"></i>  Campus Courses 
          @endif
          
          </a>

          <form class="form-inline float-right" method="GET" action="{{ route('campus.courses') }}">

            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

	

	<div id="search-items">
	@include('appl.college.campus.list_course')
	</div>
  
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


