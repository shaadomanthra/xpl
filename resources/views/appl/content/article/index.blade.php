@extends('layouts.nowrap-product')

@if(!isset($label))

@section('title', 'Jobs | Xplore')
@section('description', 'This section is for latest jobs in the market for freshers')
@section('keywords', '')

@else

@section('title', $label->name.' Job | Xplore')
@section('description', substr(strip_tags($label->description),0,200) )
@section('keywords', $label->name)

@endif

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="mt-1 mb-2 mb-md-0">
      <i class="fa fa-th"></i> &nbsp; @if(isset($label)) {{ ucfirst($label->name)}} Jobs @elseif(isset($listing)) Job Listing (Adminview) @else Latest Jobs @endif

      @can('create',$obj)
            <a href="{{route($app->module.'.create')}}">
              <button type="button" class="btn btn-outline-success btn-sm my-2 my-sm-2 mr-sm-1">Create Job </button>
            </a>
            <a href="{{route('article.index')}}?refresh=1">
              <button type="button" class="btn btn-outline-primary btn-sm my-2 my-sm-2 mr-sm-3">Refresh Cache</button>
            </a>
      @endcan
      </h1>

      @if(isset($label))
      <div class="mb-3 mb-md-0">
      {{ $label->description }}
      </div>

      @endif

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
    
     <div class="row">
      <div class="col-12 col-md-9 col-lg-10">
        <div id="search-items">
           @include('appl.'.$app->app.'.'.$app->module.'.list')
         </div>

     </div>
     <div class="col-12 col-md-3 col-lg-2">
        <div class=" border rounded  text-white mb-4">
         <div class="list-group ">
        <a href="{{ route('article.index')}}" class="list-group-item list-group-item-action list-group-item-primary @if(!isset($label) && !isset($myblogs))  active @endif ">
          All Jobs
        </a>
        @if(\Auth::user())
        @if(\Auth::user()->checkRole(['administrator','manager','blog-writer','editor']))
        <a href="{{ route('label.index')}}" class="list-group-item list-group-item-action  ">
          Labels
        </a>
        <a href="{{ route('myblogs')}}" class="list-group-item list-group-item-action list-group-item-secondary @if(isset($myblogs))  active @endif ">
          My Jobs
        </a>
        <a href="{{ route('article.listing')}}" class="list-group-item list-group-item-action list-group-item-secondary ">
          Job Listing
        </a>
        @endif
        @endif

          </div>
        </div>

      @foreach($labels->groupBy('label') as $l => $item)
        <div class=" border rounded bg-info text-white mb-4">
          <h5 class="mb-0 p-3">{{strtoupper($l)}} </h5>
         <div class="list-group ">
        @foreach($item as $data)
        <a href="{{ route('blog.label',$data->slug)}}" class="list-group-item list-group-item-action list-group-item-primary @if(isset($label)) @if($label->slug==$data->slug) active @endif @endif">
          {{ ucfirst($data->name) }}
        </a>
        @endforeach
        
      
          </div>
        </div>
      @endforeach
      </div>

     </div>
  

     </div>   
</div>


@endsection           


