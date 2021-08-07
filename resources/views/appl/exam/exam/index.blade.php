@extends('layouts.nowrap-white')
@section('title', 'Tests')
@section('content')


@include('appl.exam.exam.xp_css')


<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item">Tests</li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-inbox "></i> Tests

            @can('create',$exam)
            <a href="{{route('exam.create')}}">
              <button type="button" class="btn btn-success float-right my-2 my-sm-2 ">Create </button>
            </a>
            @endcan

            @if(\auth::user()->isAdmin())
            <a href="{{route('examtype.index')}}">
              <button type="button" class="btn btn-outline-primary my-2 my-sm-2 mr-sm-3">Testtypes</button>
            </a>
            <a href="{{route('exam.index')}}?refresh=1">
              <button type="button" class="btn btn-secondary my-2 my-sm-2 ">Refresh Cache</button>
            </a>
            <a href="{{route('exam.createexam')}}">
              <button type="button" class="btn btn-primary float-right my-2 mr-sm-2 ">Generate </button>
            </a>
            @endif
          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2">
         

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
<div class='p-1  ddblue' >
</div>

@include('flash::message')

  <div class="container">
 
    <div class="pt-4 pb-4 mb-3 mb-md-0">
      <div class="row mb-0 no-gutters">

      <div class="col-12 col-md-10">
         <div id="search-items">
         @include('appl.exam.exam.list')
       </div>

      </div>  
      <div class="col-12 col-md-2">
         @if(subdomain() != strtolower(env('APP_NAME')))
     
          <div class="list-group mt-4 mt-md-0 ml-0 ml-md-3">
            <a href="#" class="list-group-item list-group-item-action  disabled">
               <i class="fa fa-bars"></i> Testtypes
            </a>
            <a href="{{ route('exam.index')}}" class="list-group-item list-group-item-action  {{  (request()->has('testtype')) ? '' : 'active'  }} ">
               All Tests
            </a>
            @foreach($examtypes as $et)
            <a href="{{ route('exam.index')}}?testtype={{$et->slug}}" class="list-group-item list-group-item-action  {{  (request()->get('testtype')==$et->slug) ? 'active' : ''  }} ">
               {{ $et->name }} 
            </a>
            @endforeach
          </div>
   
        @endif

      </div>  
       

     </div>
   </div>

</div>

@endsection


