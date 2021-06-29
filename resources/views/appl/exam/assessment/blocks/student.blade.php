 @extends('layouts.nowrap-white')
@section('title', 'Performance Analysis - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@include('appl.exam.exam.xp_css')

 <style>.baseline{padding-top:3px;background:silver;border-radius: 5px;margin:5px 0px 15px;width:30%;}
.cardgreen{background-image: linear-gradient(to bottom right, #fff, white);border:2px solid #eee;margin-bottom: 15px;}
.dblue2{ background: #f2fff9;border-bottom:2px solid #beedd6; }</style>
<div class="dblue2">
<div class="container py-4 ">
  @include('appl.exam.assessment.blocks.breadcrumbs')
 <div class="row mb-4">
          @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg'))
          <div class="col-4 col-md-2">
            <img src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_selfie.jpg')}}" class="w-100 rounded " />
          </div>
          @endif
          <div class="col-12 col-md">
            <h1 class="mb-0">{{$student->name}}</h1>
              <p><i class="fa fa-bars"></i> {{$exam->name}}</p>
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
            <div class="row mb-0">
              <div class="col-4"> Branch:</div>
              <div class="col-8">{{$student->branch->name}}</div>
            </div>
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
          </div>
          <div class="col-12 col-md-6">
           
            <div class="row">
              <div class="col-6 col-md-6 col-lg-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox " style='background: #f2faff;border:1px solid #c1e6f7;box-shadow:2px 2px 0px 0px #e9e9e9'>
                  <div class="h6">Score Secured</div>
                  <div class="score_main" >
                    @if(!$test_overall->status)
                    <div class="display-3 text-primary">{{ $test_overall->score }} </div>
                    <div class=" mt-2">out of {{$test_overall->max}}</div>
                    @else
                    <div class="badge badge-primary under_review_main" >Under <br>Review</div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-lg-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox " style='background: #fffff2;border:1px solid #ebebb2;box-shadow:2px 2px 0px 0px #f3f3f3'>
                  <div class="h6">Percentage</div>
                  <div class="score_main" >
                    @if(!$test_overall->status)
                    <div class="display-3 text-primary">{{ round($test_overall->score/$test_overall->max*100) }}% </div>
                    <div class="mt-2">out of 100</div>
                    @else
                    <div class="badge badge-primary under_review_main" >Under <br>Review</div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-lg-4">
                <div class=" p-3  mt-md-3 mt-lg-2 mb-3 mb-md-0 text-center cardbox " style='background: #fff4f4;border:1px solid#f7d8d8;box-shadow:2px 2px 0px 0px #efefef;'>
                  <div class="h6">Rank</div>
                  <div class="score_main" >
                    @if(!$test_overall->status)
                    <div class="display-3 text-primary">#{{ $details['rank']['rank']}} </div>
                    <div class=" mt-2">out of {{$details['rank']['participants']}}</div>
                    @else
                    <div class="badge badge-primary under_review_main" >Under <br>Review</div>
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
  <div class="col-12 col-md-8">
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
            @endif <span class="h5">min</span></div>
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
            @endif</div>
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

  <div class="col-12 col-md-4">
    <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Report</h3>
    <canvas id="myChart" width="295" height="270"></canvas>



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

<div class="" style="background: #f9f9f1;">
<div class="container">
      @if($count['webcam'])
    <div class="rounded  py-4 ">
    <h3 class="mb-4"><i class="fa fa-angle-double-right"></i> Webcam Captures</h3>
    
          <div class="row mb-0 {{$m=0}}">
            @if(isset($images['webcam']))
            

            @foreach($images['webcam'] as $k=>$f)
            @if(Storage::disk('s3')->exists($f))
            <div class='col-2 {{$m=$m+1}}'>
                <img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-3 rounded" />
              </div>
            @endif
            @if($m==4)
              @break
            @endif

            @endforeach
            @endif
            
          </div>
          @if($count['webcam'])
          <div class="mt-1"><span>View: </span> <a href="{{ route('test.snaps',$exam->slug)}}?type=snaps&username={{$user->username}}" class="">Captures </a> | <a href="{{ route('test.snaps',$exam->slug)}}?type=screens&username={{$user->username}}" class=""> Screenshots</a> | <a href="{{ route('test.logs',$exam->slug)}}?username={{$user->username}}" class=""> Logs</a></div>
          
          @endif
         
      </div>
  
    @endif

    @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2001.webm'))
     <div class="pb-4">
      <h3 class="mb-3"><i class="fa fa-angle-double-right"></i>  Video Snaps</h3>
      <div class="row">
        <div class="col-12 col-md-3">
          <video id="my1" class="video-js" controls preload="auto" width="250" data-setup="{}">
        <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_2001.webm')}}" type="video/webm" />
        <p class="vjs-no-js">
          To view this video please enable JavaScript, and consider upgrading to a
          web browser that
          <a href="https://videojs.com/html5-video-support/" target="_blank"
            >supports HTML5 video</a
          >
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
          <a href="https://videojs.com/html5-video-support/" target="_blank"
            >supports HTML5 video</a
          >
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
          <a href="https://videojs.com/html5-video-support/" target="_blank"
            >supports HTML5 video</a
          >
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
          <a href="https://videojs.com/html5-video-support/" target="_blank"
            >supports HTML5 video</a
          >
        </p>
      </video>
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
          <a href="https://videojs.com/html5-video-support/" target="_blank"
            >supports HTML5 video</a
          >
        </p>
      </video>
    </div>
        @endif

        <script>
  if(typeof video !== 'undefined'){
      video.addEventListener('loadedmetadata', function() {
    if (video.buffered.length === 0) return;

    const bufferedSeconds = video.buffered.end(0) - video.buffered.start(0);
    console.log(`${bufferedSeconds} seconds of video are ready to play.`);
  });
  }

</script>
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
  </div>
</div>
@endsection