@extends('layouts.app-border')
@section('title', 'Upload OCR ')
@section('content')
<div class="bg-white p-3 border rounded">
	
@include('flash::message')
@if(!$result)

<h1 class="url" > OCR Testpage </h1>
<h4>Exam Name: <br class="d-block d-md-none"><span class="text-primary">{{$exam->name}}</span></h4>

<div class="border bg-light p-3 mt-4 rounded">
<form method="post" action="{{route('ocrupload')}}" enctype="multipart/form-data">
	<h3>Upload File</h3><br/>
	<input id="fileupload" type="file" name="_file" /><bR>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	
	<button type="submit" id="upload-button" class="btn btn-primary mt-4"  data-url="{{$url}}"> Upload </button>
</form>	
</div>
@else
	<h1 class="mb-1"> Result </h1>
<h4>Exam Name: <br class="d-block d-md-none"><span class="text-primary">{{$exam->name}}</span></h4>
<h4>Candidate Name: <br class="d-block d-md-none"><span class="text-primary">{{$result['name']}}</span></h4>
	<h4>Your Score: <br class="d-block d-md-none"><span class="text-primary">{{$result['score']}}</span></h4><br><br>

		<h5>Data </h5>
	<pre>
		{{var_dump($result)}}
	</pre>
@endif

</div>


@endsection