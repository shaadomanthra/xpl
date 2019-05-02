@extends('layouts.app')

@section('title', 'Admin Analytics | PacketPrep')
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

  <div class="col-md-9">
 
        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-dashboard"></i> Analytics </a>


        </nav>
          
        

    <div class="row">
    <div class="col-12 col-md-4">
      <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          College & Course
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form method="get" action="{{ route('admin.analytics')}}">
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
    <label for="exampleInputEmail1">Course</label>
    <input type="text" class="form-control" name="course" placeholder="Enter Course id" value="{{ (request()->get('course'))?request()->get('course'):''}}">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          College & Topic
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
     <form method="get" action="{{ route('admin.analytics')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">College</label>
    <input type="text" class="form-control" name="college" placeholder="Enter college id" value = "{{ (request()->get('college'))?request()->get('college'):''}}">
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Branch</label>
    <input type="text" class="form-control" name="branch" placeholder="Enter Branch id" value="{{ (request()->get('branch'))?request()->get('branch'):''}}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Topic</label>
    <input type="text" class="form-control" name="category" placeholder="Enter Topic id" value ="{{ (request()->get('category'))?request()->get('category'):''}}">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Student & Course
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
         <form method="get" action="{{ route('admin.analytics')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">Student</label>
    <input type="text" class="form-control" name="student" placeholder="Enter Student id" value ="{{ (request()->get('student'))?request()->get('student'):''}}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Course</label>
    <input type="text" class="form-control" name="course" placeholder="Enter Course id" value="{{ (request()->get('course'))?request()->get('course'):''}}">
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
          Student & Topic
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
         <form method="get" action="{{ route('admin.analytics')}}">
  <div class="form-group">
    <label for="exampleInputEmail1">Student</label>
    <input type="text" class="form-control" name="student" placeholder="Enter Student id" value ="{{ (request()->get('student'))?request()->get('student'):''}}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Topic</label>
    <input type="text" class="form-control" name="category" placeholder="Enter Topic id" value ="{{ (request()->get('category'))?request()->get('category'):''}}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>
  </div>
</div>


    </div>

    <div class="col-12 col-md-8"> 
      
      <p class="p-3 border mb-3">
            Participants : 
            @if(isset($data['user'])) {{ $data['user']->name }} @else
            <b>{{ count($data['active']) }}</b> 
            @endif
            <br>
          Item : <b>@if($data['item']) {{$data['item']->name }}@else All Courses @endif</b> 
          <br> College: <b>@if($data['college']) {{$data['college']->name }}@else All Colleges @endif</b> 
          <br> Branch: <b>@if($data['branch']) {{$data['branch']->name }}@else All Branches @endif</b>

         
          </p>

      <div class="row">
        <div class="col-12 col-md-6"> 
          <div class="mb-3 ml-3 ml-md-0 mr-3">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-users fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Participants <div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ count($data['active']) }} </div>
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
            Questions Practiced <div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $data['solved']}} @if(isset($data['user']))/ {{ $data['total'] }} @endif </div>
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
            Performance Accuracy<div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($data['acurracy'])
            {{ $data['acurracy']}} %
          @else
          --
          @endif </div>
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
            Average Time per question<div style="font-size: 25px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($data['time'])
            {{ $data['time']}} sec
          @else
          --
          @endif </div>
            </div>

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


