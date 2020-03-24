@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Tests</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-12 col-md">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-inbox"></i> Tests </a>

          
          <form class="form-inline" method="GET" action="{{ route('exam.index') }}">
            
            
            @can('create',$exam)
            <a href="{{route('exam.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Create </button>
            </a>
            @endcan

            @if(\auth::user()->isAdmin())
            <a href="{{route('examtype.index')}}">
              <button type="button" class="btn btn-outline-primary my-2 my-sm-2 mr-sm-3">Testtypes</button>
            </a>
            <a href="{{route('exam.index')}}?refresh=1">
              <button type="button" class="btn btn-secondary my-2 my-sm-2 mr-sm-3">Refresh Cache</button>
            </a>
            @endif
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
         @include('appl.exam.exam.list')
       </div>

     </div>
   </div>
 </div>
 @if(\auth::user()->isAdmin())
 <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
 @endif
</div>

@endsection


