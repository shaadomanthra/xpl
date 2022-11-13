@extends('layouts.app')
@section('title', $obj->name.'  College')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route($app->module.'.index') }}">{{ ucfirst($app->module) }}</a></li>
    <li class="breadcrumb-item">{{ $obj->name }}</li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-md-12">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-3"><i class="fa fa-th "></i> {{ $obj->name }} 


          
          @can('update',$obj)
          
            <span class="btn-group float-md-right" role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->id) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              <a href="{{ route($app->module.'.userlist',$obj->id) }}" class="btn btn-outline-secondary"  ><i class="fa fa-bars"></i> User List</a>
            </span>
            @endcan
            </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
         
          <div class="row mb-2">
            <div class="col-12 col-md-2">Location</div>
            <div class="col-12 col-md-10">{{$obj->location}}</div>
          </div>

           <div class="row mb-2">
            <div class="col-12 col-md-2">Zone</div>
            <div class="col-12 col-md-10">{{$obj->college_website}}</div>
          </div> 
           <div class="row mb-2">
            <div class="col-12 col-md-2">College Code</div>
            <div class="col-12 col-md-10">{{$obj->college_code}}</div>
          </div> 
           <div class="row mb-2">
            <div class="col-12 col-md-2">Type</div>
            <div class="col-12 col-md-10">{{$obj->type}}</div>
          </div> 
           <div class="row mb-2">
            <div class="col-12 col-md-2">User Count</div>
            <div class="col-12 col-md-10">{{$user_count}}</div>
          </div> 

          @if($obj->zones->first())
          <div class="row mb-2">
            <div class="col-12 col-md-2">Zone</div>
            <div class="col-12 col-md-10"> {{ $obj->zones->first()->name }}</div>
          </div> 
          @endif

          <div class="row mb-2">
            <div class="col-12 col-md-2">Branches</div>
            <div class="col-12 col-md-10"> 
              @foreach($obj->branches()->orderBy('id')->get() as $branch)
                {{ $branch->name }} &nbsp;
              @endforeach
            </div>
          </div> 

          


        </div>
      </div>


      <div class="row">
        @foreach($users as $y=>$u)
        <div class="col-2">
          <div class="card mb-4">
            <div class="card-body">
              <h3>{{$y}}</h3>
              <a href="{{ route('college.userlist',$obj->id)}}?yop={{$y}}"><div class="display-3">{{count($u)}}</div></a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

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
        This following action is permanent and it cannot be reverted.
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


@endsection