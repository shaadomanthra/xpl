@extends('layouts.app')
@section('title',' Colleges ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($app->module) }}</li>
  </ol>
</nav>

@include('flash::message')


<div  class="row ">

  <div class="col-12 ">
 
    <form method="post" class="url_codesave" action="{{route('college.upload')}}" enctype="multipart/form-data">
     <div class="form-group bg-light border p-4">
            <label for="exampleFormControlFile1">Upload File</label>
            <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1">
          </div>
       
     
      
      
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="agency_id" value="{{ request()->get('agency.id') }}">
        <input type="hidden" name="client_id" value="{{ request()->get('client.id') }}">
      
         <button type="submit" class="btn btn-info">Save</button>
       </form>
 </div>
 
</div>

@endsection


