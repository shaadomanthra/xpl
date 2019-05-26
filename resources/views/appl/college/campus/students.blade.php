@extends('layouts.app')
@section('title', 'Campus Students | PacketPrep')
@section('description', 'This page for listing students under campus')
@section('keywords', 'college,packetprep,campus connect')
@section('content')



@include('flash::message')

  <div class="row">

  	 <div class="col-12 col-md-2">
     	<div class=" bg-success mb-3 text-white rounded"><div class="p-3 font-weight-bold">Branches</div>
     	<div class="list-group ">
     		<a href="{{ url()->current()}}" class="list-group-item list-group-item-action list-group-item-success {{ (request()->get('branch')) ? '' : 'active'}}">
				 All ({{$branches->total}})
			</a>
     		@foreach($college->branches()->orderBy('id')->get() as $branch)
			<a href="{{ url()->current()}}?branch={{$branch->name}}" class="list-group-item list-group-item-action list-group-item-success {{ (request()->get('branch')==$branch->name) ? 'active' : ''}}">
				 {{ $branch->name }} ({{ isset($branches[$branch->id]) ? count($branches[$branch->id]) : '0'}})
			</a>
			@endforeach
		</div>
		</div>
     </div>

    <div class="col-12 col-md-8 pl-md-0">

    	<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/campus/admin')}}">Admin</a></li>
    <li class="breadcrumb-item">Students</li>
  </ol>
</nav>
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"> <i class="fa fa-users "></i> 
            @if(!request()->get('branch')) 
              All Students <a href="{{ route('campus.admin')}}"><button class="btn btn-outline-secondary float-right"><i class="fa fa-bar-chart"></i> Analytics</button></a>
            @else 
              {{ request()->get('branch')}}  <a href="{{ route('campus.admin')}}?branch={{request()->get('branch')}}"><button class="btn btn-outline-secondary float-right"><i class="fa fa-bar-chart"></i> Analytics</button></a>
            @endif 
            ({{$total}})

            <form class="form-inline mt-3 float-right" method="GET" action="{{ route('campus.students') }}">
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
          </p>
        </div>
      </div>

      <div id="search-items">
    @include('appl.college.campus.list_students')
    </div>


    </div>

     <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>

  </div> 







@endsection