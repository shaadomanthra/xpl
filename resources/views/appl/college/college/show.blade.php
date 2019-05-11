@extends('layouts.app')
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


          </p>
          @can('update',$obj)
          
            <span class="btn-group " role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->id) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              <a href="{{ route('college.view',$obj->id) }}" class="btn btn-outline-secondary"  ><i class="fa fa-bars"></i> College</a>
              <a href="{{ route($app->module.'.userlist',$obj->id) }}" class="btn btn-outline-secondary"  ><i class="fa fa-bars"></i> User List</a>
            </span>
            @endcan
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          @foreach($obj->getAttributes() as $key=>$item)
          @if($item && $key!='created_at' && $key!= 'updated_at')
          <div class="row mb-2">
            <div class="col-12 col-md-2">{{ strtoupper($key) }}</div>
            <div class="col-12 col-md-10">{{ $item }}</div>
          </div>
          @endif
          @endforeach


          <div class="row mb-2">
            <div class="col-12 col-md-2">Zone</div>
            <div class="col-12 col-md-10"> {{ $obj->zones->first()->name }}</div>
          </div> 

          <div class="row mb-2">
            <div class="col-12 col-md-2">Branches</div>
            <div class="col-12 col-md-10"> 
              @foreach($obj->branches()->orderBy('id')->get() as $branch)
                {{ $branch->name }} &nbsp;
              @endforeach
            </div>
          </div> 

          <div class="row mb-2">
            <div class="col-12 col-md-2">Courses</div>
            <div class="col-12 col-md-10"> 
              <ol>
              @foreach($obj->courses as $course)
                <li>{{ $course->name }} </li>
              @endforeach
            </ol>
            </div>
          </div> 


        </div>
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