@extends('layouts.app')
@section('title', 'Campus Batch| '.$obj->name.' | PacketPrep')
@section('description', 'This page is about campus connect')
@section('keywords', 'college,packetprep,campus connect')
@section('content')



@include('flash::message')

  <div class="row">

    <div class="col-12 col-md-10">

      <nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/campus')}}">Campus</a></li>
    <li class="breadcrumb-item"><a href="{{ route($app->module.'.index') }}">Batches</a></li>
    <li class="breadcrumb-item">{{ $obj->name }}</li>
  </ol>
</nav>

      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0">@if($obj->image) <img src="{{ asset('/img/batch/'.$obj->image.'.png')}}" width="30px"> @else <i class="fa fa-th "></i> @endif
            {{ $obj->name }} ({{count($obj->users)}})

          <button class="btn btn-outline-success float-right ml-3" data-toggle="modal" data-target="#exampleModal2" data-tooltip="tooltip" data-placement="top" title="Join">Join Batch</button>
          @can('update',$obj)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->id) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              <a href="#" class="btn btn-outline-secondary"  title="Code" >CODE : {{$obj->code}}</i></a>
            </span>
            <a href="{{ route('campus.admin')}}?batch_code={{$obj->slug}}"><button class="btn btn-warning float-right mr-2"><i class="fa fa-bar-chart"></i> Analytics</button></a>
            @endcan
          </p>
        </div>
      </div>

     
          @if(count($obj->users))
          <div class="row mb-2">
          @foreach($obj->users as $user)
            <div class="col-12 col-md-3">
              <div class="card mb-3">
                <div class="card-body">
                <h3>{{ $user['name'] }}</h3>
                <small>{{ ($user->details()->first())?$user->details()->first()->roll_number:'' }}</small><br>
              </div>
              <div class="card-footer">
              @can('update',$obj)
              <form method="post" action="{{route($app->module.'.detach',$obj->id)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button class="btn btn-sm btn-outline-danger " type="submit"><i class="fa fa-trash"></i> Remove</button>
              </form>
              @endcan
            </div>
              </div>
            </div>
          @endforeach
          </div>
          @else
           <div class="card"><div class="card-body"> - No Students Added -</div></div>
          @endif


    </div>

    <div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')
    </div>

     

  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted. All the students added to this batch will be detached.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route($app->module.'.destroy',$obj->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{route($app->module.'.attach',$obj->id)}}">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Join Batch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter the Access Code" 
          >
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ \auth::user()->id }}">
          <button type="submit" class="btn btn-primary">Submit</button>
        
      </div>
      </form>
    </div>
  </div>
</div>


@endsection