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
	  				
	  					@if($category->name != $course->name) 
	  					<div class=" display-3">{{ $category->name }}</div>
	  					<div class=" display-5  mb-3" >	
	  						<b>Course </b>: {{ $course->name }}
	  						@if($practice['batch_branch'])
	  							<b class="ml-3">Filter</b> : {{$practice['batch_branch']}}
	  						@endif
	  					</div>
	  					@else
	  					<div class=" display-3 mb-3">{{ $course->name }}</div>
	  					<div class="display-5 mb-3">
	  						@if($practice['batch_branch'])
	  							<b>Filter</b> : {{$practice['batch_branch']}}
	  						@endif
	  					</div>
	  					@endif
	  				
	  				<div class="mb-3">{{ $college->name }}</div>
	  				<div class="custom-control custom-switch ">
				  <input type="checkbox" class="custom-control-input batch" id="customSwitch1" name="batch" @if(request()->get('batch')) checked @endif>
				  <label class="custom-control-label" for="customSwitch1">Batch Mode</label>
				</div>
	  			</div>
	  		</div>
	  </div>

	  <div class="row">
	  	<div class="col-12 col-md-2">
	  		<div class=" mt-4 bg-secondary mb-3 text-white rounded"><div class="p-3 font-weight-bold">
	  			{{ $menu['menu']}}
	  		</div>
	     	<div class="list-group ">
	     		<a href="{{ url()->current()}}@if($menu['name']!='branch'){{'?batch=1'}} @endif" class="list-group-item list-group-item-action list-group-item-secondary {{ (request()->get('branch') || request()->get('batch_code')) ? '' : 'active'}}">
					 All 
				</a>
	     		@foreach($menu['item'] as $item)
				<a href="{{ url()->current()}}?{{$menu['name']}}=@if($menu['name']=='branch'){{$item->name}}@else{{$item->slug.'&batch=1'}}@endif" class="list-group-item list-group-item-action list-group-item-secondary {{ (request()->get($menu['name'])==$item->name ) ? 'active' : ''}} @if($menu['name']!='branch') {{ (request()->get($menu['name'])==$item->slug ) ? 'active' : ''}} @endif">
					 {{ $item->name }} 
				</a>
				@endforeach
			</div>
			</div>
	  	</div>
	  	<div class="col-12 col-md-10">
	  		<div class="analytics">
	  	@include('appl.college.campus.course_analytics')
	  </div>
	  	</div>

	  </div>
	  
  </div>
  <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>
</div>

@endsection


