@extends('layouts.app')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $project->name }} 

            

            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('dataentry.edit',$project->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('dataentry.edit',$project->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Fork"><i class="fa fa-retweet"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          @if($project->user_id_data_lead)
          <div class="row mb-2">
            <div class="col-md-4">Data Lead</div>
            <div class="col-md-8">
              <a href="{{ route('profile','@'.auth::user()->getUserName($project->user_id_data_lead)) }}">
              {{ auth::user()->getName($project->user_id_data_lead) }}
              </a>
            </div>
          </div>
          @endif

          @if($project->user_id_feeder)
          <div class="row mb-2">
            <div class="col-md-4">Data Feeder</div>
            <div class="col-md-8">
              <a href="{{ route('profile','@'.auth::user()->getUserName($project->user_id_feeder)) }}">
                {{ auth::user()->getName($project->user_id_feeder) }}
              </a>
            </div>
          </div>
          @endif

          @if($project->target)
          <div class="row mb-2">
            <div class="col-md-4">Target Date</div>
            <div class="col-md-8">{{ \carbon\carbon::parse($project->target)->format('M d Y') }}</div>
          </div>
          @endif


          <div class="row mb-0">
            <div class="col-md-4">Project Status</div>
            <div class="col-md-8">
              @if($project->status==0)
                <span class="badge badge-warning">In Progress</span>
              @else
                <span class="badge badge-success">Completed</span>
              @endif
            </div>
          </div>

          


         
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="card bg-light">
            <div class="card-header text-secondary"><i class="fa fa-minus-square"></i> Drafts</div>
            <div class="card-body"><h1>{{ $details['drafts'] }}</h1></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-light">
            <div class="card-header text-secondary"><i class="fa fa-plus-square"></i> Published</div>
            <div class="card-body"><h1>{{ $details['published'] }}</h1></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-white">
            <div class="card-header text-success"><b><i class="fa fa-check-square"></i> Live</b></div>
            <div class="card-body text-success"><h1>{{ $details['live'] }}</h1></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card bg-white">
            <div class="card-header text-secondary"> Total</div>
            <div class="card-body"><h1>{{ $details['total'] }}</h1></div>
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
        
        <form method="post" action="{{route('dataentry.destroy',$project->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection