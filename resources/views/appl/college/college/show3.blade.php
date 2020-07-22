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
          <p class="h2 "><i class="fa fa-th "></i> {{ $obj->name }} 
            @can('update',$obj)
          
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route($app->module.'.edit',$obj->id) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
              <a href="{{ route('college.view',$obj->id) }}" class="btn btn-outline-secondary"  ><i class="fa fa-bars"></i> College</a>
              <a href="{{ route($app->module.'.userlist',$obj->id) }}" class="btn btn-outline-secondary"  ><i class="fa fa-bars"></i> User List</a>
              <a href="{{ route('campus.admin') }}?college={{$obj->id}}" class="btn btn-outline-secondary"  ><i class="fa fa-bar-chart"></i> Analytics</a>
            </span>
            @endcan


          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
         


          <div class="row">
            @foreach($branches as $branch)
            <div class="col-12 col-md-2">
              <div class="border rounded p-3 mb-3">
                <h5>{{strtoupper($branch->name)}}</h5>
                <div class="display-3">
                  @if(isset($data['branches'][$branch->id]))
                    {{ count($data['branches'][$branch->id]) }}
                  @else
                    -
                  @endif
                  </div>
              </div>
            </div>
            @endforeach
          </div> 

          

        </div>
      </div>

    </div>

     

  </div> 




@endsection