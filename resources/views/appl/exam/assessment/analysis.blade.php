@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@if($exam->slug != 'proficiency-test')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Analysis </li>
  </ol>
</nav>
@else
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proficiency_test') }}">Proficiency Test</a></li>
    <li class="breadcrumb-item">Analysis  </li>
  </ol>
</nav>
@endif




<div class="mb-md-2">
	<div class="">
		<div class="p-3 border rounded bg-light mb-4">
		<div class="  display-4  mb-3"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
		</p>

		@if(isset($exam->settings->reattempt))
          	@if($exam->settings->reattempt==1)
          		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal2">
							  Retry the test
							</button>
          	@endif
          @endif
          
	</div>

	

	@if($exam->solutions ==2 && !\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))


	<div class="card "  style="background: #ffceb8;border: 2px solid #e0a889;color: #b55422;">
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

	@include('appl.exam.assessment.blocks.banner')

	

	@else




	@if($exam->slug =='psychometric-test' || $typeslug=='psychometric-test')

	<div class="card"  style="background: #FFF;border: 0px solid #EEE;">
		<div class="card-body">
			<div class="mt-2 mb-3">
				@foreach($d as $i=>$j)
				@if($i!=='branches' && $i!='colleges')
				<div class="cc c_{{$i}}">
					<div class="pp p_{{$i}}" style="width:{{($j*2.5)}}%;"></div>
					<div class="content text-left">
						<h3>@if($i=='neuroicism') Emotional Stability @else {{ ucfirst($i)}}@endif <i class="fa fa-question-circle-o" data-toggle="tooltip" title="{{ $m[$i] }}"></i>
							<p class="float-right text-secondary f18">{{($j*2.5)}}%</p>
						</h3>
						<p>@if($j<16){{ $c[$i]['low']}} @elseif($j>15 && $j<27) {{ $c[$i]['mid']}} @else {{ $c[$i]['high']}} @endif</p>

					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>
	</div>
	@elseif($exam->sections[0]->name == 'typing')

	<div class="row">
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #F9FCE5;border: 2px solid #D1D3C5;color: #9D9792;">
					<div class="card-body">
						<div class="text-center">
						<div class="">Performance</div>
						<h1>{{ $details['typing_performance'] }}</h1>
						</div>

					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #E6F5FF;border: 2px solid #B1D2E7;color: #6ea2c3;">
					<div class="card-body">
						<div class="text-center">
						
						<div class="">Net WPM Score</div>
						<h1>{{ $test_overall->score }}</h1>
						</div>

					</div>
				</div>
			</div>

			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #E8FFEF;border: 2px solid #BBDBC5;color: #5B8568;">
					<div class="card-body">
						<div class="text-center">
						
						<div class="">Accuracy</div>
						<h1>{{ $test_overall->incorrect }}%</h1>
						</div>

					</div>
				</div>
			</div>

		</div>

		@include('appl.exam.assessment.blocks.cheating')
		

	@else


		@if($details['evaluation'])
		<div class="row">
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #F9FCE5;border: 2px solid #D1D3C5;color: #9D9792;">
					<div class="card-body">
						<div class="text-center">
						<img src="{{ asset('/img/medals/'.str_replace(' ','',strtolower($details['performance'])).'.png')}}" style="width:120px;"  class="mb-3"/>
						<div class="">Performance</div>
						<h1>{{ $details['performance'] }}</h1>
						</div>

					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="">
					<div class="p-2">
						<canvas id="myChart" width="295" height="228"></canvas>

					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #E8FFEF;border: 2px solid #BBDBC5;color: #5B8568;">
					<div class="">
						<h2> Test Performance</h2>
						<dl class="row">

						  <dt class="col-sm-6">Score </dt>
						  <dd class="col-sm-6">{{ $test_overall->score }} / {{ $test_overall->max  }} </dd>

						  <dt class="col-sm-6">Attempted</dt>
						  <dd class="col-sm-6">{{ $details['attempted']}} /  {{ ($details['unattempted']+$details['attempted'])}} Ques</dd>


						   <dt class="col-sm-6">Correct</dt>
						   <dd class="col-sm-6">{{ $details['correct']}}  Ques</dd>
						   <dt class="col-sm-6">Incorrect</dt>
						   <dd class="col-sm-6">{{ $details['incorrect']}}  Ques</dd>
						   <dt class="col-sm-6">Avg Pace</dt>
						   <dd class="col-sm-6">{{ $details['avgpace']}}  sec</dd>
						   <dt class="col-sm-6">Test Conducted </dt>
						   <dd class="col-sm-6">{{ $details['testdate']}} </dd>
						</dl>

					</div>
				</div>
			</div>
		</div>

		@if($exam->slug != 'proficiency-test')
		@if(!$exam->solutions)
		<div class="card mb-3 "  style="background: #E6F5FF;border: 2px solid #B1D2E7;">
			<div class="card-body">
				<p>
				Test analysis highlights your performance, timespent and accuracy. To improve your performance it is a very important to focus on your mistakes, so do invest some time in analysing your errors. </p>
				<a href="{{route('assessment.solutions',$exam->slug)}}?student={{$student->username}}">
				<button class="btn btn-primary">View Solutions</button>
			</a>
			</div>

		</div>
		@endif
		@endif



		@include('appl.exam.assessment.blocks.banner')


	
		@if(isset($sections))
		<div class="card mb-3 bg-light"  style="background: #FFF;border: 2px solid #EEE;">
			<div class="card-header">
				Section Analysis
			</div>
			<div class="card-body">
			<div class="row">
				@foreach($sections as $sec =>$section)
				@if(isset($section->section_id))
				<div class="col-12 col-md-6">
						<div class="p-2 " height="200px">
						<canvas id="{{$section->section_id}}Container" width="600" height="200px"></canvas>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>
		</div>
		@endif

		
		@include('appl.exam.assessment.blocks.cheating')
		
		

		@if(isset($details['c']))
			<div class="card mt-3"  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
			<div class="card-body">
				<h1> Concept Breakup</h1>
				<p>
				<div class="row">
					<div class="col-12 col-md-4">

						<div class="p-1 mb-3 rounded" style="background: rgba(75, 192, 192, 0.2); border:1px solid rgba(75, 192, 192, 1);">
							Correct ({{$details['correct_time']}})
						</div>

						@if(isset($details['c']))
						@foreach($details['c'] as $m=>$item)
						@if($item['topic'])
						<div class="mb-2">
							<div class="">{{ ucfirst($item['topic']) }} - <span class="text-secondary"> {{ ucfirst($item['section']) }} </span>
							</div>
						</div>
						@endif
						@endforeach
						@else
						<span class="text-secondary">- None -</span>
						@endif
						
					</div>

					<div class="col-12 col-md-4">

						<div class="p-1 mb-3 rounded" style="background: rgba(255, 99, 132, 0.2); border:1px solid rgba(255,99,132,1)">
							Incorrect ({{$details['incorrect_time']}})
						</div>
						@if(isset($details['i']))
						@foreach($details['i'] as $m=>$item)
						@if($item['topic'])
						<div class="mb-2">
							<div class="">{{ ucfirst($item['topic']) }} - <span class="text-secondary"> {{ ucfirst($item['section']) }} </span>
							</div>
						</div>
						@endif
						@endforeach
						@else
						<span class="text-secondary">- None -</span>
						@endif
						
					</div>
					<div class="col-12 col-md-4">

						<div class="p-1 mb-3 rounded" style="background: rgba(255, 206, 86, 0.2); border:1px solid rgba(255, 206, 86, 1)">
							Unattempted ({{$details['unattempted_time']}})
						</div>
						@if(isset($details['u']))
						@foreach($details['u'] as $m=>$item)
						@if($item['topic'])
						<div class="mb-2">
							<div class="">{{ ucfirst($item['topic']) }} - <span class="text-secondary"> {{ ucfirst($item['section']) }} </span>
							</div>
						</div>
						@endif
						@endforeach
						@else
						<span class="text-secondary">- None -</span>
						@endif
						
					</div>

				</div>
			</div>

		</div>
		@endif


		@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
			<div class="card mt-3">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-3">
							<h4>Cheating</h4>
						</div>
						
						<div class="col-12 col-md-9">
							<form action="{{ request()->fullUrl()}}" method="get">
							<div class="form-group w-100">
							    <select class="form-control w-100" name="cheat_detect">
							      <option value ="3" @if($test_overall->cheat_detect==0) selected @endif>Potentially No</option>
							      <option value ="1" @if($test_overall->cheat_detect==1) selected @endif>Potentially YES</option>
							      <option value ="2" @if($test_overall->cheat_detect==2) selected @endif>Not clear</option>
							    </select>
							    <input type="hidden" name="student" value="{{request()->get('student')}}" />
							 </div>
							 <button class="btn btn-primary" type="submit">save</button>
							 </form>
						</div>
						
						
					</div>
				</div>
			</div>
		@endif

	  @else
	  	<div class="card "  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
				<div class="card-body">
				Your responses are recorded for internal evaluation.
			</div>
		</div>

	  @endif

	@endif
	

	@endif

	</div>
</div>


<div class="modal fade bd-example-modal-lg" id="exampleModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel3" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content">
     
      <div class="modal-body">
       This action will erase the last saved test response, and cannot be reversed. Kindly confirm your action.
      </div>
    
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
       <form method="post" action="{{route('assessment.show',$exam->slug)}}">
        <input type="hidden" name="retry" value="1">
        <input type="hidden" name="test_id" value="{{$exam->id}}">
        	@if(\auth::user())
        <input type="hidden" name="user_id" value="{{\auth::user()->id}}">
        	@endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <button type="submit" class="btn btn-danger">Erase my Responses</button>
        </form>
  
      </div>
    </div>
  </div>
</div>

@endsection           