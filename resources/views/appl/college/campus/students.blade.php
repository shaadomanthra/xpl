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
     		@foreach($college->branches as $branch)
			<a href="{{ url()->current()}}?branch={{$branch->name}}" class="list-group-item list-group-item-action list-group-item-success {{ (request()->get('branch')==$branch->name) ? 'active' : ''}}">
				 {{ $branch->name }} ({{ count($branches[$branch->id])}})
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
            Students ({{$total}})

          </p>
        </div>
      </div>

     
          @if(count($users))
          <div class="row mb-2">
          @foreach($users as $user)
            <div class="col-12 col-md-4">
              <div class="card mb-3">
              	<div class="card-body">
                <h3>{{ $user->name }}</h3>
                <small>{{ ($user->details()->first()) ? $user->details()->first()->roll_number : '' }}</small><br>
                <small>{{ ($user->branches()->first()) ? $user->branches()->first()->name : '' }}</small><br>
                </div>
                <div class="card-footer">
                @if($user->batches()->first())
	            <span class="btn-group btn-group-sm" role="group" aria-label="Basic example">
	              <a href="" class="btn btn-sm btn-outline-secondary disabled" disabled>{{$user->batches()->first()->name}}</a>
	              @can('manage',$college)
	              <a href="{{ route('batch.detach',$user->batches()->first()->id)}}?user_id={{$user->id}}&url={{ url()->current() }}" class="btn btn-outline-secondary"><i class="fa fa-trash"></i></a>
	              @endcan
	            </span>
                @else
              @can('manage',$college)
             	<div class="dropdown ">
				  <a class="btn btn-sm btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Assign Batch
				  </a>

				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				  	@foreach($college->batches as $batch)
				    <a class="dropdown-item" href="{{ route('batch.attach',$batch->id)}}?user_id={{$user->id}}&url={{ url()->current()}}">{{ $batch->name}}</a>
				    @endforeach
				  </div>
				</div>
              @endcan
              @endif
          </div>
              </div>
            </div>
          @endforeach
          </div>
          <nav aria-label="Page navigation  " class="card-nav @if($users->total() > config('global.no_of_records'))mt-3 @endif mb-3 mb-md-0">
        {{$users->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
          @else
           <div class="card"><div class="card-body"> - No Students -</div></div>
          @endif


    </div>

     <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>

  </div> 







@endsection