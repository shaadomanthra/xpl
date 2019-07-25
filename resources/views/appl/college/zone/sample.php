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
          <img src="{{ asset('/img/map.jpg')}}" class="w-100 p-3 pt-0"/>   
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
  
  <div class="col-12 col-md-8">

     


   <div class="bg-white p-4 border mb-3">
      <h1  class="border rounded p-3 mb-3"> Career Path </h1>
      <div class="row">
        <div class="col-12 col-md-2">
          <div class="row">
          <div class="col-6 col-md-12">
            <img src="{{ asset('/img/job.png')}}" class="w-100 p-3 pt-0"/>  
          </div>
          </div>
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','JOB')}}"> JOB </a></h4>
                  <div class="display-2" ><a href="{{ route('branch.students',$obj->id)}}?metric=JOB @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['JOB'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Banking Job')}}"> Banking Job </a></h4>
                  <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Banking Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Banking Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Government Job')}}">Government Job </a></h4>
                  <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Government Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Government Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Private Job')}}"> Private Job</a></h4>
                  <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Private Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Private Job'] }}</a></div>
                  </div>
              </div>
          </div>
        </div>
      </div>

      <hr>

         <div class="row">
        <div class="col-12 col-md-2">
          <div class="row">
          <div class="col-6 col-md-12">
            <img src="{{ asset('/img/hs.png')}}" class="w-100 p-3 pt-0"/>  
          </div>
        </div>
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Higher Studies')}}"> Higher Studies</a> </h4>
                  <div class="display-2" > <a href="{{ route('branch.students',$obj->id)}}?metric=Higher Studies @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Higher Studies'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MBA')}}"> MBA</a> </h4>
                  <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=MBA @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MBA'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MTECH')}}"> MTECH</a> </h4>
                  <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=MTECH @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MTECH'] }}</a></div>
                  </div>
              </div>
              
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MS in Abroad')}}"> MS in Abroad</a></h4>
                  <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=MS in Abroad @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MS in Abroad'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MSC/MCOM')}}"> MSC/MCOM</a></h4>
                  <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=MSC/MCOM @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['MSC/MCOM'] }}</a></div>
                  </div>
              </div>

              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Business')}}">Business</a></h4>
                  <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Business @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Business'] }}</a></div>
                  </div>
              </div>
          </div>
        </div>

       
        
     </div>

   </div>


   <h1  class="border rounded p-3 mb-4"> Skills to Improve </h1>
      <div class="row">
        <div class="col-6 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Computer Programming')}}"> Computer Programming</a></h4>
            <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Computer Programming @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Computer Programming'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Spoken English')}}"> Communication</a> </h4>
            <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=Spoken English @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['Spoken English'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','MS Office')}}">MS Office</a></h4>
            <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=MS Office @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['MS Office'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Matlab')}}">Matlab</a></h4>
            <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Matlab @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Matlab'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','AutoCAD')}}">AutoCAD</a></h4>
            <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=AutoCAD @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['AutoCAD'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Tally')}}">Tally</a></h4>
            <div class="display-2"> <a href="{{ route('branch.students',$obj->id)}}?metric=Tally @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Tally'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Animation')}}">Animation</a></h4>
            <div class="display-2"><a href="{{ route('branch.students',$obj->id)}}?metric=Animation @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['Animation'] }}</a></div>
            </div>
        </div>

        
      </div>
      
   </div>


<div class="col-12 col-md-4">
  
      <div class="bg-light ">


       
        
        <div class="list-group">
          <h1 href="#" class="list-group-item list-group-item-action active">Branches</h1>
           @foreach($obj->branches as $branch)
         <a href="{{ route('branch.view',$branch->id) }}?zone={{$obj->name}}" class="list-group-item list-group-item-action">{{ $branch->name }} ({{ $branch->count_zone($obj->name)}})</a>
        @endforeach
        </div>

      </div>
  </div>
  </div>



</div>

   

     </div>   
</div>

@endsection           