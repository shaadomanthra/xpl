@extends('layouts.app-metronic')
@section('title', 'Proctor Dashboard - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')
<style>
.progress-bar{padding:left:10px;}
.progress{position: relative;}
.fleft{ position: absolute;right:10px;top:18px; color:black;}
.fright{ position: absolute;left:10px;top:18px; color:black;}
</style>

<div class="mt-4 container" >

    <div class="row">
      <div class="col-12  col-md-5">
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30 " >
              <span class=""><i class="fa fa-image  text-primary"></i></span>
           Student - {{request()->get('type')}} ({{$total}})</p>
        </div>
      </div>
    </div>
  </div>
</div>




@include('flash::message')

<div class="px-5 container">
<div  class="row  no-gutters {{$i=0}}">

@if($pg->total()!=0)
@foreach($pg as $a => $b)
@if (strpos($b, 'jpg') !== false) 

<div class="col-6 col-md-2 ">
  <div class="card   mb-2 mx-1  ">
    <div class="p-3 ">

     
      <div class="">
            <div class="selfie_container">
              
              <a data-fancybox="gallery" href="{{  Storage::disk('s3')->url($b) }}">
              <img src="{{  Storage::disk('s3')->url($b) }}" class="rounded border w-100">
              </a>
              <small>{{  date("m/d/Y h:i:s A T",Storage::disk('s3')->lastModified($b))}}</small>
              
            </div>
           
          </div>
  
    </div>
  </div>
</div>
@endif
@endforeach
@endif

  
</div>

<nav aria-label="Page navigation  " class="card-nav @if($pg->total() > 16 )my-3 mb-5 @endif">
        {{$pg->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

</div>






@endsection


