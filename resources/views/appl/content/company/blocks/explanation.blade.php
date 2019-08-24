
<div class="p-3 " id="q{{$qno+1}}"></div>
<div class="row no-gutters">
	<div class="col-2 col-lg-1">
		<div class="pr-3 pb-2 display-2" >
			
				{{ $qno+1 }}
		</div>
	</div>
	<div class="col-9 col-lg-11">
		<div class="pt-1 question mt-0 mt-md-2 mb-4"><h2>{!! $question->question!!}</h2></div></div>
</div>

<div class="answer answer_{{$qno+1}} p-3 mb-3  question_p" >
	@if($question->explanation)
		<p class="question_p">{!!$question->explanation !!}</p>
	@endif
</div>




