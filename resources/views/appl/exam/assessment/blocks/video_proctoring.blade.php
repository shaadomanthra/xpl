 @extends('layouts.nowrap-white')
@section('title', 'Video Proctoring - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@include('appl.exam.exam.xp_css')

 <style>.baseline{padding-top:3px;background:silver;border-radius: 5px;margin:5px 0px 15px;width:30%;}
.cardgreen{background-image: linear-gradient(to bottom right, #fff, white);border:2px solid #eee;margin-bottom: 15px;}
.dblue2{ background: #f2fff9;border-bottom:2px solid #beedd6; }</style>
<div class="dblue2">
<div class="container pt-3 mb-0 pb-0 ">
  <nav class="mb-0" data-html2canvas-ignore="true">
    <ol class="breadcrumb p-0 " style="background: transparent;">
      <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
      <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
      <li class="breadcrumb-item">{{$student->name}} - Video</li>
    </ol>
  </nav>
 
</div>
</div>

</div>

<div class="" style="background: #fff;">
<div class="container">

 

     @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_3001.webm'))
     <div class="pb-4">
      <h3 class="mb-3"><i class="fa fa-angle-double-right"></i>  Video Proctoring - <span id="clipname">Clip 1</span></h3>
      <div class="row">
        <div class="col-12">
          <div class="embed-responsive embed-responsive-16by9">
          <video id="my1" class="video-js embed-responsive-item "  controls preload="auto"  data-setup="{}">
           @if(in_array(request()->get('video'),[1,2,3,4]))
            <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_300'.request()->get('video').'.webm')}}" type="video/webm" />
            <p class="vjs-no-js">
              To view this video please enable JavaScript, and consider upgrading to a
              web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
            @endif
          </video>
        </div>
        </div>
      </div>
    </div>

      @for($h=3001;$h<3011;$h++)
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_'.$h.'.webm'))
        <span class="btn btn-outline-primary cursor " data-url="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/video/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_'.$h.'.webm')}}" data-name="Clip {{($h-3000)}}" onclick="eclick(event)">Clip {{($h-3000)}} 
          @if($h==3001 )
           (First Miniute)
          @elseif($h==3002)
           (Second Minute)
          @elseif($h==3003)
          (Third Minute)
          @elseif($h==3004)
          (Fourth Minute)
          @else
          (next Five minutes)
          @endif

        </span>
        @endif
      @endfor
    @endif

  
    @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_2001.webm'))

     <div class="pb-4 mt-5">
      <h3 class="mb-3"><i class="fa fa-angle-double-right"></i>  Video Proctoring - <span id="clipname">Clip {{request()->get('video')}}</span></h3>
      <div class="row">
        <div class="col-12">
          <div class="embed-responsive embed-responsive-16by9">
          <video id="my1" class="video-js embed-responsive-item "  controls preload="auto"  data-setup="{}">
           @if(in_array(request()->get('video'),[1,2,3,4]))
            <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_200'.request()->get('video').'.webm')}}" type="video/webm" />
            <p class="vjs-no-js">
              To view this video please enable JavaScript, and consider upgrading to a
              web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
            @endif
          </video>
        </div>
        </div>
      </div>
    </div>

      @for($h=2001;$h<2011;$h++)
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/snaps/'.$student->username.'/'.$student->username.'_'.$exam->id.'_video_'.$h.'.webm'))
        <span class="btn btn-outline-primary cursor " data-url="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/snaps/'.$student->username.'_'.$exam->id.'_video_'.$h.'.webm')}}" data-name="Clip {{($h-2000)}}" onclick="eclick(event)">Clip {{($h-2000)}} 
         

        </span>
        @endif
      @endfor
    @endif

   

     



    <br><br><br>

<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<script src="/js/video.min.js"></script>
<script src="/js/videojs-playlist.min.js"></script>
<script>
  if(typeof video !== 'undefined'){
      video.addEventListener('loadedmetadata', function() {
    if (video.buffered.length === 0) return;

    const bufferedSeconds = video.buffered.end(0) - video.buffered.start(0);
    console.log(`${bufferedSeconds} seconds of video are ready to play.`);
  });
  }

 

  function eclick(e){
    url = e.target.dataset.url;
    name = e.target.dataset.name;
     var video = videojs("my1");
     document.getElementById("clipname").innerHTML = name;
    video.src(url);
  }
 

</script>


  </div>
</div>
@endsection