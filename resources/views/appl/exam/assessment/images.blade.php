@extends('layouts.app-plain')
@section('title', 'Images - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

<div class="card">
	<div class="card-body {{$c=0}}">
@if($count)
			<div class="row mb-4">
				@foreach($images as $k=>$f)
				<div class='col-6 col-md-2 '>
						<img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-2 border" />
					</div>
				

				@endforeach

			</div>

			<div class="mt-4">Captured: {{$count}} images</div>
@endif
		</div>
		</div>
@endsection