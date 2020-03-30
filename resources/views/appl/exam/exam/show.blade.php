@extends('layouts.app')
@section('title', 'Test - '.$exam->name)
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
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
          <div>URL : <a href="{{route('assessment.show',$exam->slug)}}">{{route('assessment.show',$exam->slug)}}</a></div>
        </div>
      </div>

       
     
      <div class="card mb-4" style="margin-top: -5px">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-4">Logo</div>
            <div class="col-md-8">
              @if(isset($exam->image))
      @if(Storage::disk('public')->exists($exam->image))
      <div class="mb-3">
      <picture class="">
  <img 
      src="{{ asset('/storage/'.$exam->image) }} " class="d-print-none" alt="{{  $exam->name }}" style='max-width:200px;'>
</picture>
</div>

      @endif
      @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Access Code</div>
            <div class="col-md-8">
              @foreach(explode(',',$exam->code) as $code)
              <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}">{{ $code}} ({{ $exam->getUserCount($code)}})</a> &nbsp;&nbsp;
              @endforeach
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
            <div class="col-md-4">Testtype</div>
            <div class="col-md-8">
              <span class="badge badge-secondary">{{ $exam->examtype->name }}</span>
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
              <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Section</th>
      <th scope="col">Time</th>
      <th scope="col">Mark per ques</th>
      <th scope="col">Negative</th>
    </tr>
  </thead>
  <tbody>
    @foreach($exam->sections as $w=>$section)
    <tr>
      <th scope="row">{{($w+1)}}</th>
      <td><a href="{{ route('sections.show',[$exam->slug,$section->id]) }}">{{$section->name}}({{ count($section->questions)}})</a></td>

      <td>{{ $section->time }} min</td>
      <td>{{$section->mark}}</td>
      <td>@if($section->negative)  -{{ $section->negative}} @else NA @endif</td>
    </tr>
              @endforeach
    
    
  </tbody>
</table>
              
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-4">Report</div>
            <div class="col-md-8">
              @if($exam->solutions==1)
                <span class="badge badge-warning">No solutions</span>
              @elseif($exam->solutions==2)
              <span class="badge badge-warning">No report</span>
              @else
                <span class="badge badge-primary">Report with solutions</span>
              @endif
            </div>
          </div>


          


          <div class="row mb-0">
            <div class="col-md-4">Exam Status</div>
            <div class="col-md-8">
              @if($exam->status==0)
                <span class="badge badge-warning">Draft</span>
              @elseif($exam->status==1)
                <span class="badge badge-success">Free Access</span>
              @else
                <span class="badge badge-primary">Private</span>
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