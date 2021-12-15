@extends('layouts.app-metronic')
@section('title', 'Logs - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')
<style>
.progress-bar{padding:left:10px;}
.progress{position: relative;}
.fleft{ position: absolute;right:10px;top:18px; color:black;}
.fright{ position: absolute;left:10px;top:18px; color:black;}
</style>

<div class="mt-4 container" style="max-width:600px">

    <div class="row">
      <div class="col-12  col-md-5">
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30 " >
              <span class=""><i class="fa fa-bars  text-primary"></i></span>
           Logs </p>
        </div>
      </div>
      <div class="col-12  col-md-7">
        <div class='pt-3 pb-3 text-right'>
          <h4>{{$user->name}}</h4>
<h5 class="text-primary">{{$user->roll_number}}</h5>
        </div>
      </div>
    </div>
  </div>
</div>




@include('flash::message')

<div class="p-5 container" style="max-width:600px">
<div  class="bg-white p-5" >

  <div class="pb-4">
    @if($content['last_photo'])
        <div class="p-3 border float-right">Lastest Capture<br>
        <img src="{{$content['last_photo']}}" class=" log_pic border" height="100px"  /></div>@endif
        <div class="">Name: <b><span class="log_name text-success">{{$content['uname']}}</span></b></div>
        <div>Roll Number: <b><span class="log_rollnumber text-primary">{{$content['rollnumber']}}</span></b></div>
        @if(isset($content['os_details']))
        <div>OS details: <b><span class="log_os text-muted">{{$content['os_details']}}</span></b></div>

        <div>Browser details: <b><span class="log_browser text-muted">{{$content['browser_details']}}</span></b></div>
        <div>IP Address: <b><span class="log_ip text-muted">{{$content['ip_details']}}</span></b></div>
        <div>Window Swaps: <b><span class="log_swaps text-danger">{{$content['window_change']}}</span></b></div>
        @endif
        <div>Date: <b><span class="log_swaps text-primary">{{date("jS F, Y", $content['last_updated'])}}</span></b></div>
        <hr>
      </div>
@if($content)


  <div class="px-5">
     
    
        <div class="chats mb-3">
          
          <div class="">
            <div class="timeline timeline-5 mt-3">
              @foreach($content['activity'] as $a => $b)
              <div class="timeline-item align-items-start">
                            <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{date(' h:i:s ', $a)}}</div>
                            <div class="timeline-badge">
                              <i class="fa fa-genderless text-warning icon-xl"></i>
                            </div>
                            <div class="font-weight-mormal font-size-lg timeline-content text-primary pl-3">{{$b}}</div>
                          </div>
              @endforeach

            </div>
            
          </div>
        </div>

       


      </div>



@endif

</div>
</div>

@endsection


