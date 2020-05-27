@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/admin')}}">Admin</a></li>
    <li class="breadcrumb-item">Site managers</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> Site Managers </a>

         
        </nav>

        <div id="search-items">
         
 @if(count($users)!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{count($users)}})</th>
                <th scope="col">Name</th>
                <th scope="col">Total</th>
                <th scope="col">This month</th>
                <th scope="col">Last month</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$obj)  
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                  <a href=" {{ route('attempts') }}?user={{$obj->username}} ">
                  {{ $obj->name }}
                  </a>
                  @foreach($obj->roles()->get() as $k=> $r)
   
    @if($r->slug=='hr-manager')
     <span class="badge badge-warning">{{ $r->name }}</span>
    <span class="badge badge-info">
      @if($obj->role==10)
        Basic
      @elseif($obj->role==11)
        Pro
      @elseif($obj->role==12)
        Advanced
      @endif 
    </span><br>
    @endif
    
    @endforeach

    <div><i class="fa fa-angle-right"></i>@if($obj->client_slug) {{$obj->client_slug}} @else Xplore @endif</div>
                </td>
                <td>
                  {{$obj->attempts_all}}
                </td>
                <td>{{$obj->attempts_thismonth}}</td>
                <td>{{$obj->attempts_lastmonth}}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No hr managers listed
        </div>
        @endif

       </div>

     </div>
   </div>
 </div>
 <div class="col-md-3 pl-md-0 mb-3">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection


