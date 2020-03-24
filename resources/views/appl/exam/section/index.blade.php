@extends('layouts.app')
@section('title', 'Sections - '.$exam->name)
@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{ $exam->name }}</a></li>
    <li class="breadcrumb-item">Sections</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Sections </a>

          <form class="form-inline" method="GET" action="{{ route('sections.index',$exam->slug) }}">

            @can('create',$exam)
            <a href="{{route('sections.create',$exam->slug)}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Create Section</button>
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
         @include('appl.exam.section.list')
       </div>

     </div>
   </div>
 </div>

 <div class="col-md-3 pl-md-0">
      @include('appl.exam.snippets.menu')
    </div>
</div>

@endsection


