@extends('layouts.app')

@section('title', 'Campus Tests | PacketPrep')
@section('description', 'Packetprep Campus Page')
@section('keywords', 'packetprep, campus page')


@section('content')

@include('flash::message')
<div  class="row ">
  <div class="col-12 col-md-10">
    <nav aria-label="breadcrumb">
	  <ol class="breadcrumb border">
	    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ url('/campus/admin')}}">Admin</a></li>
	    <li class="breadcrumb-item">Tests</li>
	  </ol>
	</nav>

        <nav class="navbar navbar-light bg-light justify-content-between border p-3 bg-white rounded mb-3">
          <a class="navbar-brand"><i class="fa fa-share-square-o"></i> Campus Tests </a>

          <form class="form-inline float-right" method="GET" action="{{ route('campus.tests') }}">

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
	@include('appl.college.campus.list_test')
	</div>
  
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


