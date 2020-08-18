@extends('layouts.nowrap-white')
@section('title', 'Live Data - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')
<style>
.progress-bar{padding:left:10px;}
</style>

<div class="dblue" >
  <div class="container">

   
    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">
       <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            
            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Participants </li>
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-bar-chart "></i> Live Tracking</p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Participants</div>
          <div class="h2" ><a href="#" >{{count($exam_cache)}}</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">

<div  class="row">

  

  <div class="col-md-9 {{$i=0}}">

@foreach($questions as $q => $question)
  <div class="card  my-3">
    <div class="card-body ">
      <div class="row no-gutters">
        <div class="col-2 col-md-2">
          <div class="pr-3 pb-2 " >
            <div class="text-center p-1 rounded  w100 qno  qyellow "  style="" data-qqno="{{$question->id}}">
              {{ $i=$i+1 }}
            </div>
          </div>
        </div>
        <div class="col-10 col-md-10">
          <div class="pt-1  disable-select">{!! $question->question!!}</div>
        </div>
      </div>

  @if($question->type=='maq')
    <div class="alert alert-info alert-important">Select one or more choices from the given options.</div>
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-2">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded  w100 @if (strpos('A', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" >
             A </div>
          </div>
        </div>
        <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->a!!}</div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-2">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded w100 @if (strpos('B', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" >
              B</div>
            </div>
          </div>
          <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-2">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded  w100 @if (strpos('C', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > C</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->c!!}</div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100 @if (strpos('D', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" >D</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->d!!}</div></div>
          </div>
          @endif

          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if (strpos('E', $question->answer) !== false) qgreen-border qgreen @else bg-light border @endif" > 
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class="pt-1 ">{!! $question->e!!}</div></div>
          </div>
          @endif

  @elseif($question->type=='mcq')
    @if($question->a)
    <div class="row no-gutters">
      <div class="col-3 col-md-2">
        <div class="pr-3 pb-2" >
          <div class="text-center p-1 rounded  w100  @if($question->answer=='A') qgreen-border qgreen @else bg-light border @endif" > A </div>
          </div>
        </div>

        <div class="col-9 col-md-10"><div class=" a">
          <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_a}}%;height:50px;color:black;background: silver" aria-valuenow="{{$question->opt_a}}" aria-valuemin="0" aria-valuemax="100"> 
                  <span class="px-2 float-left text-left">{!! $question->a!!}</span>
                </div>
              </div>
        </div></div>
      </div>
      @endif

      @if($question->b)
      <div class="row no-gutters">
        <div class="col-3 col-md-2">
          <div class="pr-3 pb-2" >
            <div class="text-center p-1 rounded  w100  @if($question->answer=='B') qgreen-border qgreen @else bg-light border @endif" >  B</div>
            </div>
          </div>
          <div class="col-9 col-md-10"><div class=" b">
            <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_b}}%;height:50px;color:black;background: silver;" aria-valuenow="{{$question->opt_b}}" aria-valuemin="0" aria-valuemax="100"> 
                  <span class="px-2 float-left text-left">{!! $question->b!!}</span>
                </div>
              </div>
          </div></div>
        </div>
        @endif

        @if($question->c)
        <div class="row no-gutters">
          <div class="col-3 col-md-2">
            <div class="pr-3 pb-2" >
              <div class="text-center p-1 rounded  w100  @if($question->answer=='C') qgreen-border qgreen @else bg-light border @endif " >C</div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class=" c">
              <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_c}}%;height:50px;color:black;background: silver" aria-valuenow="{{$question->opt_c}}" aria-valuemin="0" aria-valuemax="100"> 
                  <span class="px-2 float-left text-left">{!! $question->c!!}</span>
                </div>
              </div>
            </div></div>
          </div>
          @endif

          @if($question->d)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if($question->answer=='D') qgreen-border qgreen @else bg-light border @endif" >D</div>
              </div>
            </div>
            <div class="col-9 col-md-10">
              <div class=" d">
               <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_d}}%;height:50px;color:black;background: silver" aria-valuenow="{{$question->opt_d}}" aria-valuemin="0" aria-valuemax="100"> 
                  <span class="px-2 float-left text-left">{!! $question->d!!}</span>
                </div>
              </div>
              </div></div>
          </div>
          @endif


          @if($question->e)
          <div class="row no-gutters">
            <div class="col-3 col-md-2">
              <div class="pr-3 pb-2" >
                <div class="text-center p-1 rounded  w100  @if($question->answer=='E') qgreen-border qgreen @else bg-light border @endif" > 
                  E
                </div>
              </div>
            </div>
            <div class="col-9 col-md-10"><div class=" e">
              <div class="progress " style="height:32px;margin-top:1px;color:red">
                <div class="progress-bar" role="progressbar" style="width: {{$question->opt_e}}%;height:50px;color:black;background: silver" aria-valuenow="{{$question->opt_e}}" aria-valuemin="0" aria-valuemax="100"> 
                  <span class="px-2 float-left text-left">{!! $question->e!!}</span>
                </div>
              </div>
            </div></div>
          </div>
          @endif

      @endif
    </div>
  </div>
@endforeach
  </div>


 </div>
 
</div>



@endsection


