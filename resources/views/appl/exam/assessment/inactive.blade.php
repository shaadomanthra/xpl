@extends('layouts.app-border')

@section('title', 'Inactive - '. $exam->name)
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
  	<h5><span class="badge badge-info">{{ $exam->name }}</span></h5>
  	@if(!$exam->auto_activation)
    <h1 class="display-4"> <div class=""><i class="fa fa-link"></i> The Test  is inactive</div></h1>
    @else
    <h3 class="display-5"> <div class=""><i class="fa fa-link"></i> This Test  will be activated on <span class="text-danger">{{\carbon\carbon::parse($exam->auto_activation)->toDayDateTimeString()}}</span></div></h3>
    @endif
    <p>  For queries, kindly write to us at <span class="text-primary">info@xplore.co.in</span> </p>
    <p>
    </p>
    <a href="{{ url('/') }}"><button class="btn btn-success">Home</button></a>
  </div>



</div>    
</div>
@endsection           