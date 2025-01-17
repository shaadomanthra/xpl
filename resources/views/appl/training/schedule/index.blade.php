@extends('layouts.nowrap-white')
@section('title', 'Schedule - '.$app->training->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="bg">
<div class="dblue" >
  <div class="container p-5">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('training.index')}}">Trainings</a></li>
            <li class="breadcrumb-item"><a href="{{route('training.show',$app->training->slug)}}">{{$app->training->name}}</a></li>
            <li class="breadcrumb-item">Schedule</li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-calendar text-primary"></i> Schedule

            @can('create',$obj)
            <a href="{{route('schedule.create',$app->training->slug)}}">
              <button type="button" class="btn btn-success float-right my-2 my-sm-2 ">Create </button>
            </a>
            @endcan

            
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2">
         

         <form class="w-100" method="GET" action="{{ route('schedule.index',$app->training->slug) }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
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
  <div class="p-1"></div>
  <div  class="  mb-4 mt-4">
        <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.list')
       </div>
  </div>
</div>
</div>
@endsection


