<div class="card  text-white mb-3 blogd" style="background:#ca2428">
	<div class="card-body">
		<div class="text-bold " style="color:#da737f">{{ ucfirst($details['display_type']) }}</div>
		<h2>
		@if($details['display_type'] == 'project')
			{{ $project->name }}
		@elseif($details['display_type'] == 'category')
			{{ $category->name }}	
		@elseif($details['display_type'] == 'tag')	
			{{ $tag->name.' : '.$tag->value }}
		@endif
		</h2>
		<br>

		<div class="p-2 mb-2 rounded" style="border:2px solid #bb061c">
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
		<div class="qset" style="max-height: 170px;overflow-y: auto;">
		<div class="row no-gutters qitems">
			@foreach($questions as $key => $q)
			<div class="col-3 mb-1">
				
				@if($details['display_type'] == 'project')
				<a class="white-link" href="{{ route('question.show',[$project->slug,$q->id]) }}">
				@elseif($details['display_type'] == 'category')
				<a class="white-link" href="{{ route('category.question',[$project->slug,$category->slug,$q->id]) }}">
				@elseif($details['display_type'] == 'tag')	
				<a class="white-link" href="{{ route('tag.question',[$project->slug,$tag->id,$q->id]) }}">
				@endif
				<div class="pr-1">
				<div class="qborder w100 p-1 text-center rounded @if($q->id==$question->id) active @endif @if($q->status == 0)  @elseif($q->status == 1) border-success @else border-warning  @endif" id="q{{ ($q->id )}}">{{ ($key + 1 ) }}</div>
				</div>
				</a>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
