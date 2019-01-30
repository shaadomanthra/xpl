@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social</li>
    <li class="breadcrumb-item active" aria-current="page">Word</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-6">

   

<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:900|Sarabun" rel="stylesheet">
    <div style="width:572px;height:572px;">
    <div class="p-5" style="width:550px;height:490px;color:white;background:#474787;">
    	<div class="mt-4" style="opacity:0.3">Word</div>
    	<div class="display-1 mb-4" style="font-family: 'Alegreya Sans', sans-serif;">{{ ucfirst($word->word) }}</div>
    	<div class="mt-4" style="opacity:0.3">Meaning</div>
    	<div class="display-4" style="font-family: 'Sarabun', sans-serif;">{!! ucfirst($word->meaning) !!}</div>
    	
    </div>
    <div class="" style="width:550px;height:80px;background: #2c2c54;">
    	<div class="row">
    		<div class="col-8">
    			<div class="pl-5">
    			<div class="pt-3 text-white" style="opacity: 0.2">
    			PacketPrep Daily Vocabulary<br>
    			<small><i>packetprep.com</i></small>
    			</div>
    		</div>
    		</div>
    		<div class="col-4">
    			<div class="" style="float:right;">
    		<img src="{{ asset('img/packetprep-logo-small.png') }}" width="80px"  /> 
    		
    	</div>
    		</div>
    	</div>
    	
    	
    </div>
</div>
<br>



    

    

   

  </div>

  <div class="col-3">
<div class="p-3 border">
	<h1>hash tags</h1>
	#packetprep #word #meaning #vocabulary #{{ $word->word }} #{{ strtolower(str_replace(' ', '', $word->meaning)) }}
</div>
<br><br>
  </div>

 
</div>

@endsection


