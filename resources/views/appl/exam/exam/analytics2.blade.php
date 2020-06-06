@extends('layouts.nowrap-white')
@section('title', 'Participants - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Reports </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-area-chart "></i> Attempts (@if(request()->get('code'))  {{request()->get('code')}} @else All @endif) 

           @if($exam->slug!='psychometric-test')
           @if(!request()->get('score'))
           <a href="{{ route('test.report',$exam->slug)}}?score=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-outline-success btn-sm "> sort by score</a>
           @else
           <a href="{{ route('test.report',$exam->slug)}}?score=0 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-outline-success btn-sm   "> sort by date</a>
           @endif
           @endif 

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 ">
          @if($exam->slug!='psychometric-test')
          @if(\auth::user()->checkRole(['administrator']))
        <a href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-success float-right  "><i class="fa fa-download"></i>&nbsp; Excel</a>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 )
        <a href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-success float-right  "><i class="fa fa-download"></i>&nbsp; Excel</a>
        @else
        @endif

         
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

  <div class="row mb-3">
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class=" p-3 rounded" style="background: #f9f6ff;border:1px solid #d7d1e8">
          <h5>Total Attempts</h5>
          <div class="display-3">{{count($report)}}</div>
        </div>
      </div>
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="p-3 rounded" style="background: #f6fff7;border:1px solid #c9e2cc">
          <h5 class="text-success"><i class="fa fa-check-circle"></i> No Cheating</h5>
          <div class="display-3">
            @if(isset($report->groupBy('cheat_detect')[0]) && isset($report->groupBy('cheat_detect')['']))
              {{(count($report->groupBy('cheat_detect')[0]) + count($report->groupBy('cheat_detect')['']))}}
            @elseif(isset($report->groupBy('cheat_detect')[0]))
            {{ count($report->groupBy('cheat_detect')[0]) }}
            @elseif(isset($report->groupBy('cheat_detect')['']))
            {{ count($report->groupBy('cheat_detect')['']) }}
            @else
              -
            @endif
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3 ">
        <div class=" p-3 rounded " style="background: #fff6f6;border:1px solid #efd7d7">
          <h5 class="text-danger"><i class="fa fa-times-circle"></i> Potential Cheating</h5>
          <div class="display-3">
            @if(isset($report->groupBy('cheat_detect')[1]))
            {{count($report->groupBy('cheat_detect')[1])}}
            @else
              -
            @endif
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3 ">
        <div class=" p-3 rounded" style="background: #fffdf6;border:1px solid #ece8d5">
          <h5 class="text-warning"><i class="fa fa-ban"></i> Cheating - Not Clear</h5>
          <div class="display-3">
            @if(isset($report->groupBy('cheat_detect')[2]))
            {{count($report->groupBy('cheat_detect')[2])}}
            @else
              -
            @endif
          </div>
        </div>
      </div>
  </div>

  <div id="search-items">
   @include('appl.exam.exam.analytics_list2')

       </div>


 </div>
 
</div>

@endsection


