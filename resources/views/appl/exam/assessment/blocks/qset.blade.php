<div class="card mb-3 text-white d-none d-md-block blogd" style="background:#ca2428">
	<div class="card-body">
		<h4><i class="fa fa-clock-o"></i> Timer</h4>
		<h1 class="text-bold mb-2" id="timer"></h1>
		
		
		<div class=" p-2 mb-2 rounded" style="border:2px solid #bb061c">
		<div class="row ">
			<div class="col-3">
				<div class="left-qno cursor w100 p-1 text-center pl-2 " data-sno=""  style="display:none"><i class="fa fa-angle-double-left" ></i></div>
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
			<div class="col-3"> 
				<div class="right-qno cursor w100 p-1 text-center mr-3 " data-sno="2" ><i class="fa fa-angle-double-right" ></i></div>
			</div>
		</div>
		</div>
		<div class="qset" style="max-height: 170px;overflow-y: auto;" data-url="{{ URL::current() }}" data-lastsno="{{ count($questions)  }}" data-counter="0" data-user="{{ \auth::user()->id }}" data-sno="{{ $i=0 }}">
			<div class="start"></div> 
			@foreach($exam->sections as $section)
				@if(count($exam->sections)!=1)
				<div class="mb-1 " style="background:#b91427; color:white;border: 1px solid #ab0014;padding:3px;border-radius:4px;"><div class="p-1 ">{{$section->name}}</div></div>
				@endif
				<div class="row no-gutters ">
				@if(isset($section_questions[$section->id]))
				@foreach($section_questions[$section->id] as $key=> $q)
					<div class="col-3 mb-1">
						<div class="pr-1">
						<div class="w100 p-1 test2qno s{{ (++$i ) }} cursor text-center rounded qborder  @if($i==1) active @endif" id="q{{ ($q->id )}}" data-qno="{{$q->id}}"  data-sno="{{ ($i) }}" 
						    >{{ ($i ) }}</div>
						</div>
					</div>
				@endforeach
				@endif
				</div>
			@endforeach
		</div>
	</div>
</div>

@if($camera)
<div class="camera border p-3">
    <video id="video" class="mb-3 bg-light w-100" data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="{{ ($time*60*1000)/20}}" data-c="0" data-username="{{\auth::user()->username}}">Video stream not available.</video>
    <small>Continuous monitering enabled</small>
</div>
@endif



