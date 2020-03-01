@extends('layouts.app')
@section('title', 'Upload Video | Xplore')
@section('content')
<div class="bg-white p-3 border rounded">
	<h1> Upload Selfie Video on 'Introduce yourself'</h1>
	<p></p>
@if(\auth::user())
@if(!\auth::user()->video)
<form action="{{ url('video') }}" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputVideo">Upload Video</label>
        <input type="file" name="video" id="exampleInputVideo" />
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@else
	<div class="alert alert-important alert-primary">
		Successfully uploaded the profile video. It takes 10mins for video processing, kindly check back later if the video is not playing.
	</div>
	<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{\auth::user()->video}}?rel=0" allowfullscreen></iframe>
</div>
@endif
@endif
</div>
@endsection