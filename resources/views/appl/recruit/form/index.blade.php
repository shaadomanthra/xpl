@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('recruit') }}">Recruit</a></li> 
    <li class="breadcrumb-item active" aria-current="page">Forms</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-wpforms"></i> forms </a>

          <form class="form-inline" method="GET" action="">
            
            
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
         @include('appl.recruit.form.list')
       </div>

     </div>
   </div>
 </div>
 <div class="col-md-3">
  <div class="card mb-3 bg-light">
    <div class="card-body">
      <form method="get" action="{{route('form.index')}}">
      <div class="form-group mb-3">
        <label for="formGroupExampleInput ">Job Filter</label>
        <select class="form-control" name="job">
          <option value="0" @if(request()->job==0) selected @endif  >All</option>
          @foreach($jobs as $job)
            <option value="{{ $job->id }}" @if(request()->job==$job->id) selected @endif  >{{$job->title}}</option>
          @endforeach
        </select>
        
      </div>
      <button class="btn btn-outline-primary btn-sm" type="submit">Get Applicants</button>
      </form>
    </div>
  </div>
  <div class="list-group  mb-0">
    <a href="#" class="list-group-item list-group-item-action list-group-item-light  disabled" >
      <h2 class="mb-0"><i class="fa fa-sliders"></i> Filters</h2>
    </a>
    <a href="{{ route('form.index',['all'=>true, 'job'=>request()->job])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('all') ? 'active' : ''  }}">
      All 
    </a>
    <a href="{{ route('form.index',['open'=>true,'job'=>request()->job])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('open') ? 'active' : ''  }} ">Open</a>
    <a href="{{ route('form.index',['accepted'=>true,'job'=>request()->job])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('accepted') ? 'active' : ''  }} ">Accepted</a>
    <a href="{{ route('form.index',['rejected'=>true,'job'=>request()->job])}}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('rejected') ? 'active' : ''  }} ">Rejected</a>
  </div>
 </div>

</div>

@endsection


