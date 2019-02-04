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
		<div class="col-12 col-md-9">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-map-marker"></i> &nbsp; {{ $obj->name }} <a href="{{ route($app->module.'.edit',$obj->id) }}" class="" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
			
			</h1>
      
      

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="border bg-light rounded mt-4 p-3">
            <h2>Users</h2>
            <div class="display-1"><a href="{{ route('zone.students',$obj->id)}}">{{ $data['users']['all']  }}</a></div>
          </div>

        </div>
        
        <div class="col-12 col-md-3">
          <div class="border rounded mt-4 p-3">
            <h2>PREMIUM</h2>
            <div class="display-1">{{ $data['users']['premium']  }}</div>
          </div>

        </div>
        <div class="col-12 col-md-3">
          <div class="border rounded mt-4 p-3">
            <h2>PRO</h2>
            <div class="display-1">{{ $data['users']['pro']  }}</div>
          </div>

        </div>

      </div>
      
      


		</div>
		<div class="col-12 col-md-3">
      

       <div class="float-right ">
          <img src="{{ asset('/img/map.jpg')}}" class="w-100 p-3 pt-0"/>    
      </div>
    

  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-5" >  

<div class="row">
  
  <div class="col-12 col-md-9">

     <div class="bg-white p-4 border mb-3">

      <div class="row">
        <div class="col-12 col-md-4">
          <form method="get"  action="{{route('zone.view',$obj->id)}}" >
      <div class="form-group">
        <h1  class="border p-3 mb-3">Year of Passing</h1>
        <select class="form-control year" name="year_of_passing">
          <option value="0" >All</option>
          @for($i=2019;$i < 2030;$i++)
          <option value="{{$i}}" @if(request()->get('year_of_passing')) @if(request()->get('year_of_passing')==$i) selected @endif @endif >{{ $i }}</option>
          @endfor         
        </select>
      </div>
      <button type="submit"  class="btn btn-primary">view</button>
    </form>
        </div>

        <div class="col-12 col-md-8">
          <h1  class="border p-3 mb-3"> Branches</h1>
          <table class="table table-bordered">
            <tr>
              <th>Branch</th>
              <th>Number of students</th>
            </tr>

            @foreach($obj->branches as $b)
            <tr>
              <td>{{ $b->name }} </td>
              <td><a href="{{ route('zone.students',$obj->id)}}?branch={{$b->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['branches'][$b->name] }}</a></td>
            </tr> 
            @endforeach

          </table>
      
          
        </div>
      </div>
      

   </div>


   <div class="bg-white p-4 border mb-3">
      <h1  class="border rounded p-3 mb-3"> Career Path </h1>
      <div class="row">
        <div class="col-12 col-md-2">
            <img src="{{ asset('/img/job.png')}}" class="w-100 p-3 pt-0"/>  
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> JOB </h4>
                  <div class="display-2" ><a href="{{ route('zone.students',$obj->id)}}?metric=JOB @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['JOB'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Banking Job </h4>
                  <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Banking Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Banking Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Government Job </h4>
                  <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Government Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Government Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Private Job</h4>
                  <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Private Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Private Job'] }}</a></div>
                  </div>
              </div>
          </div>
        </div>
      </div>

      <hr>

         <div class="row">
        <div class="col-12 col-md-2">
            <img src="{{ asset('/img/hs.png')}}" class="w-100 p-3 pt-0"/>  
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Higher Studies </h4>
                  <div class="display-2" > <a href="{{ route('zone.students',$obj->id)}}?metric=Higher Studies @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Higher Studies'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MBA </h4>
                  <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=MBA @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MBA'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MTECH </h4>
                  <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=MTECH @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MTECH'] }}</a></div>
                  </div>
              </div>
              
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MS in Abroad</h4>
                  <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=MS in Abroad @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MS in Abroad'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MSC/MCOM</h4>
                  <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=MSC/MCOM @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['MSC/MCOM'] }}</a></div>
                  </div>
              </div>

              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Business</h4>
                  <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Business @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Business'] }}</a></div>
                  </div>
              </div>
          </div>
        </div>

       
        
     </div>

   </div>


   <h1  class="border rounded p-3 mb-4"> Skills to Improve </h1>
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4"> Computer Programming</h4>
            <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Computer Programming @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Computer Programming'] }}</a></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"> Communication </h4>
            <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=Spoken English @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['Spoken English'] }}</a></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4">MS Office</h4>
            <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=MS Office @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MS Office'] }}</a></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">Matlab</h4>
            <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Matlab @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Matlab'] }}</a></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">AutoCAD</h4>
            <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=AutoCAD @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['AutoCAD'] }}</a></div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">Tally</h4>
            <div class="display-2"> <a href="{{ route('zone.students',$obj->id)}}?metric=Tally @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Tally'] }}</a></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Animation')}}">Animation</a></h4>
            <div class="display-2"><a href="{{ route('zone.students',$obj->id)}}?metric=Animation @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['Animation'] }}</a></div>
            </div>
        </div>

        
      </div>
      
   </div>


<div class="col-12 col-md-3">
      <div class="bg-light ">
       
        
        <div class="list-group">
          <h1 href="#" class="list-group-item list-group-item-action active">Colleges({{ count($obj->colleges)}})</h1>
           @foreach($obj->colleges as $college)
         <a href="{{ route('college.view',$college->id) }}" class="list-group-item list-group-item-action">{{ $college->name }} ({{ count($college->users)}})</a>
        @endforeach
        </div>

      </div>
  </div>
  </div>



</div>

   

     </div>   
</div>

@endsection           