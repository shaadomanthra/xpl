@extends('layouts.app')
@section('title',' Colleges ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($app->module) }}</li>
  </ol>
</nav>

@include('flash::message')


<div  class="row ">

  <div class="col-12 col-md-10">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Colleges @if(request()->get('zone')) ({{request()->get('zone')}}) @else (All) @endif </a>

          <form class="form-inline" method="GET" action="{{ route($app->module.'.index') }}">

            @can('create',$obj)
            <a href="{{route($app->module.'.create')}}">
              <button type="button" class="btn btn-success my-2 my-sm-2 mr-sm-3">Create {{ ucfirst($app->module) }}</button>
            </a>
            @endcan
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

        <div class="row mb-3">
          <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body">
                  <h4>College Count</h4>
                  <div class="display-3">{{$objs->total()}}</div>
                </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body">
                  <h4>Engineering</h4>
                  <div class="display-3">{{$data['engineering']}}</div>
                </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body">
                  <h4>Degree</h4>
                  <div class="display-3">{{$data['degree']}}</div>
                </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card">
                <div class="card-body">
                  <h4>Users (2023)</h4>
                  <div class="display-3">{{$data['users']}}</div>
                </div>
            </div>
          </div>
        </div>

        <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.list')
       </div>

     </div>
   </div>
 </div>
 <div class="col-12 col-md-2 pl-md-0 mb-3">
      
      <h3 class="mb-4 bg-light border p-3">Zones</h3>
      <div class="list-group">
  <a href="{{ route('college.index')}}" class="list-group-item list-group-item-action @if(!request()->get('zone'))active @endif">
    All
  </a>
  @foreach($zones as $zone)
  @if($zone->college_website)
  <a href="{{ route('college.index')}}?zone={{$zone->college_website}}" class="list-group-item list-group-item-action @if(request()->get('zone')==$zone->college_website)active @endif">{{ucfirst($zone->college_website)}}</a>
  @endif
  @endforeach
</div>
    </div>
</div>

@endsection


