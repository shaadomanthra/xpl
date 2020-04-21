@extends('layouts.nowrap-white')
@section('title', 'Participants - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Tests</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Reports </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-area-chart "></i> Attempts (@if(request()->get('code'))  {{request()->get('code')}} @else All @endif) - {{count($report)}}

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
          @if($exam->slug!='psychometric-test')
         <a href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-success float-right  "><i class="fa fa-download"></i>&nbsp; Excel</a>
         @endif
          <form class="form-inline mr-3 " method="GET" action="{{ route('test.report',$exam->slug) }}">
            
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
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">

<div  class="  mb-4 mt-4">

  <div id="search-items">
   @include('appl.exam.exam.analytics_list')

       </div>


 </div>
 
</div>

@endsection


