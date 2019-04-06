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
 
    <div class="">
      <div class="mb-0">
        <nav class="navbar navbar-light bg-white justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-dashboard"></i> Analytics </a>

        </nav>

        <div class="row no-gutters bg-light  border p-3 mb-4 ">
            <div class="col-12 col-md-6">
              <div class=" p-3 mb-3  bg-light mr-md-2">
                <div class="">
                  <h3>Practiced</h3>
                    <div class="display-1"><i class="fa fa-link"></i> {{ $data['solved'] }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class=" p-3 mb-3  bg-light mr-md-2">
                <div class="">
                  <h3>Active Users</h3>
                    <div class="display-1"><i class="fa fa-user"></i> {{ count($data['active']) }}</div>
                </div>
              </div>
            </div>
            
            
        </div>

        

        <div class="row no-gutters">

          <div class="col-12 col-md-12">

   





   <div class="bg-white">

   <h1  class="border rounded p-3 mb-4"> Top Users </h1>
   		<div class="table-responsive ">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col" style="width: 10%">Name </th>
                <th scope="col">College</th>
                <th scope="col">Branch</th>
                <th scope="col">Questions Solved</th>
              </tr>
            </thead>
            <tbody>
            	@foreach($data['top'] as $k=>$u)
              <tr>
                <th scope="row">{{ ($k+1) }}</th>
                <td> {{$u->name }}</td>
                <td> {{ $u->colleges->first()->name}}</td>
                <td> {{ $u->branches->first()->name}}</td>
                <td> {{ $data['count'][$k] }}</td>
              </tr> 
              @endforeach
            
            </tbody>
          </table>
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


