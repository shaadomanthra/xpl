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
  <style>
.blink {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>



<div class="mt-4 container" >
<nav class="mb-0">
  <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    @if(auth::user()->role!=11)
    <li class="breadcrumb-item"><a href="{{ url('/exam')}}">Tests</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug)}}">{{$exam->name}}</a></li>

    @else
    <li class="breadcrumb-item">Tests</li>
    @endif
  </ol>
</nav>

    <div class="row proctoring" data-active="{{$exam->active}}">
      <div class="col-12  col-md-5">

        <div class=' pb-3'>
          <p class="heading_two mb-2 f30 " >
              <span class="svg-icon svg-icon-primary svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-15-014444/theme/html/demo1/dist/../src/media/svg/icons/Devices/LTE1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M15.4508979,17.4029496 L14.1784978,15.8599014 C15.324501,14.9149052 16,13.5137472 16,12 C16,10.4912085 15.3289582,9.09418404 14.1893841,8.14910121 L15.466112,6.60963188 C17.0590936,7.93073905 18,9.88958759 18,12 C18,14.1173586 17.0528606,16.0819686 15.4508979,17.4029496 Z M18.0211112,20.4681628 L16.7438102,18.929169 C18.7927036,17.2286725 20,14.7140097 20,12 C20,9.28974232 18.7960666,6.77820732 16.7520315,5.07766256 L18.031149,3.54017812 C20.5271817,5.61676443 22,8.68922234 22,12 C22,15.3153667 20.523074,18.3916375 18.0211112,20.4681628 Z M8.54910207,17.4029496 C6.94713944,16.0819686 6,14.1173586 6,12 C6,9.88958759 6.94090645,7.93073905 8.53388797,6.60963188 L9.81061588,8.14910121 C8.67104182,9.09418404 8,10.4912085 8,12 C8,13.5137472 8.67549895,14.9149052 9.82150222,15.8599014 L8.54910207,17.4029496 Z M5.9788888,20.4681628 C3.47692603,18.3916375 2,15.3153667 2,12 C2,8.68922234 3.47281829,5.61676443 5.96885102,3.54017812 L7.24796852,5.07766256 C5.20393339,6.77820732 4,9.28974232 4,12 C4,14.7140097 5.20729644,17.2286725 7.25618985,18.929169 L5.9788888,20.4681628 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <circle fill="#000000" cx="12" cy="12" r="2"/>
            </g>
        </svg><!--end::Svg Icon--></span>
           Proctoring 
           @if(request()->get('open'))
           <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#terminateall">
  Terminate open participants
</button>@endif
</p>
        </div>

       
       
      </div>
      <div class="col-12  col-md-4">
        
      </div>
      <div class="col-12  col-md-3">
         <!--begin::Form-->
         <form class="w-100" method="GET" action="{{ route('test.active',$exam->slug) }}">
           <div class="form-group mt-2">
            <div class="input-icon">
             <input type="text" class="form-control" name="search" placeholder="Search by rollnumber..."/>
             <span><i class="flaticon2-search-1 icon-md"></i></span>
            </div>
           </div>
         </form>
         <!--end::Form-->
      </div>
     
    </div>

     
  </div>
</div>


@if($data['total'])
<div class="container">
<div class="row">
<div class="col-6 col-md-4">
                    <!--begin::Stats Widget 30-->
                    <div class="card card-custom bg-info card-stretch gutter-b">
                      <!--begin::Body-->
                      <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                          <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Group.svg-->
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24" />
                              <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                              <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                          </svg>
                          <!--end::Svg Icon-->
                        </span>
                        <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">
                         <a href="{{ route('test.active',$exam->slug)}}" class="text-white">{{($data['total'])}}</a></span>
                        <span class="font-weight-bold text-white font-size-sm">Total Participants</span>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 30-->
                  </div>

                  <div class="col-6 col-md-4">
                    <!--begin::Stats Widget 20-->
                    <div class="card card-custom bg-light-warning card-stretch gutter-b">
                      <!--begin::Body-->
                      <div class="card-body my-4">
                        <a href="{{ route('test.active',$exam->slug)}}?open=1" class="card-title font-weight-bolder text-warning font-size-h6 mb-4 text-hover-state-dark d-block">Open Participants ({{round((($data['total']-$data['completed'])*100/$data['total']))}}%)</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                          <a href="{{ route('test.active',$exam->slug)}}?open=1">{{($data['total']-$data['completed'])}}</a></span></div>
                        <div class="progress progress-xs mt-7 bg-warning-o-60">
                          <div class="progress-bar bg-warning" role="progressbar" style="width: {{(($data['total']-$data['completed'])*100/$data['total'])}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 20-->
                  </div>

                  <div class="col-6 col-md-4">
                    <!--begin::Stats Widget 22-->
                    <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{asset('assets/media/svg/shapes/abstract-3.svg') }})">
                      <!--begin::Body-->
                      <div class="card-body my-4">
                        <a href="{{ route('test.active',$exam->slug)}}?completed=1" class="card-title font-weight-bolder text-primary font-size-h6 mb-4 text-hover-state-dark d-block">Completed ({{round((($data['completed'])*100/$data['total']))}}%)</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2"><a href="{{ route('test.active',$exam->slug)}}?completed=1">{{($data['completed'])}}</a></span></div>
                        <div class="progress progress-xs mt-7 bg-info-o-60">
                          <div class="progress-bar bg-primary" role="progressbar" style="width: {{(($data['completed'])*100/$data['total'])}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 22-->
                  </div>


</div>
</div>

@endif



@include('flash::message')

<div class="px-5 container">


@if($candidates)
<div class="alert alert-important alert-primary">
  <a href="{{ route('test.proctor',$exam->slug)}}" target="_blank" class="text-white"><i class="fa fa-angle-right" class="text-white"></i> Approval dashboard link </a>
</div>
@endif
<div  class="row  no-gutters {{$i=0}}">

@if($pg->total()!=0)
@foreach($users as $a => $b)
@if($b!=1)

<div class="col-6 col-md-2 ">
  <div class="card   mb-2 mx-1  @if($b['completed']==1) completed @else bg-light-warning @endif card_{{$a}}" data-last="">
    <div class="p-4 ">
      <div class="">
        <div class="action_{{$a}} d-inline float-right dd_response_images" data-url="{{ route('assessment.response_images',$exam->slug)}}">
          </div>
              <h6 class="mb-3 d-inline"> 
                 @if(isset($b['window_change']))
                @if($b['window_change'])
                <small><span class="badge badge-danger float-right window_change window_change_{{$a}}">{{$b['window_change']}}</span></small>
                @endif
                @endif
                @if(isset($b['uname'])){{substr($b['uname'],0,20)}} @elseif(isset($b['username'])) {{substr($b['username'],0,15)}} @endif<br>
                <small class="text-primary">@if(isset($userset[$a])) {{$userset[$a]->roll_number}} @else @if(isset($b['rollnumber'])) {{$b['rollnumber']}} @endif @endif</small>



               
              </h6>
            <div class="selfie_container mt-4">
              <img src="" class="w-100 image_refresh image_refresh_{{$a}}" data-url="{{$b['url']}}" data-url2="{{$b['url2']}}" data-username="{{$a}}" data-completed="{{$b['completed']}}">
            </div>
          

            @if($b['completed']!=1)
            <p class="mb-0 mt-3">
              @if(isset($settings['chat']))
              @if(strtolower($settings['chat'])=='yes')
              @if(Storage::disk('s3')->exists('testlog/'.$exam->id.'/chats/'.$a.'.json'))
              @if(isset($b['uname']))
              <span class="mr-4"><i class="fa fa-comment-alt text-success  cursor message_student message_{{$a}}" data-urlpost="{{$b['chat_post']}}" data-username="{{$a}}" data-name="{{$b['uname']}}"data-url="{{$b['chat']}}" data-proctor="{{\auth::user()->name}}"  data-p="1" data-lastchat=""></i> <span class="badge badge-warning p-1 text-white chat_count chat-count_{{$a}} d-none"></span></span>
              @endif
              @endif
              @endif
              @endif
              <i class="far fa-list-alt text-info mr-4 cursor user_log" data-url="{{$b['url']}}" data-selfie_url="{{$b['selfie_url']}}" data-idcard_url="{{$b['idcard_url']}}"></i> 
                @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$b['username'].'_'.$exam->id.'_video_1000.webm'))
                <i class="fas fa-street-view text-primary mr-4 cursor camera360 " data-url=" {{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$b['username'].'_'.$exam->id.'_video_1000.webm')}}" ></i> 
                  @endif


              @if(!$candidates)
              @if(isset($b['uname']))
              <i class="fas fa-power-off text-danger mr-4 cursor user_terminate user_terminate_{{$a}}" data-url="{{$b['approval']}}" data-urlpost="{{$b['approval_post']}}" data-username="{{$a}}" data-name="{{$b['uname']}}"  ></i>
              @endif
              @endif 
            </p>
            @else
            <p class="mb-0 mt-3">
             <span class="text-success float-right"><b><i class="fa fa-check-circle text-success"></i> completed</b></span>
             <i class="far fa-list-alt text-info mr-4 cursor user_log " data-url="{{$b['url']}}" data-selfie_url="{{$b['selfie_url']}}" data-idcard_url="{{$b['idcard_url']}}"></i> 
              @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$b['username'].'_'.$exam->id.'_video_1000.webm'))
                <i class="fas fa-street-view text-primary mr-4 cursor camera360 " data-url=" {{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$b['username'].'_'.$exam->id.'_video_1000.webm')}}" ></i> 
              @endif


            </p>
            @endif

          </div>

    </div>
    @if($b['completed']!=1)
    @if(isset($chats[$a]['last_message']))
    @if(count($chats))
    <div class="bg-light p-3"><b><span class="text-primary student_name_{{$a}}">{{ $chats[$a]['last_user'] }} </span></b>
        @if(isset($chats[$a]['last_time']))
        <span class="time time_{{$a}} text-primary float-right">{{ date("h:i:s ",$chats[$a]['last_time'])  }}</span>
        @endif


        @if(isset($chats[$a]['last_message']))
        <p class="student_message student_message_{{$a}}">{{ $chats[$a]['last_message']}}</p> 
        @else
        <span class="student_message student_message_{{$a}}"> - </span> 
        @endif
    </div>
    @endif
    @endif
    @endif
  </div>
</div>

@else

  @if($b==1)
  <div class="col-6 col-md-2 ">
    <div class="card   mb-2 mx-1 ) bg-light-secondary " data-last="" style="border:1px solid silver">
      <div class="p-4 ">
        <div class="">
          <div class="action_{{$a}} d-inline float-right">
            </div>
                <h6 class="mb-4 ">{{$userset[$a]->name}}<br>
                  <small class="text-primary">@if(isset($userset[$a])) {{$userset[$a]->roll_number}} @else @if(isset($b['rollnumber'])) {{$b['rollnumber']}} @endif @endif</small>
                </h6>
                <span class="badge badge-warning">no data yet</span>
             
            </div>
      </div>
    </div>
  </div>
  @else

  <div class="col-6 col-md-2 ">
    <div class="card   mb-2 mx-1 ) bg-light-secondary " data-last="" style="border:1px solid silver">
      <div class="p-4 ">
        <div class="">
          <div class="action_{{$a}} d-inline float-right">
            </div>
                <h6 class="mb-4 ">{{$userset[$a]->name}}<br>
                  <small class="text-primary">@if(isset($userset[$a])) {{$userset[$a]->roll_number}} @else @if(isset($b['rollnumber'])) {{$b['rollnumber']}} @endif @endif</small>
                </h6>
                <span class="badge badge-primary">Started exam but<br> no data recored yet.</span>
             
            </div>
      </div>
    </div>
  </div>


  @endif

@endif
@endforeach
@endif

  
</div>

<nav aria-label="Page navigation  " class="card-nav @if($pg->total() > 16 )my-3 mb-5 @endif">
        {{$pg->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

</div>

<style>
div.chats {
  background-color: #f4fbff;
  border:1px solid #e1eef5;
  height: 200px;
  overflow: auto;
  border-radius: 5px;
  padding:20px;
}
</style>

<div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-comment-alt "></i> Message: <b><span class="message_name"></span></b> </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <div class="chats">
          <div class="chat_messages">
            
          </div>
        </div>

        <div class="form-group mb-0">
            <label for="message-text" class="col-form-label">Your Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary send_chat" data-user="proctor" data-testid="{{$exam->id}}" data-username="">Send message</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="terminate" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-window-close text-danger "></i> Terminate </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        
        I confirm, the test termination of <b><span class="terminate_name"></span></b> due to misconduct during the test.
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary termination_confirm" data-username="">Confirm</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="terminateall" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-window-close text-danger "></i> Terminate Open Participants</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        
        I confirm, the test termination of all the open participants.
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <a href="{{ route('test.active',$exam->slug)}}?terminate_all=1" class="btn btn-primary " data-username="">Confirm</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="announce" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa  flaticon2-sms text-info"></i> Mass Announcement </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        
        <div class="form-group mb-0">
            <textarea class="form-control" id="message-text"></textarea>
          </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary ">Send Message</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="camera360" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa  fa-camera text-info"></i> 360<sup>o</sup> Screening </h3>
      </div>
      <div class="modal-body ">
              <div class="">
        <video
    id="my-video"
    class="video-js"
    controls
    preload="auto"
    width="400"
    data-setup="{}"
  >
    <source class="vcam360"  src="" type="video/webm" />
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank"
        >supports HTML5 video</a
      >
    </p>
  </video>
</div>
  
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="logs" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-clipboard-list text-info "></i> Logs </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
       <div class="pb-4">
        <div class="p-3 border float-right @if(!$exam->camera) d-none @endif">Lastest Capture<br>
        <img src="" class=" log_pic border" height="100px" style="display:none" /></div>
        <div class="">Name: <b><span class="log_name text-success"></span></b></div>
        <div>Roll Number: <b><span class="log_rollnumber text-primary"></span></b></div>
        <div>OS details: <b><span class="log_os text-muted"></span></b></div>
        <div>Browser details: <b><span class="log_browser text-muted"></span></b></div>
        <div>IP Address: <b><span class="log_ip text-muted"></span></b></div>
        <div>Window Swaps: <b><span class="log_swaps text-danger"></span></b></div>
      </div>

      

      <div class="pb-4 @if(!$exam->camera) d-none @endif">
      <a href="" class="btn btn-primary link_snaps " data-url="{{ route('test.snaps',$exam->slug)}}" target="_blank"><i class="fa fa-camera text-white"></i> Selfie</a> &nbsp;&nbsp;<a href="" data-url="{{ route('test.snaps',$exam->slug)}}" class="btn btn-success link_screens" target="_blank"><i class="fa fa-image text-white"></i> Screens</a> &nbsp;&nbsp;<a href="" data-url="{{ route('assessment.response_images',$exam->slug)}}" class="btn btn-info link_uploads" target="_blank">Uploads</a> 
    </div>
    
        <div class="chats mb-3">
          
          <div class="">
            <div class="timeline timeline-5 mt-3">
         

            </div>
            
          </div>
        </div>

        <div class="pt-4 @if(!$exam->camera) d-none @endif">
        <div class="row">
          <div class="col-6">
            <div class="border p-2 bg-light">Selfie<br><img src="w-100" class="log_selfie_pic border rounded " width="200px"  /></div></div>
          <div class="col-6">
            <div class="border p-2 bg-light">ID Card<br><img src="w-100" class=" log_idcard_pic border rounded " width="200px"  /></div></div>

        </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<script>
setTimeout(function(){
   window.location.reload(1);
}, 120000);
  </script>

@endsection


