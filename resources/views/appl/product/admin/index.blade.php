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
            <div class="col-12 col-md-6">
              <div class=" p-3 mb-3  bg-light mr-md-2">
                <div class="">
                  <h3>Total Users</h3>
                    <div class="display-1"><i class="fa fa-user"></i> {{ $data['users']['total'] }}</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Month</h3>
                    <div class="display-4 ">{{ $data['users']['this_month']  }}</div>
                  
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">Last Month</h3>
                    <div class="display-4">{{ $data['users']['last_month']  }}</div>
                  
                </div>
              </div>
            </div>
            
        </div>

        

        <div class="row no-gutters">

          <div class="col-12 col-md-12">

     <div class="bg-white p-4 border mb-3">

      <div class="row">
        <div class="col-12 col-md-6">
            <h1  class="border p-3 mb-3"> Metrics</h1>
          <table class="table table-bordered">
            <tr>
              <th>Metrics</th>
              <th>Number of Students</th>
            </tr>

            @foreach($metrics as $m)
            <tr>
              <td><a href="{{ route('metric.view', $m->id)}}">{{ $m->name }} </a></td>
              <td><a href="{{ route('metric.students',$m->id)}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $m->users_count }}</a></td>
            </tr>
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
              <td><a href="{{ route('branch.students',$b->id)}}?branch={{$b->name}} @if(request()->get('year_of_passing')) &year_of_passing={{request()->get('year_of_passing')}} @endif">{{ $b->users_count}}</a></td>
            </tr> 
            @endforeach

          </table>
      
          
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


