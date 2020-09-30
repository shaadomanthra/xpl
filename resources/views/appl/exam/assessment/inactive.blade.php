@extends('layouts.app-border')

@section('title', 'Inactive - '. $exam->name)
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
  	
    @if(isset($exam->image))
        @if(Storage::disk('s3')->exists($exam->image))
   
        <img 
      src="{{ Storage::disk('s3')->url($exam->image) }} " class="w-100 d-print-none float-right" alt="{{  $exam->name }}" style='max-width:200px;'>
    
        @endif
      @endif
    <h2> <i class="fa fa-angle-right"></i> {{ $exam->name }}</h2>
    <h5><span class="badge badge-info">Status : Inactive</span></h5>
    <hr>
    <h4>Instructions</h4>
    {!! $exam->instructions !!}

    <hr>
  	@if(!$exam->auto_activation)
    <h1 class="display-4"> <div class=""><i class="fa fa-link"></i> The Test  is inactive</div></h1>
    @else
    <h3 class="display-5 mb-1"> <div class=""> This test link  will be activated on <span class="text-danger">{{\carbon\carbon::parse($exam->auto_activation)->toDayDateTimeString()}}</span></div></h3>
    <p>and will be deactiveted by <span class="text-info">{{\carbon\carbon::parse($exam->auto_deactivation)->toDayDateTimeString()}}</span></p>
    <p><b> Note:</b> You are required to start the test within the above mentioned test window. </p>
    @endif
    <p>  For queries, kindly write to us at <span class="text-primary">info@xplore.co.in</span> </p>
    <p>
    </p>
    <a href="{{ url('/') }}"><button class="btn btn-success">Home</button></a>
  </div>



</div>    
</div>
@endsection           