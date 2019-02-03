@extends('layouts.nowrap-product')
@section('title', $college->name.' | PacketPrep')
@section('description', 'This page is about the statistics of the college - '.$college->name)
@section('keywords', 'college,packetprep,'.$college->name)

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-9">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-university"></i> &nbsp; {{ $college->name }}
			
			</h1>

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="border bg-light rounded mt-4 p-3">
            <h2>Users</h2>
            <div class="display-1">{{ $college->users()->count() }}</div>
          </div>

        </div>
        
        <div class="col-12 col-md-3">
          <div class="border rounded mt-4 p-3">
            <h2>PREMIUM</h2>
            <div class="display-1">{{ $college->users()->whereHas('services', function ($query)  {
                            $query->where('name', '=', 'Premium Access');
                        })->count() }}</div>
          </div>

        </div>
        <div class="col-12 col-md-3">
          <div class="border rounded mt-4 p-3">
            <h2>PRO</h2>
            <div class="display-1">{{ $college->users()->whereHas('services', function ($query)  {
                            $query->where('name', '=', 'Pro Access');
                        })->count() }}</div>
          </div>

        </div>

      </div>
      
      


		</div>
		<div class="col-12 col-md-3">

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
   
	   <div class="bg-white p-4 border mb-3">
      <h1  class="border p-3 mb-3"> Branches</h1>
      <div class="row">
        
        @foreach($college->branches as $b)
        <div class="col-12 col-md-2">
          <h1 class="mb-4"> {{ $b->name }} </h1>
          <p> {{ $college->users()->whereHas('branches', function ($query) use ($b) {
                            $query->where('name', '=', $b->name);
                        })->count() }}</p>
      
        </div>
        @endforeach
        
     </div>

   </div>

   <div class="bg-white p-4 border mb-3">
      <h1  class="border p-3 mb-3"> Metrics</h1>
      <div class="row">
        @foreach($metrics as $m)
        <div class="col-12 col-md-4">
          <div class="border rounded p-3 mb-3">
          <h4 class="mb-4"> {{ $m->name }} </h4>
          <p> {{ $college->users()->whereHas('metrics', function ($query) use ($m) {
                            $query->where('name', '=', $m->name);
                        })->count() }}</p>
                      </div>
      
        </div>
        @endforeach
        
     </div>

   </div>
 

   

   
 
      
   </div>


     </div>   
</div>

@endsection           