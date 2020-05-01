@extends('layouts.plain')

@section('content')
<div class="mt-5">

	<div class="text-center">
		<h1 style="font-size:100px">403</h1>
		<h2 class="mb-5">{{ $exception->getMessage() }}</h2>
		@if(!subdomain())
		<a href="{{ route('home') }}">
		<button type="button" class="btn btn-outline-dark">Go to Homepage</button>
	</a>
	@endif
	</div>
</div>
@endsection           

