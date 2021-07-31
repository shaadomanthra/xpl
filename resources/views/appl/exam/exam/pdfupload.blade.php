@extends('layouts.app-border')
@section('title', 'Upload PDF ')
@section('content')
<div class="bg-white p-3 border rounded">
	
@include('flash::message')
@if(\auth::user())
@if(!$file)

<h1 class="url" > Upload Answersheet PDF </h1>
<h4>Exam Name: <br class="d-block d-md-none"><span class="text-primary">{{$exam->name}}</span></h4>
<h4>Candidate Name: <br class="d-block d-md-none"><span class="text-primary">{{$user->name}}</span></h4>

<div class="border bg-light p-3 mt-4 rounded">
<form id="uploadForm" method='post' enctype="multipart/form-data">
	<h3>Upload File</h3><br/>
	<input id="fileupload" type="file" name="fileupload" /><bR>
	<div id="uploading" class="uploading mt-2 text-success" style="display: none;" >
		<div class="spinner-border spinner-border-sm" role="status">
  <span class="sr-only">Loading... (if the upload time takes more than 2mins then you can mail the pdf to @if(env('CONTACT_MAIL')) {{env('CONTACT_MAIL')}} @else krishnatejags@gmail.com @endif)</span>
</div> uploading
	</div>
	<button type="button" id="upload-button" class="btn btn-primary mt-4" onclick="uploadFile(this)" data-url="{{$url}}"> Upload </button>
</form>	
</div>
@else
	<h1 class="mb-1"> My Answersheet PDF </h1>
	<p class="mb-4"><a href="/dashboard"><i class="fa fa-angle-double-left"></i> back to dashboard</a></p>
<h4>Exam Name: <br class="d-block d-md-none"><span class="text-primary">{{$exam->name}}</span></h4>
<h4>Candidate Name: <br class="d-block d-md-none"><span class="text-primary">{{$user->name}}</span></h4>
	<h4 class="mt-4 text-success"><i class="fa fa-check-circle"></i> PDF File uploaded</h4>
	<object
        data='{{$file}}'
        type="application/pdf"
        @if($ismob) 
        	width="300" height="478"
        @else
        	width="700" height="678"
        @endif
      >

        <iframe
          src='{{$file}}'
           @if($ismob) 
        	width="300" height="478"
        @else
        	width="700" height="678"
        @endif
        >
        <p>This browser does not support PDF!</p>
        </iframe>
@endif
@endif
</div>

<script>
async function uploadFile(obj) {
	$url = $(obj).attr('data-url');
	
	var fileInput = 
                document.getElementById('fileupload');
             

            var filePath = fileInput.value;
          
            // Allowing file type
            var allowedExtensions = 
                    /(\.pdf)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('Only PDF files are allowed. (Invalid file type)');
                fileInput.value = '';
                return false;
            } 
            else 
            {
            	var x = document.getElementById("uploading");
			     x.style.display = "block";
            	let formData = new FormData();           
			    formData.append("file", fileupload.files[0]);
			    await fetch($url, {
			    	method: "PUT",
			                headers: {"Content-Type": "application/pdf"},
			      body: formData
			    });    
			     var x = document.getElementById("uploading");
			     x.style.display = "none";
			    alert('The file has been uploaded successfully.');
			    location.reload();
			    return false;
              
            }
	
    
}
</script>
@endsection