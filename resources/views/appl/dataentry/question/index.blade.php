@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')

<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-comments"></i> Questions</a>

          <form class="form-inline" method="GET" action="{{ route('question.index',$project->slug) }}">
           
           @can('create',$question)
             <div class="btn-group mr-3">
             
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-plus"></i> New
            </button>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('question.create',['project_id'=>$project->slug])}}">Multiple Choice Question</a>
                <a class="dropdown-item" href="{{ route('question.create',['project_id'=>$project->slug,'type'=>'naq'])}}">Numerical Answer Question</a>
                <a class="dropdown-item" href="{{ route('question.create',['project_id'=>$project->slug,'type'=>'maq'])}}">Multi Answer Question</a>
                <a class="dropdown-item" href="{{ route('question.create',['project_id'=>$project->slug,'type'=>'eq'])}}">Explanation Question</a>
              </div>
            </div>
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
         @include('appl.dataentry.question.list')
       </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.menu')

       <div class="list-group  mb-0 mt-3">
    <a href="#" class="list-group-item list-group-item-action list-group-item-light  disabled" >
      <h2 class="mb-0"><i class="fa fa-sliders"></i> Order</h2>
    </a>
    <a href="{{ route('question.index',['project_slug'=>$project->slug,'order'=>'asc','orderby'=>'created_at'])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('created_at') ? 'active' : ''  }}">
      Created At
    </a>

    <a href="{{ route('question.index',['project_slug'=>$project->slug, 'order'=>'asc','orderby'=>'reference'])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('reference') ? 'active' : ''  }}">
      Reference
    </a>
   
  </div>
  </div>
</div>

@endsection


