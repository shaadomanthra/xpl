@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name.' - '.$user->name.' ')
@section('content')

@if($exam->slug != 'proficiency-test')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Analysis </li>
  </ol>
</nav>
@else
<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">{{$user->name }} - Proficiency Test</li>
    <li class="breadcrumb-item">Analysis </li>
  </ol>
</nav>

@endif


<div class="mb-md-5">
	<div class="">
		<div class="p-3  display-3 border rounded bg-light mb-4">{{$user->name }} - {{ ucfirst($exam->name) }} - Analysis</div>

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

						  <dt class="col-sm-6">Marks </dt>
						  <dd class="col-sm-6">{{ $details['marks']}} / {{ $details['total'] }} </dd>

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
		<div class="card mb-3 "  style="background: #E6F5FF;border: 2px solid #B1D2E7;">
			<div class="card-body">
				<p>
				Test analysis highlights your performance, timespent and accuracy. To improve your performance it is a very important to focus on your mistakes, so do invest some time in analysing your errors. </p>
				<a href="{{route('assessment.solutions',$exam->slug)}}">
				<button class="btn btn-primary">View Solutions</button>
			</a>
			</div>

		</div>
		@endif

		@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
		<div class="card mb-3 bg-light"  style="background: #FFF;border: 2px solid #EEE;">
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
			@if(Storage::disk('public')->exists('tests/'.$user->username.'_'.$exam->id.'_1.jpg'))
			<div class="row mb-4">
				@for($i=1;$i<200;$i++)
					@if(Storage::disk('public')->exists('tests/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
					<div class='col-6 col-md-2'>
						<img src="{{ asset('/storage/tests/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
					</div>
					@endif
				@endfor
			</div>
			@endif
		</div>
		</div>
		@endif
		
			<div class="card mb-3 "  style="">
			<div class="card-body">
				<h1> Concept Breakup</h1>
				<p>
				<div class="row">
					<div class="col-12 col-md-4">

						<div class="p-1 mb-3 rounded" style="background: rgba(75, 192, 192, 0.2); border:1px solid rgba(75, 192, 192, 1);">
							Correct
						</div>

						@if(isset($details['c']))
						@foreach($details['c'] as $m=>$item)
						@if($item['category']['name'])
						<div class="mb-3">
							<div class="">{{ ucfirst($item['category']['name']) }}</div>
							<div class="blogd">
							<a class="orange-link" href="{{route('course.show',$item['question']->project->slug)}}#{{$item['category']['slug']}}"><div class="text-small"><small><i class="fa fa-youtube-play"></i> Learn Now </small></div></a>
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
							InCorrect
						</div>
						@if(isset($details['i']))
						@foreach($details['i'] as $m=>$item)
						@if($item['category']['name'])
						<div class="mb-3">
							<div class="">{{ ucfirst($item['category']['name']) }}</div>
							<div class="blogd">
							<a class="orange-link" href="{{route('course.show',$item['question']->project->slug)}}#{{$item['category']['slug']}}"><div class="text-small"><small><i class="fa fa-youtube-play"></i> Learn Now </small></div></a>
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
							Unattempted
						</div>
						@if(isset($details['u']))
						@foreach($details['u'] as $m=>$item)
						@if($item['category']['name'])
						<div class="mb-3">
							<div class="">{{ ucfirst($item['category']['name']) }}</div>
							<div class="blogd">
							<a class="orange-link" href="{{route('course.show',$item['question']->project->slug)}}#{{$item['category']['slug']}}"><div class="text-small"><small><i class="fa fa-youtube-play"></i> Learn Now </small></div></a>
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



	</div>
</div>
@endsection           