@extends('layouts.nowrap-white')
@section('title', 'Job Posts')
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/post')}}">Job Posts</a></li>
            <li class="breadcrumb-item">Candidate Applications</li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-6">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-th "></i> Candidate Applications
          </p>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="mt-2">
         

         <form class="w-100" method="GET" action="{{ route('job.candidate') }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="" name="item" autocomplete="off" type="search" placeholder="Search by phone number" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>

@include('flash::message')
<div  class="container">
  <div  class="  mb-4 mt-4">
        <div id="search-items">
         @if($applications)
         <div class="card mb-4">
            <div class="card-body bg-light">
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>Name</b>
                </div>
                <div class="col-12 col-md-8">
                  <div class="display-4">{{$candidate->name}}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>Phone</b>
                </div>
                <div class="col-12 col-md-8">
                  {{$candidate->phone}}
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>Email</b>
                </div>
                <div class="col-12 col-md-8">
                  {{$candidate->email}}
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>College</b>
                </div>
                <div class="col-12 col-md-8">
                  {{$candidate->college->name}}
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>Branch</b>
                </div>
                <div class="col-12 col-md-8">
                  {{$candidate->branch->name}}
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4"> 
                  <b>Batch</b>
                </div>
                <div class="col-12 col-md-8">
                  {{$candidate->info}}
                </div>
              </div>
            </div>
         </div>
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Job Opening </th>
                <th scope="col">Applied On</th>
              </tr>
            </thead>
            <tbody>
              @foreach($applications as $key=>$obj)  
              <tr id="tr{{$obj['id']}}" @if($obj['pivot']['shortlisted']=="YES")
                  style='background: #dffbe2' 
                @elseif($obj['pivot']['shortlisted']=="MAYBE")
                  style='background: #ffffed' 
                @elseif($obj['pivot']['shortlisted']=="NO")
                  style='background: #fff3f3'
                @endif>

                <th scope="row">{{  ($key+1) }}</th>
                <td>
                  {{$obj['title']}}
                </td>
                
                <td>
                  {{$obj['pivot']['created_at']->format('M d Y')}}
                </td>
               
                
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No candidate application listed
        </div>
        @endif
       </div>
  </div>
</div>

@endsection


