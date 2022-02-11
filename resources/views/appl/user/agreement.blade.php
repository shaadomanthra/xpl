@extends('layouts.app')
@section('title', 'Upload Agreement')
@section('content')
<div class="bg-white p-3 border rounded">
  
@include('flash::message')
@if(\auth::user())
@if(!Storage::disk('s3')->exists('resume/resume_'.\auth::user()->username.'.pdf') || request()->get('edit'))

<h1>Upload the Agreement & related documents</h1>
@if(!$status)
<h4>Status: <span class="text-danger">INCOMPLETE (upload all docs)</span></h4>
@else
<h4>Status: <span class="text-success"><i class="fa fa-check-circle"></i> COMPLETE </span></h4>
@endif
<hr>


<h4><i class="fa fa-angle-right"></i> Upload your signed Agreement document</h4>
<ul>
  <li>Download the following <a href="https://drive.google.com/file/d/1GbxA2V9jUZ9THrZv6niRViQdXBAnfFY6/view" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Agreement</a> and print it on A4 sheets</li>
  <li>Both parent and the student has to sign on each page of the printed document</li>
  <li>Upload the scanned PDF document (agreement copy) in the below form</li>
  <li> Also you are required to upload your and your parents singed photocopy of aadhar with date, and your passport photo </li>
</ul>

<div class="border bg-light p-3 rounded my-3">
@if(!Storage::disk('s3')->exists('agreement/agreement_'.\auth::user()->username.'.pdf'))
<form action="{{ route('profile.agreement') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Signed Agreement PDF (Only PDF Supported)</label>
        <input type="file" class="form-control" name="file_agreement" id="formGroupExampleInput" >
    </div>
   
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@else
    <h4 class="mb-0"><i class="fa fa-check-circle"></i> Agreement PDF  uploaded</h4>
@endif
</div>

<h4><i class="fa fa-angle-right"></i> Upload your signed Aadhar card photocopy (student)</h4>
<div class="border bg-light p-3 rounded my-3">
@if(!Storage::disk('s3')->exists('agreement/aadhar_student_'.\auth::user()->username.'.pdf'))
<form action="{{ route('profile.agreement') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Signed Aadhar copy of student (Only PDF Supported)</label>
        <input type="file" class="form-control" name="file_aadhar_student" id="formGroupExampleInput" >
    </div>
   
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@else
    <h4 class="mb-0"><i class="fa fa-check-circle"></i> Student Aadhar PDF uploaded</h4>
@endif
</div>


<h4><i class="fa fa-angle-right"></i> Upload your parent Aadhar card photocopy  ( signed by parent)</h4>
<div class="border bg-light p-3 rounded my-3">
@if(!Storage::disk('s3')->exists('agreement/aadhar_parent_'.\auth::user()->username.'.pdf'))
<form action="{{ route('profile.agreement') }}" method="post" enctype="multipart/form-data">
     <div class="form-group ">
        <label for="exampleInputVideo">Signed Aadhar copy of parent (Only PDF Supported)</label>
        <input type="file" class="form-control" name="file_aadhar_parent" id="formGroupExampleInput" >
    </div>
   
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@else
    <h4 class="mb-0"><i class="fa fa-check-circle"></i> Parent Aadhar PDF uploaded</h4>
@endif
</div>

<h4><i class="fa fa-angle-right"></i> Upload your photo </h4>
<div class="border bg-light p-3 rounded my-3">
@if(!Storage::disk('s3')->exists('agreement/photo_'.\auth::user()->username.'.png') && !Storage::disk('s3')->exists('agreement/photo_'.\auth::user()->username.'.jpg') && !Storage::disk('s3')->exists('agreement/photo_'.\auth::user()->username.'.jpeg'))
<form action="{{ route('profile.agreement') }}" method="post" enctype="multipart/form-data">
    <div class="form-group ">
        <label for="exampleInputVideo">Passport Photo of student (Only JPG or PNG supported)</label>
        <input type="file" class="form-control" name="file_photo" id="formGroupExampleInput" >
     
    </div>
   
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@else
    <h4 class="mb-0"><i class="fa fa-check-circle"></i> Photo uploaded</h4>
@endif
</div>
   
    
     


@else

@endif
@endif
</div>
@endsection