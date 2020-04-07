@extends('layouts.app-border')

@section('title', 'Inactive - '. $exam->name)
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
  	<h5><span class="badge badge-info">{{ $exam->name }}</span></h5>
    <h1 class="display-4"> <div class=""><i class="fa fa-link"></i> The Test  is inactive</div></h1>
    <p>  Kindly contact the administrator for queries.</p>
    <p>
    </p>
    <a href="{{ url('/') }}"><button class="btn btn-success">Home</button></a>
  </div>



</div>    
</div>
@endsection           