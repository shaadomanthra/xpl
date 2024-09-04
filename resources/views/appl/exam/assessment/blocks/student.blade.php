 @extends('layouts.nowrap-white')
 @section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
 @section('content')

 @include('appl.exam.exam.xp_css')

 <style>
   .baseline {
     padding-top: 3px;
     background: silver;
     border-radius: 5px;
     margin: 5px 0px 15px;
     width: 30%;
   }

   .cardgreen {
     background-image: linear-gradient(to bottom right, #fff, white);
     border: 2px solid #eee;
     margin-bottom: 15px;
   }

   .dblue2 {
     background: #f2fff9;
     border-bottom: 2px solid #beedd6;
   }
 </style>
 <div class="dblue2">
   <div class="container py-4 ">
     <div class="d-print-none">
       @include('appl.exam.assessment.blocks.breadcrumbs')
     </div>
     <div class="d-none d-print-inline">
       <h1 class="mb-3"><i class="fa fa-bars"></i> {{$exam->name}} - Report</h1>
       <hr>
     </div>
     <div class="row mb-4">
       @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg'))
       <div class="col-4 col-md-2  ">
         <img src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg')}}" class="w-100 rounded " />
       </div>
       @endif
       <div class="col-12 col-md">
         <h2 class="mb-2">{{$student->name}}</h2>
         <p class="d-print-none"> <i class="fa fa-bars"></i> {{$exam->name}}</p>
         <div class="row mb-0">
           <div class="col-4"> Email:</div>
           <div class="col-8">{{$student->email}}</div>
         </div>
         <div class="row mb-0">
           <div class="col-4"> Phone:</div>
           <div class="col-8">{{$student->phone}}</div>
         </div>
         @if($student->college_id)
         <div class="row mb-0">
           <div class="col-4"> College:</div>
           <div class="col-8">{{$student->college->name}}</div>
         </div>
         @endif
         @if($student->branch_id)
         @if($student->branch)
         <div class="row mb-0">
           <div class="col-4"> Branch:</div>
           <div class="col-8">{{$student->branch->name}}</div>
         </div>
         @endif
         @endif
         @if($student->roll_number)
         <div class="row mb-0">
           <div class="col-4"> Roll Number:</div>
           <div class="col-8">{{$student->roll_number}}</div>
         </div>
         @endif
         <br>

         @if($test_overall->status)
         @if(isset($details['auto_max']))
         <div class="row mb-0">
           <div class="col-4"> Auto Evaluation Score:</div>
           <div class="col-8">{{$test_overall['score']}} / {{$details['auto_max']}}</div>
         </div>
         <div class="row mb-0">
           <div class="col-4"> Responses under review:</div>
           <div class="col-8">{{$details['review']}}</div>
         </div>
         @endif
         @endif

         @if($test_overall->comment)
         <div class="row mb-0">
           <div class="col-4"> Comment:</div>
           <div class="col-8"><b><span class="text-dark">{{$test_overall->comment }}</span></b></div>
         </div>
         @endif

         <div class="d-print-none">
           <div class="row mb-0">
             <div class="col-4"> Cheating:</div>
             <div class="col-8"><b>
                 @if($test_overall->cheat_detect==0)
                 <span class="text-success"><i class="fa fa-check-circle"></i> Potentially No</span>
                 @elseif($test_overall->cheat_detect==1)
                 <span class="text-danger"><i class="fa fa-times-circle"></i> Potentially YES</span>
                 @elseif($test_overall->cheat_detect==2)
                 <span class="text-info"><i class="fa fa-ban"></i> Not Clear</span>

                 @endif
               </b></div>
           </div>

           <div class="row mt-1">
             <div class="col-4"> Answersheet:</div>
             <div class="col-8"><a href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}">view responses</a></div>
           </div>
         </div>


       </div>
       <div class="col-12 col-md-5 col-lg-6">

         <div class="row">
           <div class="col-6 col-md-6 col-lg-4">
             <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox " style='background: #f2faff;border:1px solid #c1e6f7;box-shadow:2px 2px 0px 0px #e9e9e9'>
               <div class="h6">Score Secured</div>
               <div class="score_main">
                 @if(!$test_overall->status)
                 <div class="display-3 text-primary">{{ $test_overall->score }} </div>
                 <div class=" mt-2">out of {{$test_overall->max}}</div>
                 @else
                 <div class="badge badge-primary under_review_main">Under <br>Review</div>
                 @endif
               </div>
             </div>
           </div>
           <div class="col-6 col-md-6 col-lg-4">
             <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox " style='background: #fffff2;border:1px solid #ebebb2;box-shadow:2px 2px 0px 0px #f3f3f3'>
               <div class="h6">Percentage</div>
               <div class="score_main">
                 @if(!$test_overall->status)
                 <div class="display-3 text-primary">{{ round($test_overall->score/$test_overall->max*100) }}% </div>
                 <div class="mt-2">out of 100</div>
                 @else
                 <div class="badge badge-primary under_review_main">Under <br>Review</div>
                 @endif
               </div>
             </div>
           </div>
           <div class="col-6 col-md-6 col-lg-4">
             <div class=" p-3  mt-md-3 mt-lg-2 mb-3 mb-md-0 text-center cardbox " style='background: #fff4f4;border:1px solid#f7d8d8;box-shadow:2px 2px 0px 0px #efefef;'>
               <div class="h6">Rank</div>
               <div class="score_main">
                 @if(!$test_overall->status)
                 <div class="display-3 text-primary">#{{ $details['rank']['rank']}} </div>
                 <div class=" mt-2">out of {{$details['rank']['participants']}}</div>
                 @else
                 <div class="badge badge-primary under_review_main">Under <br>Review</div>
                 @endif
               </div>
             </div>
           </div>
         </div>




       </div>

     </div>
   </div>
 </div>

 <div class="bg-white container">
   <div class="row mt-4">
     <div class="col-12 col-md-12 col-lg-8">
       <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Test Details</h3>
       <div class="row mb-4">
         <div class="col-6 col-md-4 ">
           <div class="rounded p-4 cardgreen" style="">
             <div><i class="fa fa-clock-o"></i> <span class="">Time Spent</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> @if($test_overall->time)
               {{round($test_overall->time/60,2)}}
               @else
               -
               @endif <span class="h5">min</span>
             </div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-circle-o-notch"></i> <span class="">Avg Pace</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> {{ $details['avgpace']}} <span class="h5">sec</span></div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-window-restore"></i> <span class="">Window Swap</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> @if($test_overall->window_change)
               {{$test_overall->window_change}}
               @else
               -
               @endif
             </div>
           </div>
         </div>

         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-plus-square-o"></i> <span class="">Attempted</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> {{ $details['attempted']}} <span class="h5">/ {{ ($details['unattempted']+$details['attempted'])}}</span></div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-check-circle"></i> <span class="">Correct</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> {{ $details['correct']}} <span class="h5">/ {{ ($details['unattempted']+$details['attempted'])}}</span></div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-times-circle"></i> <span class="">Incorrect</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> {{ $details['incorrect']}} <span class="h5">/ {{ ($details['unattempted']+$details['attempted'])}}</span></div>
           </div>
         </div>

       </div>





     </div>

     <div class="col-12 col-md-4 d-print-none">

       <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Report</h3>
       <canvas id="myChart" width="295" height="270"></canvas>





     </div>

     <div class="col-12 col-md-12 col-lg-8">
       <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Academic Scores</h3>
       <div class="row mb-4">
         <div class="col-6 col-md-4 ">
           <div class="rounded p-4 cardgreen" style="">
             <div><i class="fa fa-check-square-o"></i> <span class="">Class 10</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary"> @if($student->tenth)
               {{$student->tenth}} %
               @else
               -
               @endif
             </div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-circle-o-notch"></i> <span class="">Class 12</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary">@if($student->twelveth)
               {{$student->twelveth}} %
               @else
               -
               @endif
             </div>
           </div>
         </div>
         <div class="col-6 col-md-4 ">
           <div class="rounded cardgreen p-4">
             <div><i class="fa fa-window-restore"></i> <span class="">Graduation</span></div>
             <div class="baseline"></div>
             <div class="display-3 text-primary">@if($student->bachelors)
               {{$student->bachelors}} %
               @else
               -
               @endif
             </div>
           </div>
         </div>
       </div>

     </div>

     <div class="col-12 col-md-4 d-print-none">
       @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_'.$video.'.webm'))
       <div class="pb-4">
         <h3 class="mb-3"><i class="fa fa-angle-double-right"></i> Video Question</h3>
         <video id="my-video" class="video-js" controls preload="auto" width="350" data-setup="{}">
           <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_'.$video.'.webm')}}" type="video/webm" />
           <p class="vjs-no-js">
             To view this video please enable JavaScript, and consider upgrading to a
             web browser that
             <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
           </p>
         </video>
       </div>
       @endif
     </div>
   </div>


   @if(isset($sectiondetails))
   @if(count($sectiondetails)>1)

   <div class="pb-4">
     <div class="p-2 " height="200px">
       <canvas id="SectionContainer" width="600" height="200px"></canvas>
     </div>
   </div>
   @endif
   @endif



 </div>

 <div class="d-print-none" style="background: #f9f9f1;">
   <div class="container">

     <div class="pt-5">
       <h2 class="mb-4"><i class="fa fa-angle-double-right"></i> Cheating Status :
         @if($test_overall->cheat_detect==0)
         <span class="text-success">Potentially No</span>
         @elseif($test_overall->cheat_detect==1)
         <span class="text-danger">Potentially YES</span>
         @elseif($test_overall->cheat_detect==2)
         <span class="text-info">Not Clear</span>

         @endif

       </h2>


     </div>
     <div class="row  py-4 ">
       <div class="col-12 col-md-8">



         @if($count['webcam'])
         <div class="rounded   ">

           <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> @if(!$images['webcam']) Webcam @else AI @endif Captures

             @if($test_overall['face_detect'])
             @if($images['webcam'])
             <span class="float-right">Face Detect: <span class="text-primary">{{$test_overall['face_detect']}}</span> &nbsp;&nbsp;&nbsp; Mobile Detect : <span class="text-primary">{{$test_overall['mobile_detect']}}</span></span>
             @endif
             @endif
             @if(!$test_overall['face_detect'])
             <small><a href="{{ route('test.snaps',$exam->slug)}}?type=snaps&username={{$user->username}}" class="">view all</a></small>
             @else
             <small><a href="{{ route('test.snaps',$exam->slug)}}?type=snaps&username={{$user->username}}" class="">view all</a></small>

             @endif
           </h3>

           <div class="row mb-0 {{$m=0}}">
             @if(isset($images['webcam']))


             @foreach($images['webcam'] as $k=>$f)
             @if(Storage::disk('s3')->exists($f))
             <div class='col-3 {{$m=$m+1}}'>
               <img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-3 rounded" />
             </div>
             @endif
             @if($m==4)
             @break
             @endif

             @endforeach
             @endif


           </div>



           <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Screen Captures <small><a href="{{ route('test.snaps',$exam->slug)}}?type=screens&username={{$user->username}}" class=""> view all</a> </small></h3>
           <div class="row mb-0 {{$m=0}}">

             @if(isset($images['screens']))


             @foreach($images['screens'] as $k=>$f)
             @if(Storage::disk('s3')->exists($f))
             <div class='col-3 {{$m=$m+1}}'>
               <img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-3 rounded" />
             </div>
             @endif
             @if($m==4)
             @break
             @endif

             @endforeach
             @endif
           </div>


         </div>

         @endif

       </div>
       <div class="col-12 col-md">
         <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Logs </h3>
         <div class="timeline timeline-5 mt-3 border rounded p-3">
           <div style="max-height: 340px;overflow: auto;">
             <div class="">Name: <b><span class="log_name text-success">{{$content['uname']}}</span></b></div>
             <div>Roll Number: <b><span class="log_rollnumber text-primary">{{$content['rollnumber']}}</span></b></div>
             @if(isset($content['os_details']))
             <div>OS details: <b><span class="log_os text-muted">{{$content['os_details']}}</span></b></div>

             <div>Browser details: <b><span class="log_browser text-muted">{{$content['browser_details']}}</span></b></div>

             <div>IP Address: <b><span class="log_ip text-muted">{{$content['ip_details']}}</span></b></div>

             <div>Window Swaps: <b><span class="log_swaps text-danger">{{$content['window_change']}}</span></b></div>
             <div>Date: <b><span class="log_swaps text-primary">{{date("jS F, Y", $content['last_updated'])}}</span></b></div>
             @endif
             <div>Logs: <b><a href="{{ route('test.logs',$exam->slug)}}?student={{$content['username']}}">Basic</a> | <a href="{{ route('test.logs',$exam->slug)}}?student={{$content['username']}}&b1=1">Debug</a></b></div>
             <hr>

             @if(isset($content['activity']))
             @foreach($content['activity'] as $a => $b)
             <div class="row">
               <div class="col-3">{{date(' h:i:s ', $a)}}</div>
               <div class="col-1">-</div>
               <div class="col-7"> {{$b}}</div>
             </div>
             @endforeach
             @endif

           </div>
         </div>

       </div>

     </div>


     @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2001.webm'))
     <div class="pb-4">
       <h3 class="mb-3"><i class="fa fa-angle-double-right"></i> Video Snaps</h3>
       <div class="row">
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2001.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
         </div>
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2002.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2002.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2003.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2003.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2004.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2004.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
         </div>
         @endif
       </div>
     </div>
     @endif

     @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2001.webm'))
     <div class="pb-4">
       <h3 class="mb-3"><i class="fa fa-angle-double-right"></i> Video Snaps</h3>
       <div class="row">
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2001.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
           <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}&video=1" class="mt-2"><i class="fa fa-angle-right"></i> video link</a>
         </div>
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2002.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2002.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
           <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}&video=2" class="mt-2"><i class="fa fa-angle-right"></i> video link</a>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2003.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2003.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
           <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}&video=3" class="mt-2"><i class="fa fa-angle-right"></i> video link</a>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2004.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2004.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
           <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}&video=4" class="mt-2"><i class="fa fa-angle-right"></i> video link</a>
         </div>
         @endif
       </div>
     </div>
     @endif


     @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3001.webm'))
     <div class="pb-4">
       <h3 class="mb-3"><i class="fa fa-angle-double-right"></i> Video Proctoring <a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}&video=1">view all</a></h3>
       <div class="row">
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3001.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>

           </video>
           <p><i class="fa fa-angle-right"></i> First Minute </p>
         </div>
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3002.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3002.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>
           <p><i class="fa fa-angle-right"></i> Second Minute </p>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3003.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3003.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>
           </video>

           <p><i class="fa fa-angle-right"></i> Third Minute </p>
         </div>
         @endif
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3004.webm'))
         <div class="col-12 col-md-3">
           <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
             <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3004.webm')}}" type="video/webm" />
             <p class="vjs-no-js">
               To view this video please enable JavaScript, and consider upgrading to a
               web browser that
               <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
             </p>

           </video>
           <p><i class="fa fa-angle-right"></i> Fourth Minute </p>
         </div>
         @endif



       </div>


     </div>

     @endif



     @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_1000.webm'))
     <div class="pb-4">
       <h3 class="mb-3"><i class="fa fa-angle-double-right"></i> 360<sup>o</sup> Video Screening</h3>
       <video id="my-video" class="video-js" controls preload="auto" width="500" data-setup="{}">
         <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_1000.webm')}}" type="video/webm" />
         <p class="vjs-no-js">
           To view this video please enable JavaScript, and consider upgrading to a
           web browser that
           <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
         </p>
       </video>
     </div>
     @endif



     @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
     <div class="border rounded  mt-3 d-print-none">
       <div class="p-4">
         <h5><i class="fa fa-th"></i> Admin Tools (visible for super amdin only)</h5>
         <hr>
         <div class="row">
           <div class="col-12 col-md-3">
             <h4>Update Cheating Status</h4>
           </div>
           <div class="col-12 col-md-9">
             <form action="{{ request()->fullUrl()}}" method="get">
               <div class="form-group w-100">
                 <select class="form-control w-100" name="cheat_detect">
                   <option value="3" @if($test_overall->cheat_detect==0) selected @endif>Potentially No</option>
                   <option value="1" @if($test_overall->cheat_detect==1) selected @endif>Potentially YES</option>
                   <option value="2" @if($test_overall->cheat_detect==2) selected @endif>Not clear</option>
                 </select>
                 <input type="hidden" name="student" value="{{request()->get('student')}}" />
               </div>
               <button class="btn btn-primary" type="submit">save</button>
             </form>
           </div>
         </div>
       </div>
     </div>
     @endif
     <br><br><br>

     <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
     <script src="/js/video.min.js"></script>
     <script src="/js/videojs-playlist.min.js"></script>
     <script>
       if (typeof video !== 'undefined') {
         video.addEventListener('loadedmetadata', function() {
           if (video.buffered.length === 0) return;

           const bufferedSeconds = video.buffered.end(0) - video.buffered.start(0);
           console.log(`${bufferedSeconds} seconds of video are ready to play.`);
         });
       }

       function eclick() {
         console.log('clicked');
         var video = videojs("my5");
         video.src("https://s3-xplore.s3.ap-south-1.amazonaws.com/webcam/2733/gajanavenirakesh123_2733_video_2002.webm");


       }
     </script>


   </div>
 </div>
 @endsection