<div class="card bg-light mb-3 d-none d-md-block ">
	<div class="card-body">
		<h4> Timer</h4>
		<h1 class="text-bold " id="timer"></h1>
		
		<br>

		<div class="border p-2 mb-2 rounded">
		<div class="row ">
			<div class="col-3">
				
				<div class="left testqno w100 p-1 text-center pl-2 @if(!$details['prev']) d-none @endif" data-qno="{{$details['prev']}}" data-testname="{{$tag->value}}"><i class="fa fa-angle-double-left" ></i></div>
				
			</div>
			<div class="col-6"> <div class="mt-1 text-center">Q(<span class="qset_qno">1</span>/{{ count($questions) }})</div></div>
			<div class="col-3"> 
				
				<div class="right testqno w100 p-1 text-center mr-3 @if(!$details['next']) d-none @endif" data-qno="{{$details['next']}}" data-testname="{{$tag->value}}"><i class="fa fa-angle-double-right" ></i></div>
			</div>
		</div>
		</div>
		<div class="qset" style="max-height: 170px;overflow-y: auto;" data-url="{{ URL::current() }}" data-lastsno="{{ count($questions)  }}" data-counter="0" data-user="{{ \auth::user()->id }}">
		<div class="row no-gutters">
			@foreach($questions as $key => $q)
			<div class="col-3 mb-1">
				<div class="pr-1">
				<div class="w100 p-1 testqno s{{ ($key + 1 ) }} text-center rounded @if($q->id==$question->id) active @endif 
					qborder @if($details['q'.$q->id]) qblue-border @endif" id="q{{ ($q->id )}}" data-qno="{{$q->id}}" data-testname="{{$tag->value}}" data-sno="{{ ($key + 1 ) }}" data-new="0" data-time="0"
				    >{{ ($key + 1 ) }}</div>
				</div>
			</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
