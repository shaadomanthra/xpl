@extends('layouts.nowrap-product')
@section('title', 'Campus Connect | PacketPrep')
@section('description', 'This page is about campus connect')
@section('keywords', 'college,packetprep,campus connect')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-10">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-university"></i> &nbsp; {{ $college->name }}
			</h1>
      <p> <a href="{{ route('ambassador.connect')}}"><i class="fa fa-angle-double-left"></i> back to campus connect</a></p>
      <p>
        <div class="display-4 border p-3 ">Users: {{ $college->users()->count() }}</div>
      </p>

		</div>
		<div class="col-12 col-md-2">
      <div class="float-right ">
          <img src="{{ asset('/img/college.jpg')}}" class="w-100 p-3 pt-0"/>    
      </div>
  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  
      <div class="row">
        <div class="col-12 col-md-3">
            <div class="list-group">
             <a href="#" class="list-group-item list-group-item-action active">Onboarding</a>
             <a href="#" class="list-group-item list-group-item-action">Participation</a>
             <a href="#" class="list-group-item list-group-item-action">Premium</a>
            </div>
        </div>
        <div class="col-12 col-md-9">
            <div class="row">
              @foreach($branches as $k => $b)
                <div class="col-12 col-md-4 mb-4">
                  <div class="bg-light border rounded p-4">
                    <h2>{{ $k }}</h2>
                    <a href="{{ route('ambassador.students')}}?branch={{$k}}"><div class="display-1">{{ $b}}</div></a>
                  </div>
                </div>
              @endforeach
                
            </div>
        </div>
      </div>
     </div>   
</div>

@endsection           