@extends('layouts.app')
@section('content')

@include('appl.library.snippets.breadcrumbs')
@include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $repo->name }} 

          @can('update',$repo)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('library.edit',$repo->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('library.edit',$repo->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Fork"><i class="fa fa-retweet"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          @if($repo->user_id_data_lead)
          <div class="row mb-2">
            <div class="col-md-4">
              <h1>Data Lead</h1>
            </div>
            <div class="col-md-8">
              <h1>
              <a href="{{ route('profile','@'.auth::user()->getUserName($repo->user_id_data_lead)) }}">
              {{ auth::user()->getName($repo->user_id_data_lead) }}
              </a>
            </h1>
            </div>
          </div>
          @endif

          @if($repo->users)
          <div class="row mb-2">
            <div class="col-md-4">Content Engineers</div>
            <div class="col-md-8">
              @foreach($repo->users as $engineer)
              [<a href="{{ route('profile','@'.$engineer->username) }}">
              {{ $engineer->name }}
              </a>]
              @endforeach
            </div>
          </div>
          @endif
         

          @if($repo->target)
          <div class="row mb-2">
            <div class="col-md-4">Target Date</div>
            <div class="col-md-8">{{ \carbon\carbon::parse($repo->target)->format('M d Y') }}</div>
          </div>
          @endif


          <div class="row mb-0">
            <div class="col-md-4">Project Status</div>
            <div class="col-md-8">
              @if($repo->status==0)
                <span class="badge badge-warning">In Progress</span>
              @else
                <span class="badge badge-success">Completed</span>
              @endif
            </div>
          </div>

          


         
        </div>
      </div>

      


      

    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.library.snippets.menu')
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
        
        <form method="post" action="{{route('library.destroy',$repo->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection