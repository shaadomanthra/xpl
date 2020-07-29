@extends('layouts.app-plain')
@section('title', 'Images - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

<div class="card">
	<div class="card-body {{$c=0}}">
@if(Storage::disk('s3')->exists('webcam/'.$user->username.'_'.$exam->id.'_1.jpg'))
			<div class="row mb-4">
				@for($i=1;$i<=$count;$i++)
					@if(Storage::disk('s3')->exists('webcam/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
					<div class='col-6 col-md-2 {{$c++}}'>
						<img src="{{ Storage::disk('s3')->url('webcam/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
					</div>
					@endif
				@endfor

			</div>
			@endif
			<div class="mt-4">Captured: {{$count}} images</div>
		</div>
		</div>
@endsection