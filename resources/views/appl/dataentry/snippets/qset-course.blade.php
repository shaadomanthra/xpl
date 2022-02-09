<div class="card mb-3 text-white d-none d-md-block blogd" style="background:#ca2428">
	<div class="card-body">
		<div class="text-bold " style="color:#da737f">{{ ucfirst($details['display_type']) }}</div>
		@if($category->video_link)
		<a class="white-link" href="{{ route('course.category.video',[$project->slug,$category->slug])}}">
		@endif
		<h2>
		@if($details['display_type'] == 'project')
			{{ $project->name }}
		@elseif($details['display_type'] == 'Topic')
			{{ $category->name }}	
		@elseif($details['display_type'] == 'tag')	
			{{ $tag->name.' : '.$tag->value }}
		@endif
		</h2>
		@if($category->video_link)
		</a>
		@endif
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
		<div class="qset" style="max-height: 170px;overflow-y: auto;">
		<div class="row no-gutters">
			@foreach($questions as $key => $q)
			<div class="col-3 mb-1">
				
				@if($details['display_type'] == 'project')
				<a class="white-link" href="{{ route('question.show',[$project->slug,$q->id]) }}">
				@elseif($details['display_type'] == 'Topic')
				<a class="white-link" href="{{ route('course.question',[$project->slug,$category->slug,$q->id]) }}">
				@elseif($details['display_type'] == 'tag')	
				<a class="white-link" href="{{ route('tag.question',[$project->slug,$tag->id,$q->id]) }}">
				@endif
				<div class="pr-1">
				<div class="w100 p-1 text-center rounded @if($q->id==$question->id) bactive @endif 
					@if($q->practice($q->id)) @if($q->practice($q->id)->accuracy == 0) qred-border @else qgreen-border @endif @else qborder  @endif" id="q{{ ($q->id )}}"
				    >{{ ($key + 1 ) }}
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
				</div>
				</div>
				</a>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>


@if(\auth::user()->checkRole(['administrator','employee']))

<a href="{{ route('course.analytics',$details['course']->slug)}}?topic={{$category->slug}}" class="btn btn-primary w-100"> Check Analytics</a>

<div class="card mt-4">
	<div class="card-header">Batch <b>{{ strtoupper($bno) }}</b></div>
<div class="card-body">

@if(count($users))
  @foreach($users as $u)
		<a href="{{ route('course.question',[$project->slug,$category->slug,$question->id]) }}?student={{$u->username}}">{{$u->name}}</a> @if($u->practiced) <i class="fa fa-check-circle text-success"></i>  @else  <i class="fa fa-times-circle text-danger"></i>   @endif<br>
	@endforeach
@endif
</div>
</div>

@endif
