@if($type=='mcq')
<div class="form-group mt-3">
	<label for="formGroupExampleInput ">Answer </label>
	<select class="form-control"  name="answer">

		<option value="A" @if(isset($question)) @if(strtoupper(strip_tags($question->answer))=='A') selected @endif @endif >A</option>
		<option value="B" @if(isset($question)) @if(strtoupper(strip_tags($question->answer))=='B') selected @endif @endif >B</option>
		<option value="C" @if(isset($question)) @if(strtoupper(strip_tags($question->answer))=='C') selected @endif @endif >C</option>
		<option value="D" @if(isset($question)) @if(strtoupper(strip_tags($question->answer))=='D') selected @endif @endif >D</option>
		<option value="E" @if(isset($question)) @if(strtoupper(strip_tags($question->answer))=='E') selected @endif @endif >E</option>
	</select>
</div>
@elseif($type=='naq' || $type=='eq' || $type=='fillup')
<div class="form-group mt-3">
<label for="formGroupExampleInput2">Answer</label><textarea class="form-control " name="answer"  rows="5">@if($stub=='Create'){{ (old('answer')) ? old('answer') : '' }} @else {{ $question->answer }}@endif
	</textarea>
</div>
@elseif($type=='maq')
<div class="form-group mt-3">
	<label for="formGroupExampleInput2">Answer</label>

	@if($stub=='Create')
		@if(old('answer'))
			@foreach(['A','B','C','D','E'] as $ans)
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="answer[]" value="{{$ans}}" id="defaultCheck1" 
				  @if(in_array($ans,old('answer'))) checked @endif>
				  <label class="form-check-label" for="defaultCheck1">
				    {{ $ans}}
				  </label>
				</div>
			@endforeach
		@else
			@foreach(['A','B','C','D','E'] as $ans)
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="answer[]" value="{{$ans}}" id="defaultCheck1" >
				  <label class="form-check-label" for="defaultCheck1">
				    {{ $ans}}
				  </label>
				</div>
			@endforeach
		@endif
    @else
        @foreach(['A','B','C','D','E'] as $ans)
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="answer[]" value="{{$ans}}" id="defaultCheck1"  
				  @if(in_array($ans,$question->answer)) checked @endif>
				  <label class="form-check-label" for="defaultCheck1">
				    {{ $ans}}
				  </label>
				</div>
		@endforeach
    @endif

</div>

@elseif($type=='code')

 <div >
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Output</label>
         <input class="form-control " type="text" name="answer" value="@if($stub=='Create'){{ (old('answer')) ? old('answer') : '' }}@else{{ $question->answer }}@endif"  >
      </div>
      </div>
@endif