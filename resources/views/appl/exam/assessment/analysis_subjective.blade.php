@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')


@if(auth::user()->checkRole(['hr-manager','admin']))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}">{{ ucfirst($exam->name) }} - Analysis </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.solutions',$exam->slug)}}">Solutions</a> </li>
  </ol>
</nav>
@elseif($exam->slug != 'proficiency-test')
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

			@if(!$test_overall->status)
			<div class="display-4">{{ $details['marks']}} / {{ $details['total'] }} </div>
			@else
			<div class="badge badge-primary px-2" style="line-height: 1.4">Under<br>Review</div>
			@endif
		</div>
		<div class="  display-4  mb-3 d-none d-md-block"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
			
		</p>
		</div>


	@if($exam->solutions ==2)

  <div class="card "  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
    @if($_SERVER['HTTP_HOST'] == 'eamcet.xplore.co.in' )
    <div class="card-body">
      Thank you.You have completed your test and your responses are recorded for internal evaluation.
      Results will be announced tomorrow 20th July 2020.
    </div>
    @else
      <div class="card-body">
      Your responses are recorded for internal evaluation.
    </div>
    @endif
  </div>

  @include('appl.exam.assessment.blocks.banner')

  @else

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
      	{!! $t->response !!}
      	@if($t->accuracy)
      		@if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')

	      		@if(!$t->mark)
	      		<i class="fa fa-times-circle text-danger"></i>
	      		@else
	      		<i class="fa fa-check-circle text-success"></i>
	      		@endif
      		@else
      		<i class="fa fa-check-circle text-success"></i>
      		@endif
      	@else

      		@if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')
      		<i class="fa fa-times-circle text-danger"></i>
      		@else
      			@if($t->mark==0 && $questions[$t->question_id]->type!='urq' && $questions[$t->question_id]->type!='sq')

	      		<i class="fa fa-times-circle text-danger"></i>
	      		@endif
      		@endif
      	@endif
      	@endif
      </td>
      <td>
      	@if($t->mark)
      			{{$t->mark }}
      	@else
      		@if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')
      		0
      		@else
      		@if($t->status!=2)
      			0
      		@else
      		<span class="badge badge-warning">Under Review</span>
      		@endif
      		@endif
      	@endif
      </td>
      <td>{{ (isset($t->comment))?$t->comment:'-' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

	</div>
  @endif
	

</div>



@endsection           