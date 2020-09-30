@extends('layouts.app-border')

@section('title',  $exam->name)
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
  	
   <h1>Your responses recorded</h1>
    <a href="{{ url('/') }}"><button class="btn btn-success">Home</button></a>
  </div>



</div>    
</div>
@endsection           