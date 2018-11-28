<div class="card bg-light mb-3 d-none d-md-block ">
	<div class="card-body">
		<div class="text-bold ">Exam</div>
		<a href="{{ route('exam.show',$exam->slug)}}">
		<h2>
		{{ $exam->name }}
		</h2>
		</a>
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
		<div class="{{ $i=1}}">

			
			@foreach($exam->sections as $section)
				<div class="card mb-1 "><div class="card-body p-1 ">{{$section->name}}</div></div>
				<div class="row no-gutters">

				@foreach($section->questions as $k=> $q)
				<div class="col-3 mb-1">
				<a href="{{ route('exam.question',[$exam->slug,$q->id]) }}">
				<div class="pr-1">
				<div class="w100 p-1 text-center rounded @if($q->id==$question->id) active @endif 
					@if($q->practice($q->id)) @if($q->practice($q->id)->accuracy == 0) qred-border @else qgreen-border @endif @else qborder  @endif" id="q{{ ($q->id )}}"
				    >{{ ($i++ ) }}</div>
				</div>
				</a>
			</div>
				@endforeach
				</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
