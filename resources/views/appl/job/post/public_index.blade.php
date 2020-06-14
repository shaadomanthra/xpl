@extends('layouts.nowrap-white')
@section('title', 'Jobs - Xplore')
@section('content')

@include('appl.exam.exam.xp_css')

<div class="banner">
  <img src="{{ asset('img/jobs.jpg')}}" class=" w-100" />
</div>

<div class="bg-light ">
<div class="container ">
  <div class="row">
    <div class="col-12 col-md-9 mb-5">
      <div class="bg-white p-4 p-md-5 mb-4" style="margin-top:-50px">
        <h1>Xplore Jobs</h1>
      </div>
        <div  class="">
          @include('flash::message')
        <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.public_list')
       </div>
  </div>

    </div>
    <div class="col-12 col-md-3">

      <div class="mt-4">
         

         <form class="w-100" method="GET" action="{{ route('exam.index') }}">
            
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



@endsection


