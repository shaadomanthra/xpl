@extends('layouts.app')
@section('content')

  @include('appl.library.snippets.breadcrumbs')
  @include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card">
      <div class="card-body mb-0 ">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-tasks"></i> Structures</a>
          @can('create',$struct)
             <div class="btn-group ">
             
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-plus"></i> New
            </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('structure.create',['repo_slug'=>$repo->slug,'type'=>'chapter'])}}">Chapter</a>
                <a class="dropdown-item" href="{{ route('structure.create',['repo_slug'=>$repo->slug,'type'=>'lesson'])}}">Lesson</a>
                <a class="dropdown-item" href="{{ route('structure.create',['repo_slug'=>$repo->slug,'type'=>'concept'])}}">Concept</a>
                <a class="dropdown-item" href="{{ route('structure.create',['repo_slug'=>$repo->slug,'type'=>'variant'])}}">Variant</a>
              </div>
            </div>
          @endcan
          
        </nav>

        <div id="search-items">
          <div class="card mb-3">
            <div class="card-body"> {{ $repo->name }}
              @if($question)
              <a href="{{ route('question.show',[$repo->slug,$question->id]) }}">
              @endif
              <span class="float-right">Questions({{ ($question)?$question->count:'0' }})</span>
              @if($question)
              </a>
              @endif
              </a>
            </div>
          </div>
           @if($nodes)
          <div class="dd">
          {!! $nodes !!}
          </div>
          @else
          @endif
       </div>

     </div>

      
    </div>
  </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.library.snippets.menu')
    </div>
    
  </div> 
@endsection