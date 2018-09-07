@extends('layouts.app')
@section('content')

  @include('appl.dataentry.snippets.breadcrumbs')
  @include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card">
      <div class="card-body mb-0 ">
        
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-tasks"></i> Categories</a>
          @can('create',$category)
          <a href="{{route('category.create',$project->slug)}}">
              <button type="button" class="btn btn-outline-success float-right"><i class="fa fa-plus"></i> New</button>
            </a>
          @endcan
          
        </nav>

        <div id="search-items">
          <div class="card mb-3">
            <div class="card-body"> {{ $project->name }}
              @if($question)
              <a href="{{ route('question.show',[$project->slug,$question->id]) }}">
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
      @include('appl.dataentry.snippets.menu')
    </div>
    
  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('dataentry.destroy','')}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection