@extends('layouts.app')

@section('title', 'Admin Analytics - Test | PacketPrep')
@section('description', 'Packetprep Admin page data')
@section('keywords', 'packetprep, admin page')


@section('content')



<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Admin</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-10">
 
        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-dashboard"></i> Test Analytics  </a>


        </nav>
          
        

    <div class="row">
    <div class="col-12 col-md-4">
      <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          College & Test
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form method="get" action="{{ route('admin.analytics.test')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">College</label>
    <input type="text" class="form-control" name="college" placeholder="Enter college id" value = "{{ (request()->get('college'))?request()->get('college'):''}}">
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Branch</label>
    <input type="text" class="form-control" name="branch" placeholder="Enter Branch id" value="{{ (request()->get('branch'))?request()->get('branch'):''}}">
  </div>
  <hr>
  <div class="form-group">
    <label for="exampleInputEmail1">Test</label>
    <input type="text" class="form-control" name="test" placeholder="Enter Test id" value="{{ (request()->get('test'))?request()->get('test'):''}}">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          Student & Test
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
         <form method="get" action="{{ route('admin.analytics.test')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">Student</label>
    <input type="text" class="form-control" name="student" placeholder="Enter Student id" value ="{{ (request()->get('student'))?request()->get('student'):''}}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Test</label>
    <input type="text" class="form-control" name="test" placeholder="Enter Test id" value ="{{ (request()->get('test'))?request()->get('test'):''}}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>
  </div>
</div>


    </div>

    <div class="col-12 col-md-8"> 
      
      <p class="p-3 border mb-3 ml-0">
            Participants : 
            @if(isset($data['user'])) {{ $data['user']->name }} @else
            <b>{{ count($data['active']) }}</b> 
            @endif
            <br>
          Test : <b>@if($data['test']) {{$data['test']->name }}@else All Tests {{count($data['tests'])}}@endif</b> 
          <br> Count: <b>{{ count($data['tests'])}}</b> 
          <br> College: <b>@if($data['college']) {{$data['college']->name }}@else All Colleges @endif</b> 
          <br> Branch: <b>@if($data['branch']) {{$data['branch']->name }}@else All Branches @endif</b>

         
          </p>

      @foreach($data['tests'] as $t)
      <p> Test id : {{ $t->test_id }} | User id : {{$t->user_id}}</p>
      <div class="row">
        <div class="col-12 col-md-6"> 
          <div class="mb-3 ml-3 ml-md-0 mr-3">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-users fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Correct <div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $t->correct }} </div>
            </div>

            </div>
          </div>
        </div>
        </div>

        <div class="col-12 col-md-6"> 
          <div class="mb-3 ml-3 ml-md-0 mr-3">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-font-awesome fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            InCorrect <div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $t->incorrect}} </div>
            </div>

            </div>
          </div>
        </div>
        </div>

        <div class="col-12 col-md-6 "> 
          <div class="mb-3 ml-3 ml-md-0 mr-3">
          <div class="row  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-area-chart fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Time<div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{$t->time}} </div>
            </div>

            </div>
          </div>
        </div>
        </div>

        <div class="col-12 col-md-6 "> 
          <div class="mb-3 ml-3 ml-md-0 mr-3">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-clock-o fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Score<div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $t->score}} </div>
            </div>

            </div>
          </div>
        </div>
        </div>


      </div>
      @endforeach

     </div>
   </div>

 </div>
  <div class="col-md-2 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


