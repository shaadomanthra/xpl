@extends('layouts.app')
@section('title', 'Upload Resume | Xplore')
@section('content')
<div class="bg-white p-3 border rounded">
  
@include('flash::message')
@if(\auth::user())
@if(!Storage::disk('s3')->exists('resume/resume_'.\auth::user()->username.'.pdf') || request()->get('edit'))

<h1> Update Latest Resume </h1>
  
<div class="border bg-light p-3 rounded">
<form action="{{ route('resume.upload') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Resume (Only PDF Supported)</label>
        <input type="file" class="form-control" name="file" id="formGroupExampleInput" >
         <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@else
  <h3 class="mb-4"> My Resume</h3>

<div class="p-4 bg-white">
  <div class="row">

    
    <div class="col-12 ">

     
     <div class="pdfobject-container">
<div id="resume"></div>
</div>

<script src="{{ asset('js/pdf.js')}}"></script>
<script>PDFObject.embed("{{ Storage::disk('s3')->url('resume/resume_'.\auth::user()->username.'.pdf')}}?time={{microtime()}}", "#resume");</script>

<style>
.pdfobject-container { height: 30rem; border: 1px solid rgba(0,0,0,.2); }
</style>

  <a href="{{ route('resume.upload')}}?edit=1" class="btn btn-primary mt-3">edit</a>
    <a href="{{ route('resume.upload')}}?delete=1" class="btn btn-danger mt-3">delete</a>


@endif
@endif
@if(request()->get('redirect'))
<div class="mt-4">
<a href="{{ request()->get('redirect')}}" class="mt-3">return to the test page</a>
</div>
@endif
</div>
@endsection