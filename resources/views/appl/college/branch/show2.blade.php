@extends('layouts.nowrap-product')
@section('title', $obj->name.' | PacketPrep')
@section('description', 'This page is about the statistics of the zone - '.$obj->name)
@section('keywords', 'obj,packetprep,'.$obj->name)

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-4 col-md-2">
       <div class="float-left ">
          <img src="{{ asset('/img/branch.jpg')}}" class="w-100 p-3 pt-0"/>   
      </div>
    </div>
    <div class="col-12 col-md-10">
      <h1 class=" mb-md-1">
       &nbsp; {{ $obj->name }} 
      
      </h1>
      
      <div class="border bg-light rounded mt-4 p-3">
            <h2>Users</h2>
            <div class="display-1"><a href="{{ route('branch.students',$obj->id)}}">{{ $data['users']['all']  }}</a></div>
          </div>
      
      
    </div>
    
  </div>
  </div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  

<div class="row">
  
  @foreach($metrics as $m)
  <div class="col-6 col-md-3">
                  <div class="border bg-white  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view',$m->name)}}"> {{$m->name}} </a></h4>
                  <div class="display-2" ><a href="{{ route('branch.students',$obj->id)}}?metric={{$m->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $m->users_count }}</a></div>
                  </div>
              </div>
  @endforeach
 



  </div>



</div>

   

     </div>   
</div>

@endsection           