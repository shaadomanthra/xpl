@extends('layouts.app')
@section('title', 'Upload Video | Xplore')
@section('content')
<div class="bg-white p-3 border rounded">
	
@include('flash::message')
@if(\auth::user())
@if(!\auth::user()->video || request()->get('edit'))

<h1> Update Profile Video </h1>
	<h5>Instructions</h5>
	<p>
		<ul>
			<li>Record one single selfie video of 1 to 2 minutes. The video should consist of the following
				<ul>
					<li> about 30 secs - Talk about Name, college, branch, academic percentage, experience (if any)</li>
					<li> about 40 secs - Share the most happiest moment in your life</li>
					<li> about 40 secs - Why should we hire you?</li>
				</ul>
			</li>
			<li>Upload the selfie video to youtube</li>
			<li>If you want to hide the video from public then mark the privacy for the video as 'unlisted' or you can leave the privacy as public. Dont make it private as it cannot be embedded into xplore platform.</li>
			<li>Copy the url of the uploaded video</li>
			<li>Enter the copied url in the below form and submit.</li>
		</ul>
	</p>
<div class="border bg-light p-3 rounded">
<form action="{{ url('video') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Youtube video url</label>
        <input type="text" name="url" class="form-control" id="exampleInputVideo" 
        @if(auth::user()->video)
        	value="https://www.youtube.com?v={{\auth::user()->video}}"
        @endif
        />
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@else
	<h3 class="mb-4"> My Profile Video</h3>
	<div class="embed-responsive embed-responsive-16by9">
	  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{\auth::user()->video}}?rel=0" allowfullscreen></iframe>
	</div>
	<a href="{{ route('video.upload')}}?edit=1" class="btn btn-primary mt-3">edit</a>
@endif
@endif
</div>
@endsection