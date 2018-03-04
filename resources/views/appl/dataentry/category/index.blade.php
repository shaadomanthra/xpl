@extends('layouts.app')
@section('content')

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('data.dataentry.index')}}">Data Entry</a></li>
      <li class="breadcrumb-item " ><a href="{{ route('data.dataentry.show',$project->slug)}}"> {{$project->project_name}}</a> </li>
      <li class="breadcrumb-item active" aria-current="page"> Categories </li>
    </ol>
  </nav>

  @include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card bg-success mb-3">
        <div class="card-body text-white">
          <p class="h2 mb-0"><i class="fa fa-tasks"></i> Categories
             <a href="{{route('project.category.create',$project->slug)}}">

              <button type="button" class="btn btn-outline-light float-right"><i class="fa fa-plus"></i> New</button>

            </a>
          </p>
        </div>
      </div>
      <div class="card mb-3" >
      <div class="card-body">
        @if($nodes)
        <div class="dd">
        {!! $nodes !!}
      </div>
        @else
        No Categories defined !
        @endif
      </div>
      </div>
    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.project.snippets.menu')
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
        
        <form method="post" action="{{route('data.dataentry.destroy','')}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection