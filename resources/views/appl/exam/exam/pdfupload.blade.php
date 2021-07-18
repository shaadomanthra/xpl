@extends('layouts.app-border')
@section('title', 'Upload PDF ')
@section('content')
<div class="bg-white p-3 border rounded">
	
@include('flash::message')
@if(\auth::user())
@if(!$file)

<h1 class="url" > Upload Answersheet PDF </h1>
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
<form id="uploadForm" method='post' enctype="multipart/form-data">
	<h3>Upload File</h3><br/>
	<input id="fileupload" type="file" name="fileupload" /><bR>
	<button type="button" id="upload-button" class="btn btn-primary mt-4" onclick="uploadFile(this)" data-url="{{$url}}"> Upload </button>
</form>	
</div>
@else
	<h3 class="mb-4"> My Answersheet PDF</h3>
	<object
        data='{{$file}}'
        type="application/pdf"
        width="500"
        height="678"
      >

        <iframe
          src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
          width="500"
          height="678"
        >
        <p>This browser does not support PDF!</p>
        </iframe>
@endif
@endif
</div>

<script>
async function uploadFile(obj) {
	$url = $(obj).attr('data-url');
	console.log($url);
	
    let formData = new FormData();           
    formData.append("file", fileupload.files[0]);
    await fetch($url, {
    	method: "PUT",
                headers: {"Content-Type": "application/pdf"},
      body: formData
    });    
    alert('The file has been uploaded successfully.');
    return false;
}
</script>
@endsection