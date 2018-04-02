@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item "><a href="{{ route('job.index')}}">Jobs</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      {{ $job->title }}
    </li>
  </ol>
</nav>

  @include('flash::message')

  <div class="row ">

    <div class="col-md-12">
      <div class="card  ">
        <div class="card-body ">
          
          <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-black-tie"></i> {{ $job->title }}
            </a>
        </nav>

        <div class="mb-4 p-2">
          {!! $job->content !!}
        </div>

        @if($job->status==0)
        <a href="{{ route('form.create',['job'=>$job->slug])}}">
         <button class="btn btn-lg btn-outline-success mb-4"> Apply </button>
       </a>
       @endif
         <br>

        <div class="table-responsive ">
          <table class="table table-bordered mb-1">
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>Number of Vacancies</td>
                <td>#{{ $job->vacancy }}</td>
              </tr> 
              <tr>
                <td>Status</td>
                <td> @if($job->status==0) <span class="badge badge-success">Open</span> @else <span class="badge badge-warning">Closed</span> @endif</td>
              </tr> 
              <tr>
                <td>Created On</td>
                <td>{{ \carbon\carbon::parse($job->created_at)->format('M d Y') }}</td>
              </tr> 
            </tbody>
          </table>
        </div>

       
        
        @can('update',$job)
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              <a href="{{ route('job.edit',['job_id'=>$job->id]) }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              
              <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
        @endcan
        </div>
      </div>


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
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        This following action will delete the node and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('job.destroy',['job_id'=>$job->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection