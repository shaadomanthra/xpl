@extends('layouts.nowrap-product')
@section('title', $obj->name.' | PacketPrep')
@section('description', 'This page is about the statistics of the metric - '.$obj->name)
@section('keywords', 'obj,packetprep,'.$obj->name)

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-9">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-map-marker"></i> &nbsp; {{ $obj->name }} <a href="{{ route($app->module.'.edit',$obj->id) }}" class="" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
			
			</h1>
      
      

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="border bg-light rounded mt-4 p-3">
            <h2>Users</h2>
            <div class="display-1"><a href="{{ route('metric.students',$obj->id)}}">{{ $data['users']['all']  }}</a></div>
          </div>

        </div>

      </div>

		</div>
		<div class="col-12 col-md-3">
      

       <div class="float-right ">
          <img src="{{ asset('/img/metric.jpg')}}" class="w-100 p-3 pt-0"/>    
      </div>
    

  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  

<div class="row">
  
  <div class="col-12 col-md-7">

     <div class="bg-white p-4 border mb-3">

      <div class="row">
        

        <div class="col-12 col-md-12">
          <h1  class="border p-3 mb-3"> Branches</h1>
          <table class="table table-bordered">
            <tr>
              <th>Branch</th>
              <th>Number of students</th>
            </tr>

            @foreach($obj->branches as $b)
            <tr>
              <td>{{ $b->name }} </td>
              <td><a href="{{ route('metric.students',$obj->id)}}?branch={{$b->name}}">{{ $data['branches'][$b->name] }}</a></td>
            </tr> 
            @endforeach

          </table>
      
          
        </div>
      </div>
      

   </div>





      
      
   </div>


<div class="col-12 col-md-5">
      <div class="bg-light ">
       
        
        <div class="list-group">
          <h1 href="#" class="list-group-item list-group-item-action active">Zones({{ count($data['zones'])}})</h1>
           @foreach($data['zones'] as $k=>$z)
         <a href="{{ route('metric.students',$obj->id)}}?zone={{$k}}" class="list-group-item list-group-item-action">{{ $k }} ({{ $z}})</a>
        @endforeach
        </div>

      </div>
  </div>
  </div>



</div>

   

     </div>   
</div>

@endsection           