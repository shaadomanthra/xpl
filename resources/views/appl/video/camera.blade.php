@extends('layouts.app')
@section('title', 'Upload Video | Xplore')
@section('content')

	
<div class="bg-white p-3 border rounded">
	
<div class="contentarea">
	<h1>
		MDN - WebRTC: Still photo capture demo
	</h1>
	<p>
		This example demonstrates how to set up a media stream using your built-in webcam, fetch an image from that stream, and create a PNG using that image.
	</p>
  <div class="camera">
    <video id="video">Video stream not available.</video>
    <button id="startbutton">Take photo</button> 
  </div>
  <canvas id="canvas">
  </canvas>
  <div class="output">
    <img id="photo" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}"> 
  </div>
  <div id="text"></div>
	<p>
		Visit our article <a href="https://developer.mozilla.org/en-US/docs/Web/API/WebRTC_API/Taking_still_photos"> Taking still photos with WebRTC</a> to learn more about the technologies used here.
	</p>
</div>

</div>
@endsection