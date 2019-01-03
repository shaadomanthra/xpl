@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item">Exams</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-12 col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-inbox"></i> Exams </a>

          
          <form class="form-inline" method="GET" action="{{ route('exam.index') }}">
            <a href="{{route('exam.create')}}">
              <button type="button" class="btn btn-outline-secondary my-2 my-sm-2 mr-sm-3">Create Loop</button>
            </a>
            <a href="{{route('examtype.index')}}">
              <button type="button" class="btn btn-outline-primary my-2 my-sm-2 mr-sm-3">Examtpyes</button>
            </a>
            @can('create',$exam)
            <a href="{{route('exam.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Create Exam</button>
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
         @include('appl.exam.exam.list')
       </div>

     </div>
   </div>
 </div>
 <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


