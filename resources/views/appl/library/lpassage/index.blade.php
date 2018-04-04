@extends('layouts.app')
@section('content')

@include('appl.library.snippets.breadcrumbs')
@include('flash::message')
<div  class="row ">
  <div class="col-md-9"> 
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-clipboard"></i> Passages</a>

          <form class="form-inline" method="GET" action="{{ route('dataentry.index') }}">
            @can('create',$lpassage)
            <a href="{{route('lpassage.create',$repo->slug)}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3"><i class="fa fa-plus"></i> New</button>
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
         @include('appl.library.lpassage.list')
       </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.library.snippets.menu')
  </div>
</div>

@endsection


