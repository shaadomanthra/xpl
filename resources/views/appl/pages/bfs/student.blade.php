@extends('layouts.nowrap-white')
@section('title', 'Admin Dashboard ')
@section('description', 'Know you tests')
@section('keywords', '')
@section('content')

<div class="bg">
<div class="" style="background:#C9F7F5;border-bottom:1px solid #1BC5BD;margin-bottom:25px;">
  <div class="container">

    <div class="row py-4">
      <div class="col-12 col-md">
        
        <div class=' pb-1'>
          <p class="heading_two mb-1 f30 mt-3" >
            <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-2">
          <div class="text-center text-md-left">
            <img class="img-thumbnail rounded-circle mb-3 mt-2" src="@if(\auth::user()->image) {{ (\auth::user()->image)}} @else {{ Gravatar::src(\auth::user()->email, 150) }}@endif" style="width:120px;height:120px;">
          </div>
          </div>
          <div class="col-12 col-md-10">
            <div class='mt-3 text-center text-md-left'>
           <h2>Hi, {{  \auth::user()->name}}
            <div class="badge badge-success d-md-inline h5 mt-3 mt-md-0" data-toggle="tooltip" title="Account Type">
      Student
    </div>
           </h2>
      <p> Welcome aboard</p>
      <a class="btn btn-warning " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </div>
          </div>
        </div>
          </p>
        </div>
      </div>
      <div class="col-12 col-md-2">
        <div class="row mt-4">
          <div class="col-12 ">
            <div class="card card-custom card-stretch gutter-b mt-md-3 text-center" style=''>
              <div class="card-body">
          <div class="h6">My Trainings</div>
          <div class="display-4 mb-0" ><a href="{{ route('user.list')}}" data-toggle="tooltip" title="View Users">{{$user->trainings->count()}}</a></div>
        </div>
      </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

<div class="container  ">
<div class="row">
      @include('appl.pages.bfs.icons.student')
  </div>  

</div>
@endsection           