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
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-university"></i> &nbsp; {{ $college->name }}
			
			</h1>
      

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="border bg-light rounded mt-4 p-3">
            <h2>Users</h2>
            <div class="display-1"><a href="{{ route('college.students',$college->id)}}">{{ $data['users']['all']  }}</a></div>
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
		<div class="col-12 col-md-4">

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

      <div class="row">
        <div class="col-12 col-md-4">
          <form method="get"  action="{{route('college.view',$college->id)}}" >
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

            @foreach($college->branches as $b)
            <tr>
              <td>{{ $b->name }} </td>
              <td><a href="{{ route('college.students',$college->id)}}?branch={{$b->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['branches'][$b->name] }}</a></td>
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
                  <div class="display-2" ><a href="{{ route('college.students',$college->id)}}?metric=JOB @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif"> {{ $data['metrics']['JOB'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Banking Job </h4>
                  <div class="display-2"> <a href="{{ route('college.students',$college->id)}}?metric=Banking Job @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $data['metrics']['Banking Job'] }}</a></div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Government Job </h4>
                  <div class="display-2"> {{ $data['metrics']['Government Job'] }}</div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> Private Job</h4>
                  <div class="display-2"> {{ $data['metrics']['Private Job'] }}</div>
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
                  <div class="display-2" > {{ $data['metrics']['Higher Studies'] }}</div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MBA </h4>
                  <div class="display-2"> {{ $data['metrics']['MBA'] }}</div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MTECH </h4>
                  <div class="display-2"> {{ $data['metrics']['MTECH'] }}</div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MS in Abroad</h4>
                  <div class="display-2"> {{ $data['metrics']['MS in Abroad'] }}</div>
                  </div>
              </div>
              <div class="col-12 col-md-3">
                  <div class="  p-3 mb-3">
                  <h4 class="mb-4"> MSC/MCOM</h4>
                  <div class="display-2"> {{ $data['metrics']['MSC/MCOM'] }}</div>
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
            <div class="display-2"> {{ $data['metrics']['Computer Programming'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4"> Communication </h4>
            <div class="display-2"> {{ $data['metrics']['Spoken English'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="border  p-3 mb-3">
            <h4 class="mb-4">MS Office</h4>
            <div class="display-2"> {{ $data['metrics']['MS Office'] }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">Matlab</h4>
            <div class="display-2"> {{ $data['metrics']['Matlab'] }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">AutoCAD</h4>
            <div class="display-2"> {{ $data['metrics']['AutoCAD'] }}</div>
            </div>
        </div>

        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">Tally</h4>
            <div class="display-2"> {{ $data['metrics']['Tally'] }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
          <div class=" border p-3 mb-3">
            <h4 class="mb-4">Animation</h4>
            <div class="display-2"> {{ $data['metrics']['Animation'] }}</div>
            </div>
        </div>

        
      </div>
      
   </div>


     </div>   
</div>

@endsection           