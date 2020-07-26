<div class="card mb-3 text-white d-none d-md-block blogd" style="background:#ca2428">
	<div class="card-body">
		<div class="text-bold " style="color:#da737f">Solutions</div>
		<a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}"><h2>
		{{ ucfirst($exam->name)  }} - Analysis
		</h2></a>
		<br>

		<div class=" p-2 mb-2 rounded" style="border:2px solid #bb061c">
		<div class="row ">
			<div class="col-3">
				@if($details['prev'])
				<a class="white-link" href="{{ $details['prev'] }}">
				<div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
				</a>
				@endif
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
			<div class="col-3"> 
				@if($details['next'])
				<a class="white-link" href="{{ $details['next'] }}">
				<div class=" w100 p-1 text-center mr-3"><i class="fa fa-angle-double-right"></i></div>
				</a>
				@endif
			</div>
		</div>
		</div>
		<div class="qset {{ $i=0 }}" style="max-height: 170px;overflow-y: auto;">

			@foreach($exam->sections as $section)
				@if(count($exam->sections)!=1)
				<div class="mb-1 " style="background:#b91427; color:white;border: 1px solid #ab0014;padding:3px;border-radius:4px;"><div class="p-1 ">{{$section->name}}</div></div>
				@endif
				<div class="row no-gutters ">
				@if(isset($section_questions[$section->id]))
				@foreach($section_questions[$section->id] as $key=> $q)
				
				
				
				<div class="col-3 mb-1">
					<a class="white-link" href="{{ route('assessment.solutions.q',[$exam->slug,$q->question_id]) }}?student={{$student->username}}">
					<div class="pr-1">
					<div class="w100 p-1 testqno s text-center rounded @if($q->question_id==$question->id) active @endif 
					@if($questions[$i]['response'] !=null) @if($questions[$i]['accuracy'] == 0) qred-border @else qgreen-border @endif @else qborder  @endif 
					@if($questions[$i]['status']!=2) qpink-border @endif " id="q{{$q->id}}" 
					    > {{ (++$i ) }} </div>
					</div>
					</a>
				</div>
				@endforeach
				@endif
				</div>
			@endforeach

		
		</div>
	</div>
</div>
