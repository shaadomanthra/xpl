@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@if($exam->slug != 'proficiency-test')
<nav aria-label="breadcrumb" class="mt-3">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Report </li>
  </ol>
</nav>
@else
<nav aria-label="breadcrumb" class="mt-3">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proficiency_test') }}">Proficiency Test</a></li>
    <li class="breadcrumb-item">Analysis  </li>
  </ol>
</nav>
@endif


<div class="mb-md-2">
	<div class="">
		<div class="p-3 border rounded bg-light mb-3" style="min-height: 130px">
		<div class="bg-white p-3 float-right text-center border"><h5>Total Score</h5>
			@if($details['marks'])
			<div class="display-4">{{ $details['marks']}} / {{ $details['total'] }} </div>
			@else
			<div class="badge badge-primary px-2" style="line-height: 1.4">Under<br>Review</div>
			@endif
		</div>
		<div class="  display-4  mb-3 d-none d-md-block"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
			
		</p>
		</div>


	
	<div class="table-responsive">
		<table class="table table-bordered bg-white">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Response</th>
      <th scope="col">Score</th>
      <th scope="col">Feedback</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($tests as $k=>$t)
    <tr>
      <th scope="row">{{($k+1)}}</th>
      <td>{!! $questions[$t->question_id]->question !!}</td>
      <td>
      	@if($questions[$t->question_id]->type=='urq')
     
        @if(Storage::disk('s3')->exists('urq/'.$exam->slug.'_'.$student->id.'_'.$questions[$t->question_id]->id.'.jpg'))
          <div class="">
          <img src="{{ Storage::disk('s3')->url('urq/'.$exam->slug.'_'.$student->id.'_'.$questions[$t->question_id]->id.'.jpg')}}" style="max-width:150px" class="border border-secondary" />
        </div>
        @else
          <div class="alert alert-warning alert-important mb-0" role="alert">
			  User has not uploaded the response image.
			</div>
        @endif
      	@else
      	{!! $questions[$t->question_id]->response !!}
      	@endif
      </td>
      <td>
      	@if($t->mark)
      			{{$t->mark }}
      	@else
      		<span class="badge badge-warning">Under Review</span>
      	@endif
      </td>
      <td>{{ ($t->comment)?$t->comment:'-' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

	</div>
	

</div>



@endsection           