
<div class="p-3 " id="q{{$qno+1}}"></div>
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2 " >
			<div class="text-center p-1 rounded  w100 "  style="background:#F8EFBA;border:1px solid #e4d998;">
				Q{{ $qno+1 }}
			</div>
		</div>
	</div>
	<div class="col-9 col-lg-9"><div class="pt-1 question question_p">{!! $question->question!!}</div></div>
</div>

@if($question->a)
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2" >
			<div class="text-center p-1 rounded bg-light w100 border" >
				<input class="form-check-input" type="radio" name="q{{ $qno+1 }}" data-qno="{{ $qno+1 }}" value="A"  >
			A</div>
		</div>
	</div>
	<div class="col-9 col-lg-10"><div class="pt-1 a question_p">{!! $question->a!!}</div></div>
</div>
@endif

@if($question->b)
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2" >
			<div class="text-center p-1 rounded bg-light w100 border" ><input class="form-check-input" type="radio" name="q{{ $qno+1 }}" data-qno="{{ $qno+1 }}" value="B"  > B</div>
		</div>
	</div>
	<div class="col-9  col-lg-10"><div class="pt-1 b question_p">{!! $question->b!!}</div></div>
</div>
@endif

@if($question->c)
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2" >
			<div class="text-center p-1 rounded bg-light w100 border" ><input class="form-check-input" type="radio" name="q{{ $qno+1 }}" data-qno="{{ $qno+1 }}" value="C"  > C</div>
		</div>
	</div>
	<div class="col-9 col-lg-10"><div class="pt-1 c question_p">{!! $question->c!!}</div></div>
</div>
@endif

@if($question->d)
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2" >
			<div class="text-center p-1 rounded bg-light w100 border" ><input class="form-check-input" type="radio" name="q{{ $qno+1 }}" data-qno="{{ $qno+1 }}" value="D"  > D</div>
		</div>
	</div>
	<div class="col-9 col-lg-10"><div class="pt-1 d question_p">{!! $question->d!!}</div></div>
</div>
@endif

@if($question->e)
<div class="row no-gutters">
	<div class="col-3 col-lg-2">
		<div class="pr-3 pb-2" >
			<div class="text-center p-1 rounded bg-light w100 border" ><input class="form-check-input" type="radio" name="q{{ $qno+1 }}" data-qno="{{ $qno+1 }}" value="E">E</div>
		</div>
	</div>
	<div class="col-9 col-lg-10"><div class="pt-1 e question_p">{!! $question->e!!}</div></div>
</div>
@endif

<div class="accuracy accuracy_correct_{{$qno+1}} p-3 border mb-3" style="display: none">
	<span class="text-success question_p"><i class="fa fa-check-circle"></i> Your response is correct</span>
</div>
<div class="accuracy accuracy_incorrect_{{$qno+1}} p-3 border mb-3" style="display: none">
	<span class="text-danger question_p"><i class="fa fa-times-circle"></i> Your response is incorrect</span>
</div>
@if($question->explanation || $question->answer)
<div class="answer answer_{{$qno+1}} p-3 border mb-3 bg-light question_p" style="display: none">
	@if($question->answer)
		<h3>Answer</h3>
		<p class="question_p">{{$question->answer}}</p>
	@endif
	@if($question->explanation)
		<h3>Solution</h3>
		<p class="question_p">{!!$question->explanation !!}</p>
	@endif
</div>
@endif

<div class="bg-light border p-3 submit_{{$qno+1}}">
<button class="btn btn-primary btn-lg submit" type="button" data-qno="{{ $qno+1 }}" data-answer="{{$question->answer}}"> Submit</button>
</div>


