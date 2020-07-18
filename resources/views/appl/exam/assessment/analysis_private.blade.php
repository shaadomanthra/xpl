@extends('layouts.app-plain')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} - Analysis  </li>
  </ol>
</nav>



<div class="mb-md-2">
	<div class="">
		<div class="p-3 border rounded bg-light mb-4">
		<div class="  display-4  mb-3"><b>{{ ucfirst($exam->name) }} - Report</b></div>
		<p>Name : <span class="text-primary">{{$student->name}}</span><br>
			
		</p>
	</div>
	@if($exam->solutions ==2 && !\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))


	<div class="card "  style="background: #fff4ef;border: 2px solid #ffdecc;color: #ab836e;">
		@if($_SERVER['HTTP_HOST'] == 'smec.xplore.co.in' )
		<div class="card-body">
			Thank you.You have completed your test and your responses are recorded for internal evaluation.
			Results will be announced on 8th July 2020. Kindly visit <a href="http://www.smec.ac.in">www.smec.ac.in</a>
		</div>
		@else
			<div class="card-body">
			Your responses are recorded for internal evaluation.
		</div>
		@endif
	</div>

	@if(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.jpg'))
                <div class="my-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/'.$exam->slug.'_banner.jpg') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
            @elseif(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.png'))
                <div class="my-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/'.$exam->slug.'_banner.png') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
            @else
         @endif

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


		@if(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.jpg'))
                <div class="my-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/'.$exam->slug.'_banner.jpg') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
            @elseif(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.png'))
                <div class="my-3">
                  <picture class="">
                    <img 
                    src="{{ asset('/storage/articles/'.$exam->slug.'_banner.png') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
            @else
            @endif
       
        
	
		@if(isset($sections))
		<div class="card mb-3 bg-light"  style="background: #FFF;border: 2px solid #EEE;">
			<div class="card-header">
				Section Analysis
			</div>
			<div class="card-body">
			<div class="row">
				@foreach($sections as $sec =>$section)
				<div class="col-12 col-md-6">
						<div class="p-2 " height="200px">
						<canvas id="{{$section->section_id}}Container" width="600" height="200px"></canvas>
					</div>
				</div>
				@endforeach
			</div>
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
			<div class="row mb-4 {{$c=0}}">
				@for($i=1;$i<7;$i++)
					@if(Storage::disk('public')->exists('tests/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
					<div class='col-6 col-md-2'>
						<img src="{{ asset('/storage/tests/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
					</div>
					@endif
				@endfor

				@for($i=1;$i<360;$i++)
					@if(Storage::disk('public')->exists('tests/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
					<span class="{{$c++}}"></span>
					@endif
				@endfor

				<div class="col-12 mt-3">Captured:<b> {{$c}} images</b></div>

			</div>
			@endif

			<a href="{{ request()->fullUrl()}}&images=all" class="mt-3 btn-success btn-lg">view all</a>


		</div>
		</div>
		@endif

		
		
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
						<div class="mb-3">
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
						<div class="mb-3">
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
						<div class="mb-3">
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
				The test has coding questions which are submitted for evaluation. Kindly check back after 24 hours to know your result. <br>In case of any query, kindly contact the web administrator.
			</div>
		</div>

	  @endif

	

	@endif

	</div>
</div>



@endsection           