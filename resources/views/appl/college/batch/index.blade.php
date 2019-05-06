@extends('layouts.app')
@section('title', 'Campus Batches | PacketPrep')
@section('description', 'This page lists the batches in the college campus')
@section('keywords', 'college,packetprep,campus connect')
@section('content')



@include('flash::message')

<div  class="row ">

  <div class="col-12 col-md-10">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/campus')}}">Campus</a></li>
    <li class="breadcrumb-item">Batches</li>
  </ol>
</nav>
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Batches </a>

          <form class="form-inline" method="GET" action="{{ route($app->module.'.index') }}">

            @can('create',$obj)
            <a href="{{route($app->module.'.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Create {{ ucfirst($app->module) }}</button>
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

        <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.list')
       </div>

     </div>
   </div>
 </div>

<div class="col-12 col-md-2 pl-md-0 mb-3">
      @include('appl.college.snippets.menu')

    </div>

</div>

@endsection


