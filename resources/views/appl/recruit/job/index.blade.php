@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    @if(!auth::guest()) <li class="breadcrumb-item"><a href="{{ route('recruit') }}">Recruit</a></li> @endif
    <li class="breadcrumb-item active" aria-current="page">Jobs</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-12 col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-arrow-circle-right"></i> Jobs </a>

          <form class="form-inline" method="GET" action="">
            
            @can('update',$job)
            <a href="{{route('job.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Post Job</button>
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
         @include('appl.recruit.job.list')
       </div>

     </div>
   </div>
 </div>
 <div class="col-12 col-md-3">
  <ul class="list-group">
  <a href="#" class="list-group-item list-group-item-action active">Latest</a>
  <a href="#" class="list-group-item list-group-item-action ">Open</a>
  <a href="#" class="list-group-item list-group-item-action ">Closed</a>
</ul>
 </div>
</div>

@endsection


