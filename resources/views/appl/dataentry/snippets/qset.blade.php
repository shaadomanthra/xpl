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
				<div class="qborder w100 p-1 text-center rounded @if($q->id==$question->id) active @endif @if($q->status == 0)  @elseif($q->status == 1) border-success @else border-warning  @endif" id="q{{ ($q->id )}}"><div class=""> <span style="font-size:10px;">@if(request()->session()->get('mode') != 'reference') {{ ($key + 1 ) }} @else {{ $q->reference }}@endif</span>
					@if($q->intest)<small ><i  class="fa fa-tumblr-square" style="opacity:0.3;font-size: 8px;"></i></small>@endif
					@if($q->level)
						@if($q->level==1) <small><i  class="fa fa-circle-o level3" ></i></small>
						@elseif($q->level==2) 
						<small><i  class="fa fa-circle-o level3" ></i></small>
						<small><i  class="fa fa-circle-o level3" ></i></small>
						@elseif($q->level==3)
						<small><i  class="fa fa-circle-o level3" ></i></small>
						<small><i  class="fa fa-circle-o level3" ></i></small>
						<small><i  class="fa fa-circle-o level3" ></i></small>
						@endif
					@endif
				</div></div>
				</div>
				</a>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>

<div class="border p-3 rounded mb-3">
<h3> Mode</h3>
		<form method="get" action="{{ \url()->current() }}">
			<select class="custom-select mb-3" name="mode">
			  <option value="reference" @if(request()->session()->get('mode') == 'reference') selected @endif >Reference</option>
			  <option value="sno" @if(request()->session()->get('mode') == 'sno') selected @endif>Sno</option>
			</select>
			<input type="hidden" name="change" value="1" >
			<button class="btn btn-sm btn-success">save</button>
		</form>
	</div>
