<div class="card bg-light mb-3 d-none d-md-block ">
	<div class="card-body">
		<div class="text-bold ">Solutions</div>
		<a href="{{ route('onlinetest.analysis',$tag->value)}}"><h2>
		{{ ucfirst($tag->value)  }} - Analysis
		</h2></a>
		<br>

		<div class="border p-2 mb-2 rounded">
		<div class="row ">
			<div class="col-3">
				@if($details['prev'])
				<a href="{{ $details['prev'] }}">
				<div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
				</a>
				@endif
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
			<div class="col-3"> 
				@if($details['next'])
				<a href="{{ $details['next'] }}">
				<div class=" w100 p-1 text-center mr-3"><i class="fa fa-angle-double-right"></i></div>
				</a>
				@endif
			</div>
		</div>
		</div>
		<div class="qset" style="max-height: 170px;overflow-y: auto;">
		<div class="row no-gutters">
			@foreach($questions as $key => $q)
			<div class="col-3 mb-1">
				
				@if($details['display_type'] == 'project')
				<a href="{{ route('onlinetest.solutions',[$tag->value,$q->id]) }}">
				@elseif($details['display_type'] == 'Topic')
				<a href="{{ route('course.question',[$tag->slug,$category->slug,$q->id]) }}">
				@elseif($details['display_type'] == 'tag')	
				<a href="{{ route('onlinetest.solutions.q',[$tag->value,$q->question_id]) }}">
				@endif
				<div class="pr-1">
				<div class="w100 p-1 text-center rounded @if($q->question_id==$question->id) active @endif 
					@if($q->response !=null) @if($q->accuracy == 0) qred-border @else qgreen-border @endif @else qborder  @endif" id="q{{ ($q->id )}}"
				    >{{ ($key + 1 ) }}</div>
				</div>
				</a>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
