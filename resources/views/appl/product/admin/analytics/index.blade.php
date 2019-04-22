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
          <p class="p-3 border">
            Participants : 
            @if(isset($data['user'])) {{ $data['user']->name }} @else
            <b>{{ count($data['active']) }}</b> 
            @endif
            <br>
          Course: <b>@if($data['course']) {{$data['course']->name }}@else All Courses @endif</b> 
          <br> College: <b>@if($data['college']) {{$data['college']->name }}@else All Colleges @endif</b> 
          <br> Branch: <b>@if($data['branch']) {{$data['branch']->name }}@else All Branches @endif</b>

          <hr>
          <p>
            @foreach($data['t'] as $k=>$t)
              Time lapse {{$k}}: {{ $t}}<br>
            @endforeach
          </p> 
          </p>
        

        <div class="">
         

    <div class="pl-3 mb-0 mb-md-3 mt-0 mt-md-0"> 
      <div class="row">
        
        <div class="col-12 mb-3 mb-md-0 col-md-4"> 
          <div class="mr-3">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-font-awesome fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Questions Attempted <div style="font-size: 18px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $data['solved']}} / {{ $data['total'] }} </div>
            </div>

            </div>
          </div>
        </div>
        </div>

        <div class="col-12 mb-3 mb-md-0 col-md-4 "> 
          <div class="mr-3 mr-md-2 ml-0 ml-md-1">
          <div class="row  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-area-chart fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Performance Accuracy<div style="font-size: 18px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($data['acurracy'])
            {{ $data['acurracy']}} %
          @else
          --
          @endif </div>
            </div>

            </div>
          </div>
        </div>
        </div>

        <div class="col-12 mb-3 mb-md-0 col-md-4 "> 
          <div class="mr-3 ml-0 ml-md-2">
          <div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
            <div class="col-4"><div class="mt-2"><i class="fa fa-clock-o fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
            <div class="col-8">
            <div class="  " style="color: rgba(127, 166, 198, 0.93)">
            Average Time per question<div style="font-size: 18px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($data['time'])
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

        

        <div class="row no-gutters">

          <div class="col-12 col-md-12">

   





  @if(isset($data['top']))
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
                <td> @if($u->colleges->first())
                  {{ $u->colleges->first()->name}}
                    @endif
                </td>
                <td> @if($u->branches->first())
                  {{ $u->branches->first()->name}}
                  @endif
                </td>
                <td> {{ $data['count'][$k] }}</td>
              </tr> 
              @endforeach
            
            </tbody>
          </table>
        </div>
      </div>
      @endif
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


