@extends('layouts.app')
@section('title', 'Upload Video | Xplore')
@section('content')
<div class="bg-white p-3 border rounded">
	<h1> Upload Selfie Video on 'Introduce yourself'</h1>
	<h5>Instructions</h5>
	<p>
		<ul>
			<li>The size of the video should be less than 90mb. Kindly use video compressor apps to reduce the size of video before uploading. </li>
			<li>Take the video in a location where light falls on to your face and the outside noise is less.</li>
			<li> You can only upload the video once, so kindly cross check the final video before uploading.</li>
		</ul>
	</p>
@if(\auth::user())
@if(!\auth::user()->video)
<div class="border bg-light p-3 rounded">
<form action="{{ url('video') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Upload Video</label>
        <input type="file" name="video" id="exampleInputVideo" />
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
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