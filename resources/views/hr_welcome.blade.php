@extends('layouts.nowrap-white')

@section('title', 'Dashboard ')

@section('description', 'Know you tests')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')

@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-1 f30 mt-3" >
            <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-2">
            <img class="img-thumbnail rounded-circle mb-3 mt-2" src="@if(\auth::user()->image) {{ (\auth::user()->image)}} @else {{ Gravatar::src(\auth::user()->email, 150) }}@endif" style="width:120px">
          </div>
          <div class="col-12 col-md-10">
            <p class='mt-3'>
           <h2>Hi, {{  \auth::user()->name}}</h2>
      <p> Welcome aboard</p>
      <a class="btn btn-warning " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </p>
          </div>
        </div>
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="row mt-4">
          <div class="col-12 col-md-6">
            <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Attempts</div>
          <div class="h2" >{{$user->attempts}}</div>
        </div>
          </div>
          <div class="col-12 col-md-6">
            <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Tests</div>
          <div class="h2" >{{ count($user->exams)}}</div>
        </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' >
</div>

<div class="container mt-4">






<div class="row ">
  @include('snippets.hr_tests')
</div>


  </div>

  
</div>

</div>
@endsection           