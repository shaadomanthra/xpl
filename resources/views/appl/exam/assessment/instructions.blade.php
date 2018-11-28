@extends('layouts.app')

@section('content')

<div class="mb-md-5 mb-3">
	<div class="container">
		<div class="p-3  display-3 border rounded bg-light mb-4">{{ $exam->name }}  - Instructions</div>

	<div class=" border p-3 rounded">
		
		{!! $exam->instructions  !!}
		
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{{route('assessment.try',$exam->slug)}}">
			<button class="btn btn-lg btn-primary"> Accept and Proceed</button>
		</a>
	</div>
	</div>
</div>
@endsection           