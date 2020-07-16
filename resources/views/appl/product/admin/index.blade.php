@extends('layouts.app')
@section('title', 'Admin | Xplore')
@section('description', 'Xplore Admin page data')
@section('keywords', 'xplore, admin page')
@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Admin</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-dashboard"></i> Admin </a>

          
          <a href="{{ route('college.top30')}}"><button class="btn btn-sm btn-outline-primary"><i class="fa fa-print"></i> Top Colleges </button></a>
        </nav>

        <div class="row no-gutters bg-light  border p-3 mb-4 ">
            <div class="col-12 col-md-4">
              <div class=" p-3 mb-3  bg-light mr-md-2">
                <div class="">
                  <h3>Total Users</h3>
                    <div class="display-1"><i class="fa fa-user"></i> {{ $data['users']['total'] }}</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Month</h3>
                    <div class="display-4 mb-4">{{ $data['users']['this_month']  }}</div>
                  <h3 class="card-title">Last Month</h3>
                    <div class="display-4">{{ $data['users']['last_month']  }}</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Year</h3>
                    <div class="display-4 mb-4">{{ $data['users']['this_year']  }}</div>
                  <h3 class="card-title">Last Year</h3>
                    <div class="display-4">{{ $data['users']['last_year']  }}</div>
                  
                </div>
              </div>
            </div>
            
        </div>

        

        <div class="row no-gutters">

          <div class="col-12 col-md-12">

     <div class="bg-white p-4 border mb-3">

      <div class="row">
        <div class="col-12 col-md-6">
            <h1  class="border p-3 mb-3"> Zones</h1>
          <table class="table table-bordered">
            <tr>
              <th>Zone</th>
              <th>Colleges</th>
              <th>Students</th>
            </tr>

            @foreach($zones as $z)
            @if(isset($data['zone'][$z->name]['colleges'] )) 
            <tr>
              <td><a href="{{ route('zone.view', $z->id)}}">{{ $z->name }} </a></td>
              <td> {{ $data['zone'][$z->name]['colleges'] }} </td>
              <td><a href="{{ route('zone.students',$z->id)}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['zone'][$z->name]['users'] }}</a></td>
            </tr>
            @endif 
            @endforeach

          </table>
        </div>

        <div class="col-12 col-md-6">
          <h1  class="border p-3 mb-3"> Branches</h1>
          <table class="table table-bordered">
            <tr>
              <th>Branch</th>
              <th>Number of students</th>
            </tr>

            @foreach($branches as $b)
            <tr>
              <td><a href="{{ route('branch.view', $b->id)}}">{{ $b->name }} </a></td>
              <td><a href="{{ route('branch.students',$b->id)}}?branch={{$b->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">@if(isset($data['branch'][$b->name])){{ $data['branch'][$b->name]}}@else 0 @endif</a></td>
            </tr> 
            @endforeach

          </table>
      
          
        </div>
      </div>
      

   </div>


   <div class="bg-white p-4 border mb-3">
      <h1  class="border rounded p-3 mb-3"> Career Path </h1>
      <div class="row">
        <div class="col-6 col-md-2">
            <img src="{{ asset('/img/job.png')}}" class="w-100 p-3 pt-0"/>  
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','JOB')}}"> JOB </a></h4>
                  <div class="display-2" ><a href="{{ route('metric.students','JOB')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metric']['JOB'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Banking Job')}}"> Banking Job </a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Banking Job')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Banking Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Government Job')}}">Government Job </a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Government Job ') }} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Government Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Private Job')}}"> Private Job</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Private Job')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Private Job'] }}</a></div>
                  </div>
              </div>
          </div>
        </div>
      </div>

      <hr>

         <div class="row">
        <div class="col-6 col-md-2">
            <img src="{{ asset('/img/hs.png')}}" class="w-100 p-3 pt-0"/>  
        </div>
        <div class="col-12 col-md-10">
          <div class="row">
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Higher Studies')}}"> Higher Studies</a> </h4>
                  <div class="display-2" > <a href="{{ route('metric.students','Higher Studies')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Higher Studies'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MBA')}}"> MBA</a> </h4>
                  <div class="display-2"><a href="{{ route('metric.students','MBA')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metric']['MBA'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MTECH')}}"> MTECH</a> </h4>
                  <div class="display-2"><a href="{{ route('metric.students','MTECH')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['MTECH'] }}</a></div>
                  </div>
              </div>
              
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MS in Abroad')}}"> MS in Abroad</a></h4>
                  <div class="display-2"><a href="{{ route('metric.students','MS in Abroad')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metric']['MS in Abroad'] }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MSC/MCOM')}}"> MSC/MCOM</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','MSC/MCOM')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['MSC/MCOM'] }}</a></div>
                  </div>
              </div>

              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Business')}}">Business</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Business')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Business'] }}</a></div>
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
            <div class="display-2"> <a href="{{ route('metric.students','Computer Programming')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Computer Programming'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Spoken English')}}"> Spoken English</a> </h4>
            <div class="display-2"><a href="{{ route('metric.students','Spoken English')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metric']['Spoken English'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','MS Office')}}">MS Office</a></h4>
            <div class="display-2"><a href="{{ route('metric.students','MS Office')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['MS Office'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Matlab')}}">Matlab</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','Matlab')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Matlab'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','AutoCAD')}}">AutoCAD</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','AutoCAD')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['AutoCAD'] }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Tally')}}">Tally</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','Tally')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Tally'] }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Animation')}}">Animation</a></h4>
            <div class="display-2"><a href="{{ route('metric.students','Animation')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metric']['Animation'] }}</a></div>
            </div>
        </div>

        
      </div>
      
   </div>

        </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


