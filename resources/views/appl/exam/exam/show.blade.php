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
          <div>URL : <a href="{{route('assessment.show',$exam->slug)}}">{{route('assessment.show',$exam->slug)}}</a> @if($exam->active==1)
                <span class="badge badge-secondary">Inactive</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif</div>
        </div>
      </div>

       
     
      <div class="card mb-4" style="margin-top: -5px">
        <div class="card-body">
          <div class="row mb-2">
            <div class="col-md-3">Logo</div>
            <div class="col-md-9">
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
            <div class="col-md-3">Access Code</div>
            <div class="col-md-9">
              @foreach(explode(',',$exam->code) as $code)
              @if($code)
              <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}">{{ $code}}({{ $exam->getUserCount($code)}})</a>
              @else
              <a href="{{ route('test.report',$exam->slug)}}">Default({{ $exam->getUserCount($code)}})</a>
              @endif &nbsp;&nbsp;
              @endforeach
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-3">Description</div>
            <div class="col-md-9">
              {!! $exam->description !!}
            </div>
          </div>

          @if(isset($exam->examtype->name))
          <div class="row mb-2">
            <div class="col-md-3">Testtype</div>
            <div class="col-md-9">
              <span class="badge badge-info">{{ $exam->examtype->name }}</span>
            </div>
          </div>
            @endif

         

          <div class="row mb-2">
            <div class="col-md-3">Instructions</div>
            <div class="col-md-9">
              {!! $exam->instructions !!}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-3">Sections</div>
            <div class="col-md-9">
              <div class="table-responsive">
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
          </div>

          

          <div class="row mb-2">
            <div class="col-md-3">Report</div>
            <div class="col-md-9">
              @if($exam->solutions==1)
                <span class="badge badge-warning">No solutions</span>
              @elseif($exam->solutions==2)
              <span class="badge badge-warning">No report</span>
              @else
                <span class="badge badge-primary">Report with solutions</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-3">Camera</div>
            <div class="col-md-9">
              @if($exam->camera==1)
                <span class="badge badge-success">Enabled</span>
              @else
                <span class="badge badge-secondary">Disabled</span>
              @endif
            </div>
          </div>


          


          <div class="row mb-0">
            <div class="col-md-3">Exam Status</div>
            <div class="col-md-9">
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

@if($exam->getUserCount())
    <h3 class='mb-4'>Latest Participants ({{$exam->getUserCount()}}) <a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-secondary btn-sm float-right">View all</a></h3>
     <div class="table-responsive">
              <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Score</th>
      <th scope="col">Created</th>
    </tr>
  </thead>
  <tbody>
    @foreach($exam->latestUsers() as $u =>$t)
    <tr>
      <th scope="row">{{($u+1)}}</th>
      <td><a href="{{ route('assessment.analysis',[$exam->slug]) }}?student={{$t->user->username}}">{{$t->user->name}}</a></td>

      <td>@if($t->status) - @else{{ $t->score }} / {{ $t->max }} @endif</td>
      <td>{{$t->created_at->diffforHumans()}}</td>
      
    </tr>
              @endforeach
    
    
  </tbody>
</table>
</div>
@endif
      
  <div class="card">
    <div class="card-body">
      <div class="row mb-3">
            <div class="col-md-3">Test Type</div>
            <div class="col-md-9">
              @if($exam->emails)
              <span class="badge badge-info">Restricted</span>
              @else
              <span class="badge badge-success">Open</span>
              @endif
            </div>
          </div>
      <div class="row">
            <div class="col-md-3">Candidates Emails</div>
            <div class="col-md-9">
              @if($exam->emails)
              {!! nl2br($exam->emails) !!}
              @else
              - None -
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