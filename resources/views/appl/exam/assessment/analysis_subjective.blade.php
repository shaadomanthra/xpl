@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')


@if(auth::user()->checkRole(['hr-manager','admin']))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}?student={{request()->get('student')}}">{{ ucfirst($exam->name) }} - Analysis </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.solutions',$exam->slug)}}?student={{request()->get('student')}}">Solutions</a> </li>
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
			<div class="display-4">{{ $test_overall->score }} </div>
			@else
			<div class="badge badge-primary px-2" style="line-height: 1.4">Under<br>Review</div>
			@endif
		</div>
		<div class="  display-4  mb-3 d-none d-md-block"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
			
		</p>
		</div>




  <div class="card mb-3"  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
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


	<div class="table-responsive">
		<table class="table table-bordered bg-white">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Response</th>
      @if(!$test_overall->status)
      <th scope="col">Score</th>
      <th scope="col">Feedback</th>
      @endif
    </tr>
  </thead>
  <tbody>
  	@foreach($tests as $k=>$t)

    <tr>
      <th scope="row">{{($k+1)}}</th>
      <td>{!! $questions[$t->question_id]->question !!}</td>
      <td>
      	@if($questions[$t->question_id]->type=='urq')
          <div class="">

          @if(isset($questions[$t->question_id]->images))

          @foreach(array_reverse($questions[$t->question_id]->images) as $k=>$url)

            <a href="#" id="{{$k}}" class="show_image" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" >
             <img src="{{$url }}" style="width:150px;" class="border border-secondary p-1  my-1" />
           </a>
          @endforeach
          @endif
          </div>
        
      	@else
      	{!! $t->response !!}
        @if(!$test_overall->status)
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
      	@endif
      </td>
      @if(!$test_overall->status)
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
      @endif
    </tr>
    @endforeach
  </tbody>
</table>

	</div>

  @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
    <div class="card bg-light"  style="background: #FFF;border: 2px solid #EEE;">
      <div class="card-header">
        Cheating Detection
      </div>
      <div class="card-body">
      <div class="row mb-4">
        <div class="col-12 col-md-4">
          <div class="p-3 border rounded" height="">
            <h5>Window Swap</h5>
            <div class="display-4">
              @if($test_overall->window_change)
              {{$test_overall->window_change}}
              @else
              -
            @endif</div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="p-3 border rounded" height="">
            <h5>Detected Faces</h5>
            <div class="display-4">
            @if($test_overall->face_detect)
              {{$test_overall->face_detect}}
            @else
              -
            @endif</div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="p-3 border rounded" height="">
            <h5>Cheating</h5>
            <div class="display-4">
              @if($test_overall->cheat_detect==2)
              Not Clear
              @elseif($test_overall->cheat_detect==1)
              Potentially Yes
              @else
              Potentially No
              @endif
            </div>
          </div>
        </div>
      </div>
      @if(Storage::disk('s3')->exists('webcam/'.$user->username.'_'.$exam->id.'_1.jpg'))
      <div class="row mb-4">
        @for($i=1;$i<13;$i++)
          @if(Storage::disk('s3')->exists('webcam/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
          <div class='col-6 col-md-2'>
            <img src="{{ Storage::disk('s3')->url('webcam/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
          </div>
          @endif
        @endfor
      </div>
      @if($count)
      <div class="my-4">Captured: {{$count}} images</div>
      <a href="{{ route('assessment.analysis',$exam->slug)}}?images=all&student={{$user->username}}" class="mt-3 btn-success btn-lg">view all images</a>
      @endif
      @endif


    </div>
    </div>
    @endif
    

	

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Image</h1>
      </div>
      <div class="modal-body">
        <div class="canvas">
        
        </div>
      </div>
    </div>
  </div>
</div>



@endsection           