@extends('layouts.plain')
@section('content')


@include('flash::message')
<div  class="row ">
  <div class="col-4">
  <div class="row no-gutters bg-light  border p-3 mb-4 ">
            <div class="col-12 ">
              <div class=" p-3 mb-3  bg-light mr-md-2">
                
                  <h3>Total Users</h3>
                    <div class="display-1 mb-4">
                      <i class="fa fa-user"></i> {{ $users->total }}
                    </div>
                    <h3> Campus Ambassadors</h3>
                    <div class="display-3"> {{ $users->ambassadors }}
                    </div>
                    
              </div>


            </div>
            <div class="">
                  <div class="col-12 ">
          <h1  class="border p-3 mb-3"> Branches</h1>
          <table class="table table-bordered">
            <tr>
              <th>Branch</th>
              <th>Students</th>
            </tr>

            @foreach($branches as $b)
            @if($b->name != 'MCA' && $b->name != 'Mechatronics' && $b->name != 'CHEMICAL' )
            <tr>
              <td><a href="{{ route('branch.view', $b->id)}}">{{ $b->name }} </a></td>
              <td><a href="{{ route('branch.students',$b->id)}}?branch={{$b->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $b->users->count() }}</a></td>
            </tr> 
            @endif
            @endforeach

          </table>
      
          
        </div>
              </div>
            
            
        </div>
 </div>

  <div class="col-md-8">
 
    <div class="">
      <div class="mb-0">

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
                  <div class="display-2" ><a href="{{ route('metric.students','JOB')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $metrics->where('name','JOB')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Banking Job')}}"> Banking Job </a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Banking Job')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Banking Job')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Government Job')}}">Government Job </a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Government Job ') }} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Government Job')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','Private Job')}}"> Private Job</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Private Job')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Private Job')->first()->users()->count() }}</a></div>
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
                  <div class="display-2" > <a href="{{ route('metric.students','Higher Studies')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Higher Studies')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MBA')}}"> MBA</a> </h4>
                  <div class="display-2"><a href="{{ route('metric.students','MBA')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $metrics->where('name','MBA')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MTECH')}}"> MTECH</a> </h4>
                  <div class="display-2"><a href="{{ route('metric.students','MTECH')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','MTECH')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MS in Abroad')}}"> MS in Abroad</a></h4>
                  <div class="display-2"><a href="{{ route('metric.students','MS in Abroad')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $metrics->where('name','MS in Abroad')->first()->users()->count() }}</a></div>
                  </div>
              </div>
              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"><a href="{{ route('metric.view','MSC/MCOM')}}"> MSC/MCOM</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','MSC/MCOM')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','MSC/MCOM')->first()->users()->count() }}</a></div>
                  </div>
              </div>

              <div class="col-6 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> <a href="{{ route('metric.view','Business')}}">Business</a></h4>
                  <div class="display-2"> <a href="{{ route('metric.students','Business')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Business')->first()->users()->count() }}</a></div>
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
            <div class="display-2"> <a href="{{ route('metric.students','Computer Programming')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Computer Programming')->first()->users()->count() }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Spoken English')}}"> Communication</a> </h4>
            <div class="display-2"><a href="{{ route('metric.students','Spoken English')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $metrics->where('name','Spoken English')->first()->users()->count() }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','MS Office')}}">MS Office</a></h4>
            <div class="display-2"><a href="{{ route('metric.students','MS Office')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','MS Office')->first()->users()->count() }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Matlab')}}">Matlab</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','Matlab')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Matlab')->first()->users()->count() }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','AutoCAD')}}">AutoCAD</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','AutoCAD')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','AutoCAD')->first()->users()->count() }}</a></div>
            </div>
        </div>

        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Tally')}}">Tally</a></h4>
            <div class="display-2"> <a href="{{ route('metric.students','Tally')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Tally')->first()->users()->count() }}</a></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"><a href="{{ route('metric.view','Animation')}}">Animation</a></h4>
            <div class="display-2"><a href="{{ route('metric.students','Animation')}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $metrics->where('name','Animation')->first()->users()->count() }}</a></div>
            </div>
        </div>

        
      </div>
      
   </div>

        </div>

     </div>

   </div>
 </div>

</div>

@endsection


