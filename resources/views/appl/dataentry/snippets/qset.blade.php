<div class="card bg-light mb-3">
	<div class="card-body">
		<div class="text-bold ">Topic</div>
		<h2> Questions</h2>
		<br>

		<div class="border p-2 mb-2 rounded">
		<div class="row ">
			<div class="col-3">
				@if($details['prev'])
				<a href="{{ route('question.show',[$project->slug,$details['prev']])}}">
				<div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
				</a>
				@endif
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
			<div class="col-3"> 
				@if($details['next'])
				<a href="{{ route('question.show',[$project->slug,$details['next']])}}">
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
				<a href="{{ route('question.show',[$project->slug,$q->id])}}">
				<div class="pr-1">
				<div class="border w100 p-1 text-center rounded @if($q->id==$question->id) active @endif">{{ $key + 1 }}</div>
				</div>
				</a>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
