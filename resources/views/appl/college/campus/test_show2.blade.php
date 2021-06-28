@extends('layouts.app')
@section('title', 'Performance Analysis - '.$exam->name)
@section('content')


<div class="row mb-md-1">
	<div class="col-12 col-md-12">


		<div class="p-4   rounded  mb-4" style="background: #f7f1e3;border: 2px solid #d1ccc0;"><h1 class="display-3 ">
		

		@if(isset($exam->image))
                @if(Storage::disk('s3')->exists($exam->image))
                
                    <img 
                    src="{{ Storage::disk('s3')->url($exam->image) }} " class="float-right" alt="{{  $exam->name }}" style='max-width:60px;'>
                  
                @endif
             @endif
			

			{{ ucfirst($exam->name) }} - Report</h1>


			@if(isset($data['item_name']))
				<div class="display-5 ">{{ $data['item_name'] }} : <b>{{ $data['item']->name }}</b></div>

			@else
				
			@endif

			@if($college)
				<i class="fa fa-building"></i> {{ $college->name }}

			@endif

			@if(request()->get('code'))
			<div>
				<i class="fa fa-code"></i> Access Code - {{ request()->get('code') }}
			</div>

			@endif

			
		</div>

		@if($details['participants']!=0)

		<div class="row">
			
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #fff;border: 2px solid #eee;color: #5B8568;">
					<div class="p-1">
						<canvas id="myChart" width="295" height="248"></canvas>

					</div>
				</div>
			</div>
			<div class="col-12 col-md-8 mb-3">
				<div class="card p-3" style="background: #E8FFEF;border: 2px solid #BBDBC5;">
					<div class="">
						<h2 class="display-5"> Details</h2>
						<hr>
						<dl class="row">

						  <dt class="col-sm-6">Participants </dt>
						  <dd class="col-sm-6">{{ $details['participants']}}  </dd>

						  <dt class="col-sm-6">Overall Accuracy</dt>
						  <dd class="col-sm-6">{{ $details['avg_accuracy']}} %</dd>


						   <dt class="col-sm-6">Avg Pace</dt>
						   <dd class="col-sm-6">{{ $details['avg_pace']}} </dd>

						   <dt class="col-sm-6">Excellent <img src="{{ asset('/img/medals/excellent.png')}}" style="width:15px;"  /> </dt>
						   <dd class="col-sm-6">{{ $details['excellent']}} </dd>
						   <dt class="col-sm-6">Good <img src="{{ asset('/img/medals/good.png')}}" style="width:15px;"  /></dt>
						   <dd class="col-sm-6">{{ $details['good']}} </dd>
						   <dt class="col-sm-6">Need to Improve <img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:15px;"  /></dt>
						   <dd class="col-sm-6">{{ $details['need_to_improve']}} </dd>
						</dl>

					</div>
				</div>
			</div>
		</div>


	
		@if(count($exam->sections)>1)
		<div class="card mb-3 bg-light"  style="background: #FFF;border: 2px solid #EEE;">
			<div class="card-header">
				Section Analysis
			</div>
			<div class="card-body">
			<div class="row">
				@foreach($exam->sections as $sec =>$section)
				<div class="col-12 col-md-6">
						<div class="p-2 " height="200px">
						<canvas id="{{$section->id}}Container" width="600" height="200px"></canvas>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		</div>
		@endif


		@if($details['college_users'] && !request()->get('none'))
		 <div class="rounded table-responsive">
		 <table class="table mt-4  table-bordered bg-white" >
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">College</th>
		      <th scope="col" class="text-center {{$w=0}}" >Participants</th>
		 
		    </tr>
		  </thead>
		  <tbody>

		    @foreach($details['coll_list'] as $coll=>$counter)
		    <tr>
		      <th scope="row">{{++$w}}</th>
		      <td>
		      	@if($coll)
		      	<a href="{{ route('test.analytics',$exam->slug)}}?college_id={{$coll}}&code={{request()->get('code')}}&branch={{request()->get('branch')}}">
		      	{{ $colleges[$coll][0]->name }}</a>
		      	@else
		      	 - unknown -
		      	@endif
		      </td>
		      <td>{{ $counter }}  </td>
		      
		      </tr>
		     @endforeach
		  </tbody>
		</table>
		</div>
		@endif

		@if(isset($details['items']) && !request()->get('none'))
		 <div class="rounded table-responsive">
		 @if(count($details['items']))
		 <table class="table mt-4  table-bordered bg-white" >
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">{{$details['item_name']}}</th>
		      <th scope="col" class="" >Participants</th>
		      <th scope="col" class="" >Accuracy</th>
		      <th scope="col" class="" >Pace</th>
		      <th scope="col" class="text-center {{$m=0}} " colspan="1">Performance</th>
		    </tr>
		  </thead>
		  <tbody>

		    @foreach($details['items'] as $k=>$batch)
		    @if($batch['participants']!=0)
		    <tr>
		      <th scope="row">{{++$m}}</th>
		      <td><a href="{{ $batch['url']}}@if(request()->get('all')) &all=1&code={{request()->get('code')}}&college_id={{request()->get('college_id')}} @endif ">{{$batch['name']}}  </a></td>
		      <td>{{$batch['participants']}}  </td>
		      <td>{{$batch['avg_accuracy']}}% </td>
		      <td>{{$batch['avg_pace']}} </td>
		      
		      <td>
		      	
		      	<div class="mb-3">
		      		<div class="display-5 mb-3"><img src="{{ asset('/img/medals/excellent.png')}}" style="width:20px;"  />&nbsp;{{$batch['excellent']}}&nbsp;&nbsp;<img src="{{ asset('/img/medals/good.png')}}" style="width:20px;"  />&nbsp;{{$batch['good']}} &nbsp;&nbsp;<img src="{{ asset('/img/medals/needtoimprove.png')}}" style="width:20px;"  />&nbsp;{{$batch['need_to_improve']}}</div>
		 			<div class="progress d-print-none" style="height:3px;">
					  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$batch['excellent_percent']}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
					  <div class="progress-bar bg-info" role="progressbar" style="width: {{$batch['good_percent']}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
					  <div class="progress-bar bg-danger" role="progressbar" style="width: {{$batch['need_to_improve_percent']}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>	
		      </td>
		      </tr>
		      @endif
		     @endforeach
		  </tbody>
		</table>
		@else
		<div class="rounded border p-3 mt-4">No items Defined</div>
		@endif
		</div>
		@endif
		

		 @include('appl.college.campus.blocks.students')

		@else
	<div class="p-3 border bg-white"> No Participants</div>

@endif

	




	</div>
</div>




@endsection           