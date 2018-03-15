@extends('layouts.plain')

@section('content')
<div class="mt-5">

	<div class="text-center">
		<h1 style="font-size:100px">404</h1>
		@if($exception->getMessage())
		<h2 class="mb-5">{{ $exception->getMessage() }}</h2>
		@else
		<h2 class="mb-5">Page Not Found</h2>
		@endif
		<a href="{{ route('home') }}">
		<button type="button" class="btn btn-outline-dark">Go to Homepage</button>
	</a>
	</div>
</div>
@endsection           

