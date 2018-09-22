@extends('layouts.app')

@section('content')




<div class="mb-md-5">
	<div class="container">
		<div class="p-3  display-3 border rounded bg-light mb-4">Test  - Instructions</div>

	<div class=" border p-3 rounded">
		<ul>
			<li> This test contains 30 questions to be answered in  30 minutes</li>
			<li> For every questions there are four options A,B,C,D out of which only one option is correct</li>
			<li> Each question carries 3 marks and there is no negative marking</li>

		</ul>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{{route('onlinetest.questions',$tag->value)}}">
			<button class="btn btn-lg btn-primary"> Accept and Proceed</button>
		</a>
	</div>
	</div>
</div>
@endsection           