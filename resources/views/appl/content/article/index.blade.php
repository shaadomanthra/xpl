


@extends('layouts.nowrap-product')
@section('title', 'Courses for Placement Preparation, Bank Exams and Government Jobs  | PacketPrep')
@section('description', 'The courses list include quantiative aptitude, logical reasoning, mental ability, verbal ability and interview skills')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills, bankpo, sbi po, ibps po, sbi clerk, ibps clerk, government job preparation, bank job preparation, campus recruitment training, crt, online lectures, gate preparation, gate lectures')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="mt-1 mb-2 mb-md-0">
      <i class="fa fa-th"></i> &nbsp;Articles
      @can('create',$obj)
            <a href="{{route($app->module.'.create')}}">
              <button type="button" class="btn btn-outline-success btn-sm my-2 my-sm-2 mr-sm-3">Create {{ ucfirst($app->module) }}</button>
            </a>
            @endcan
      </h1>

    </div>
    <div class="col-12 col-md-4">
      <form class="form-inline" method="GET" action="{{ route($app->module.'.index') }}">
          <div class="input-group w-100">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control form-control-lg " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
      </div>
  </div>
  </div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >  
    
     <div >
      <div id="search-items">
         @include('appl.'.$app->app.'.'.$app->module.'.list')
       </div>
     </div>
  


     </div>   
</div>

@endsection           


