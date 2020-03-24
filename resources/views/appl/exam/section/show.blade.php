@extends('layouts.app')
@section('title', 'Section - '.$exam->name)
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{ $exam->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sections.index',$exam->slug) }}">Sections</a></li>
    <li class="breadcrumb-item">{{ $section->name }}</li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-th "></i> {{ $section->name }} 

          @can('update',$section)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('sections.edit',[$exam->slug,$section->id]) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-4">Mark</div>
            <div class="col-md-8">
              {{ $section->mark}}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Negative</div>
            <div class="col-md-8">
              {{ $section->negative}}
            </div>
          </div>
           <div class="row mb-2">
            <div class="col-md-4">Questions</div>
            <div class="col-md-8">
              {{ count($section->questions)}}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-4">Time</div>
            <div class="col-md-8">
              {{ $section->time}}min
            </div>
          </div>
          
          <div class="row mb-2">
            <div class="col-md-4">Instructions</div>
            <div class="col-md-8">
              {!! $section->instructions !!}
            </div>
          </div>

        
          


         
        </div>
      </div>

 


      

    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.exam.snippets.menu')
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
        
        <form method="post" action="{{route('sections.destroy',[$exam->slug,$section->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection