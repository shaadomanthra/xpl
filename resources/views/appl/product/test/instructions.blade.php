@extends('layouts.app')

@section('content')




<div class="mb-md-5 mb-3">
	<div class="container">
		<div class="p-3  display-3 border rounded bg-white mb-4">Test  - Instructions</div>

	<div class=" border p-3 rounded">
		<ul>
			<li> This test contains {{ count($tag->questions)}} questions to be answered in  {{ count($tag->questions)}} minutes</li>
			<li> For every question there are either four options A,B,C,D or five options A,B,C,D,E out of which only one option is correct</li>
			<li> Each question carries 1 mark and there is no negative marking</li>

		</ul>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{{route('onlinetest.questions',$tag->value)}}">
			<button class="btn btn-lg btn-primary"> Accept and Proceed</button>
		</a>
	</div>
	</div>
</div>
@endsection           