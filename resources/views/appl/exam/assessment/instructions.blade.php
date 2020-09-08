@extends('layouts.app-border')
@section('title', 'Test Instructions - '.$exam->name.'')
@section('content')

<div class="mb-md-5 mb-2 mt-3">
	<div class="container">
		<div class="p-3  display-3 border rounded bg-white mb-3">{{ $exam->name }}  - Instructions</div>

	<div class=" border p-3 bg-white rounded">
		
		{!! $exam->instructions  !!}
		
		&nbsp;&nbsp;&nbsp;&nbsp;<br>
		@if($exam->examtype->name=='api')
		<a href="{{ env('API_URL').$exam->slug.'/try?id='.auth::user()->id.'&source='.env('APP_NAME').'&username='.auth::user()->username.'&private=1&uri='.route('assessment.analysis',$exam->slug) }}">
		@else
		<a href="{{route('assessment.try',$exam->slug)}}@if(request()->get('code'))?code={{ request()->get('code') }}@endif">
		@endif
			<button class="btn btn-lg btn-primary mt-3"> Accept and Proceed</button>
		</a>
	</div>
	</div>
</div>
@endsection           