@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
     <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exams</a></li>
    <li class="breadcrumb-item">{{ $exam->name}}</li>
  </ol>
</nav>

@include('flash::message')

  <div class="row">

    <div class="col-md-9">
      <div class="card bg-light mb-3">
        <div class="card-body text-secondary">
          <p class="h2 mb-0"><i class="fa fa-inbox "></i> {{ $exam->name }} 

          @can('update',$exam)
            <span class="btn-group float-right" role="group" aria-label="Basic example">
              <a href="{{ route('exam.edit',$exam->slug) }}" class="btn btn-outline-secondary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
            @endcan
          </p>
        </div>
      </div>

     
      <div class="card mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-4">Exam slug</div>
            <div class="col-md-8">
              {{ $exam->slug}}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Access Code</div>
            <div class="col-md-8">
              {{ $exam->code}}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Description</div>
            <div class="col-md-8">
              {!! $exam->description !!}
            </div>
          </div>

          @if(isset($exam->examtype->name))
          <div class="row mb-2">
            <div class="col-md-4">Examtype</div>
            <div class="col-md-8">
              {{ $exam->examtype->name }}
            </div>
          </div>
            @endif

           @if(isset($exam->course->name))
          <div class="row mb-2">
            <div class="col-md-4">Course</div>
            <div class="col-md-8">
              <i class="fa fa-link"></i> {{ $exam->course->name }}
            </div>
          </div>
            @endif
          <div class="row mb-2">
            <div class="col-md-4">Instructions</div>
            <div class="col-md-8">
              {!! $exam->instructions !!}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Sections</div>
            <div class="col-md-8">
              @foreach($exam->sections as $section)
                <a href="{{ route('sections.show',[$exam->slug,$section->id]) }}">{{ $section->name }} ({{ count($section->questions)}})</a> | {{ $section->time }}min | +{{$section->mark}} @if($section->negative) & -{{ $section->negative}} @endif <br>
              @endforeach
            </div>
          </div>

          


          <div class="row mb-0">
            <div class="col-md-4">Exam Status</div>
            <div class="col-md-8">
              @if($exam->status==0)
                <span class="badge badge-warning">Draft</span>
              @elseif($exam->status==1)
                <span class="badge badge-success">Published</span>
              @else
                <span class="badge badge-primary">Premium</span>
              @endif
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
        
        <form method="post" action="{{route('exam.destroy',$exam->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection