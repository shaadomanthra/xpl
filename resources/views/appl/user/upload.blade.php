@extends('layouts.app')
@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.user')}}">users</a></li>
      <li class="breadcrumb-item active" aria-current="page">upload </li>
    </ol>
  </nav>
  @include('flash::message') 
  <div class="card">
    <div class="card-body">
      <h1>Upload Users (CVS files only)</h1>
      <p>The below action will create users if the account is not found. If the account exists then the data is updated for college_id, branch_id, roll number, year of passing , info.
       <form method="post" class=" bg-light border p-3 rounded"  action="{{route('upload.user')}}" enctype="multipart/form-data">
       <div class="form-group">
            <label for="formGroupExampleInput ">Download Format - <a href="{{ asset('user_format.csv')}}">user_format.csv</a></label>
            <input type="file" class="form-control" name="file" id="formGroupExampleInput" >
         </div>
      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <button type="submit" class="btn btn-info">Upload</button>
    </form>
    </div>
  </div>
@endsection