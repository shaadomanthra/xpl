@extends('layouts.app')
@section('content')


<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Passage</li>
      </ol>
    </nav>
<div  class="row ">

  <div class="col-md-9">

    
    @include('flash::message')  
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-clipboard"></i> Passages</a>

          <form class="form-inline" method="GET" action="{{ route('dataentry.index') }}">
            <a href="{{route('passage.create',$project->slug)}}">

              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3"><i class="fa fa-plus"></i> New</button>

            </a>
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
         @include('appl.dataentry.passage.list')
       </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.project.snippets.menu')
    </div>
</div>

@endsection


