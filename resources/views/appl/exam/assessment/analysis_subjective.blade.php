@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')


@if(auth::user()->checkRole(['hr-manager','admin']))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item">{{$student->name}} - Report </li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.responses',$exam->slug)}}?student={{request()->get('student')}}">Responses</a> </li>
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
    @if($exam->solutions !=4 )
		<div class="bg-white p-3 float-right text-center border"><h5>Total Score</h5>
			@if(!$test_overall->status)
        @if($exam->solutions==2)
        <div class="display-4">Private </div>
        @else
        <div class="display-4">{{ $test_overall->score }} </div>
        @endif
			
			@else
			<div class="badge badge-primary px-2" style="line-height: 1.4">Under<br>Review</div>
			@endif
		</div>
    @endif

    
		<div class="  display-4  mb-1 d-none d-md-block"><b> {{$student->name}} - Report</b></div>
	
   
		<p class="pt-3">Exam : <span class="text-primary">{{ ucfirst($exam->name) }}</span><br>
      
			
		</p>
		</div>






 
@if($exam->solutions ==2 && !request()->get('student'))

  <div class="card mb-3"  style="background: #ffceb8;border: 2px solid #e0a889;color: #b55422;">
    @if($exam->message)
    <div class="card-body">
      {{$exam->message}} 
    </div>
    @else
    <div class="card-body">
      Your responses are recorded for internal evaluation. 
    </div>
    @endif
  </div>

    <div class="table-responsive">
    <table class="table table-bordered bg-white">
  <thead>
    <tr>
      <th scope="col" style="width:5%">Qno</th>
      <th scope="col">Your Response</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($tests as $k=>$t)

    <tr>
      <th scope="row">{{($k+1)}}</th>

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
       
        @endif
      </td>
     
    </tr>
    @endforeach
  </tbody>
</table>

  </div>



  @include('appl.exam.assessment.blocks.banner')

   
@else

@if(trim($test_overall->comment))
<div class="card mb-3 p-3" style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
    <h3>Comments</h3>
    <p>{{$test_overall->comment}}</p>
  </div>  
@endif
	<div class="table-responsive">
		<table class="table table-bordered bg-white">
  <thead>
    <tr>
      <th scope="col" style="width:5%">#</th>
      <th scope="col" style="width:50%">Question</th>
      <th scope="col">Response</th>
      @if(!$test_overall->status)
      @if($exam->solutions !=3 && $exam->solutions !=4 )
      <th scope="col">Score</th>
      @endif
      <th scope="col" style="width:15%">Feedback</th>
      @endif
    </tr>
  </thead>
  <tbody>
  	@foreach($tests as $k=>$t)

    <tr>
      <th scope="row">{{($k+1)}}</th>
      <td class="{{ $question = $questions[$t->question_id]}}">{!! $questions[$t->question_id]->question !!}
         @if($questions[$t->question_id]->type=='mcq')
        <div class="mt-3">
          <div class="row">
            <div class="col-12 col-md-6">
              @if($question->option_a)
          <div class=""><span class=" @if($t->answer=='A') text-success font-weight-bold @endif">(A)</span><div class="pt-1 d-inline "> {!! $question->option_a!!}</div></div>
          @endif
          @if($question->option_b)
          <div class=""><span class=" @if($t->answer=='B') text-success font-weight-bold @endif">(B)</span><div class="pt-1 d-inline "> {!! $question->option_b!!}</div></div>
          @endif

            </div>
            <div class="col-12 col-md-6">
              @if($question->option_c)
          <div class=""><span class=" @if($t->answer=='C') text-success font-weight-bold @endif">(C)</span><div class="pt-1 d-inline "> {!! $question->option_c!!}</div></div>
          @endif
          @if($question->option_d)
          <div class=""><span class=" @if($t->answer=='D') text-success font-weight-bold @endif">(D)</span><div class="pt-1 d-inline "> {!! $question->option_d!!}</div></div>
          @endif
            </div>
          </div>
          
          
          @if($question->option_e)
          <div class=""><span class=" @if($t->answer=='E') text-success font-weight-bold @endif">(E)</span><div class="pt-1 d-inline "> {!! $question->option_e!!}</div></div>
          @endif
        </div>
        @endif
        @if(trim($t->answer))
            <div class=""><hr>Answer: <b class="text-success">{!!$t->answer!!}</b></div>
        @elseif(trim($questions[$t->question_id]->explanation))
            <div class=""><hr>Explanation: {!!$questions[$t->question_id]->explanation!!}</div>
        @else
        @endif
      </td>
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
        @if($test_overall->status)
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
      @if($exam->solutions !=3 && $exam->solutions !=4 )
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
      @endif
      <td>{{ (isset($t->comment))?$t->comment:'-' }}</td>
      @endif

    </tr>
    @endforeach
  </tbody>
</table>

	</div>

  @include('appl.exam.assessment.blocks.cheating')
    
@endif
	

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Image</h1>
      </div>
      <div class="modal-body">
        <div class="canvas d-none">
        
        </div>
        <img src="" class="img_resp w-100"/>
      </div>
    </div>
  </div>
</div>



@endsection           