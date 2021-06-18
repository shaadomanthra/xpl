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
           <a href="{{ route('test.report',$exam->slug)}}?score=1&refresh=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-outline-success btn-sm "> sort by score</a>
           @else
           <a href="{{ route('test.report',$exam->slug)}}?score=0&refresh=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-outline-success btn-sm   "> sort by date</a>
           @endif
           @endif

           <a href="{{ route('test.analytics',$exam->slug)}}?all=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif" class="btn  btn-outline-primary btn-sm   "> <i class="fa fa-pie-chart"></i> Performance</a>
            

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2 mb-3 mb-md-0">
        <div class="row">
          <div class="col-4 col-md-4">
          @if($exam->slug!='psychometric-test')
          @if(\auth::user()->checkRole(['administrator']) || \auth::user()->role==11 || \auth::user()->role ==12 || \auth::user()->role ==13 || \auth::user()->role ==10 )
          <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-download"></i>&nbsp; Excel
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{ route('test.report',$exam->slug)}}?export=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif">Scores</a>
              <a class="dropdown-item" href="{{ route('test.report',$exam->slug)}}?export=1&all=1 @if(request()->get('code'))&code={{request()->get('code')}}@endif">Scores + Academic Percentage</a>
            </div>
          </div>

       
          @endif
         @endif
       </div>
       <div class="col-8 col-md-8">
          <form class="form-inline mr-3 " method="GET" action="{{ route('test.report',$exam->slug) }}">

            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search"
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
          </form>
        </div>
      </div>



        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">

  <div class="alert alert-important alert-info mt-3">
    Data is cached for faster access. Refresh Cache to load the updated data.
    <a href="{{request()->url()}}?refresh=1">
    <span class="float-right"><i class="fa fa-retweet"></i> Refresh Now</span>
    </a>
  </div>

<div  class="  mb-4 mt-4">

  <div class="row mb-3">
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class=" p-3 rounded" style="background: #f9f6ff;border:1px solid #d7d1e8">
          <h5>Total Attempts</h5>
          <div class="display-3">{{count($r)}}</div>
        </div>
      </div>
      <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="p-3 rounded" style="background: #f6fff7;border:1px solid #c9e2cc">
          <h5 class="text-success"><i class="fa fa-check-circle"></i> No Cheating</h5>
          <div class="display-3">
            @if(isset($r->groupBy('cheat_detect')[0]) && isset($r->groupBy('cheat_detect')['']))
              {{(count($r->groupBy('cheat_detect')[0]) + count($r->groupBy('cheat_detect')['']))}}
            @elseif(isset($r->groupBy('cheat_detect')[0]))
            {{ count($r->groupBy('cheat_detect')[0]) }}
            @elseif(isset($r->groupBy('cheat_detect')['']))
            {{ count($r->groupBy('cheat_detect')['']) }}
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
            @if(isset($r->groupBy('cheat_detect')[1]))
            {{count($r->groupBy('cheat_detect')[1])}}
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
            @if(isset($r->groupBy('cheat_detect')[2]))
            {{count($r->groupBy('cheat_detect')[2])}}
            @else
              -
            @endif
          </div>
        </div>
      </div>
      

  </div>

  <div id="search-items">
   @include('appl.exam.exam.analytics_list')

       </div>


 </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shortlist Tools</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning alert-important" role="alert">
          This is a warning alert—check it out!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade " id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="" id="">
        <div class="p-3 loading">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div> Loading...

        </div>
        <div id="user_data">
      </div>


      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
