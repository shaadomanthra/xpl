@extends('layouts.app')
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

        </nav>

        <div class="row no-gutters">
            <div class="col-12 col-md-4">
              <div class="card mb-3 mr-md-2">
                <div class="card-body">
                  <h3>Total Users</h3>
                    <div class="display-1"><i class="fa fa-user"></i> {{ $users->total }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Month</h3>
                    <div class="display-4 mb-4">{{ $users->this_month }}</div>
                  <h3 class="card-title">Last Month</h3>
                    <div class="display-4">{{ $users->last_month }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="card mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">This Year</h3>
                    <div class="display-4 mb-4">{{ $users->this_year }}</div>
                  <h3 class="card-title">Last Year</h3>
                    <div class="display-4">{{ $users->last_year }}</div>
                  
                </div>
              </div>
            </div>
            
        </div>

        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-bar-chart"></i> Metrics</a>

        </nav>

        <div class="row no-gutters">

          @foreach($metrics as $metric)
          <div class="col-12 col-md-4">
              <div class="card bg-light mb-3 ml-md-2">
                <div class="card-body">
                  <h3 class="card-title">{{ $metric->name }}</h3>
                    <div class="display-4 mb-4"><a href=" {{ route('admin.user') }}?metric={{$metric->name}} ">{{ $metric->users->count() }}</a></div>
                </div>
              </div>
            </div>
            @endforeach

        </div>

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


