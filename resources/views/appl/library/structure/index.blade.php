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
          <a href="{{route('structure.create',$repo->slug)}}">
              <button type="button" class="btn btn-outline-success float-right"><i class="fa fa-plus"></i> New</button>
            </a>
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