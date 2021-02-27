
<style>
video ,#photo3{
    width: 60px;
    height: 60px;
    object-fit: cover;
    object-position: center;
}

.camera {
    width: 60px;
    height: 60px;
    overflow: hidden;
}
</style>
<div class="pl-3 py-3 p-2 border rounded mb-2 d-none d-md-block">
	<div class="row">
		<div class="col-6">
			<h4>{{ auth::user()->name}}</h4>
			<p class="mb-0">
				@if(auth::user()->roll_number) {{ auth::user()->roll_number}} <br> @endif
				 @if(isset($data['branches'][auth::user()->branch_id])) {{ $data['branches'][auth::user()->branch_id]->name}} <br>@endif
				<span class="badge badge-warning connection_status" data-status=1></span>
			</p>

		</div>
		<div class="col-6">
		@if(isset($images['user']))
        <img 
      src="{{ $images['user'] }}  " class="rounded d-inline float-right" alt="{{  $exam->name }}" style='max-width:60px;' data-toggle="tooltip"  title="Profile Picture">
      @endif
      @if(isset($exam->settings))
      @if(isset($exam->settings->signature))
          @if(strtolower($exam->settings->signature)=='yes')
     	<img 
      src="{{ $user->getImage('signature') }}  " class="rounded d-inline" alt="{{  $exam->name }}" style='max-width:60px;' data-toggle="tooltip"  title="Signature">
      @endif @endif @endif
		</div>
	</div>

</div>
<div class="card mb-3 text-white d-none d-md-block blogd" style="background:#ca2428">
	<div class="card-body">

@if(!isMobileDevice())
@if($camera)
<div class="camera_holder  rounded float-right">
<div class="">
	<img id="photo3" style="position: absolute;right:10px;top:15px" src=""> 
    <video id="video" class="video_small rounded" data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="{{ ($time*60*1000)/20}}" data-c="{{$c}}" data-cc="0" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}" style="width:60px;height:60px;position: absolute;right:10px;top:15px">Video stream not available.</video>
    <canvas id="canvas" style='display: none' >
    </canvas>
    <canvas id="canvas3" style='display: none' >
    </canvas>

    <div class="output">
    <img id="photo" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="{{ ($time*60*1000)/20}}" data-c="{{$c}}" data-cc="0" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}" data-bucket="{{ env('AWS_BUCKET')}}" data-region="{{ env('AWS_DEFAULT_REGION')}}"  data-uname="{{\auth::user()->name}}" data-rollnumber="{{\auth::user()->roll_number}}" data-last_photo="" style='display: none' src=""> 
     
  </div>
</div>
</div>


@endif
@endif

		<h4 class="timer_count" data-value="{{$time*60}}"><i class="fa fa-clock-o"></i> Timer &nbsp;&nbsp;
		@if(isset($exam->calculator))
		@if($exam->calculator)
		<span class="" style="cursor: pointer" data-toggle="modal" data-target="#calculator"><i class="fa fa-calculator" aria-hidden="true"></i> </span>
		@endif
		@endif
		</h4>

		<h1 class="text-bold mb-2" id="timer"></h1>
		@if(!$camera)
		<span class="text-warning "><i class="fa fa-dot-circle-o blink" aria-hidden="true"></i> Continuous monitoring is enabled</span>
		@endif
		


	@if($exam->sections[0]->name!='typing')
		<div class=" p-2 mb-2 rounded mt-3" style="border:2px solid #bb061c">
		<div class="row ">
			<div class="col-3">
				<div class="left-qno cursor w100 p-1 text-center pl-2 " data-sno=""  style="display:none"><i class="fa fa-angle-double-left" ></i></div>
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q(<span class="sec_qcount">{{ count($exam->sections[0]->questions) }}</span>)</div></div>
			<div class="col-3"> 
				<div class="right-qno cursor w100 p-1 text-center mr-3 " data-sno="2" ><i class="fa fa-angle-double-right" ></i></div>
			</div>
		</div>
		</div>
		<div class="qset" style="max-height: 170px;overflow-y: auto;" data-url="{{ URL::current() }}" data-lastsno="{{ count($questions)  }}" data-counter="0" data-user="{{ \auth::user()->id }}" data-sno="{{ $i=0 }}" >
			<div class="start"></div> 
			@foreach($exam->sections as $k=>$section)
			<div class="section_block section_block_{{$section->id}}" data-time="{{$section->time}}" data-qno="{{ $section_questions[$section->id][0]->id }}" data-sno="{{ ($i) }}" data-section_next="{{ ($section->next) }}" data-qcount="{{count($section->questions)}}" @if($k!=0) style="display: none" @endif >
				@if(count($exam->sections)!=1)
				
				<div class="mb-1 " style="background:#b91427; color:white;border: 1px solid #ab0014;padding:3px;border-radius:4px;"><div class="p-1 ">{{$section->name}} </div></div>
				@endif
				<div class="row no-gutters ">
				@if(isset($section_questions[$section->id]))
				@foreach($section_questions[$section->id] as $key=> $q)
					<div class="col-3 mb-1">
						<div class="pr-1">
						<div class="w100 p-1 test2qno  s{{ (++$i ) }} cursor text-center rounded qborder  @if($q->response) qblue-border @endif @if(count($q->images)) qblue-border @endif @if($i==1) active @endif" id="q{{ ($q->id )}}" data-qno="{{$q->id}}"  data-sno="{{ ($i) }}" data-section="{{ $section->id }}"  data-pos="@if($key==0) start @elseif(end($section_questions[$section->id])->id == $q->id) end @else between @endif "  data-qcount="{{count($section->questions)}}"
						    >{{ ($i ) }}</div>
						</div>
					</div>
				@endforeach
				@endif
				</div>
			</div>
			@endforeach
		</div>
	@else
		<div class="mt-4">
			
			<span class="badge badge-dark">Total word Count - <span class="word_total"></span></span><br>
			<span class="badge badge-primary">Typed Word Count - <span class="word_typed"></span></span><br>
			<span class="badge badge-warning">Pending Word Count - <span class="word_pending"></span></span><br>
			<span class="badge badge-danger border">Error Count - <span class="word_error"></span></span><br>
		</div>
	@endif
	</div>
</div>

@if($exam->sections[0]->name=='typing')
	<div class="mt-4 border rounded p-3">
		<h5>Color codes</h5><hr>
		<div><span class="text-primary">Current word</span> is blue</div>
		<div><span class="text-danger">Error word</span> is red</div>
		<div><span class="text-success">Correct word</span> is green</div>

	</div>
@endif








