@extends('layouts.noresponsive')
@section('title', 'Responses - '.$exam->name.' - '.\auth::user()->name.' ')
@section('content')

@include('appl.exam.exam.xp_css')
<style>
pre, code {
    white-space: pre-wrap;
    overflow-wrap: break-word;
    word-wrap: break-word;
}
.hljs {
    display: block;
    overflow-wrap: break-word;
    word-wrap: break-word;
    padding: 0.5em;
    background: #002b36;
    color: #839496;
}
.spanitem{
  line-height: 35px;
}

</style>
<style>
.main-ct {
  width: 1000px;
  height:600px;
  border: 1px solid #000;
  position:relative;
}
.fixed-ct {
  position: sticky;
  width:100px;
  height:20px;
  background: red;
  top:10px;
}
.like-body {
  width: 100%;
  height:1300px;
}
.item {
  position: sticky;
}


.fixed {
  top: 90px;
}
</style>
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />


<div id="pdf">
  <div id="content">
<div class="dblue" >
  <div class="container">



    <div class="row">
      <div class="col-12 ">

      	    @if(auth::user()->checkRole(['hr-manager','admin']))
<nav class="mb-0" data-html2canvas-ignore="true">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('test.report',$exam->slug)}}">{{ ucfirst($exam->name) }} - Reports </a></li>
    <li class="breadcrumb-item"><a class="white-link" href="{{ route('assessment.analysis',$exam->slug)}}?student={{request()->get('student')}}">{{$student->name}} - Report </a></li>
    <li class="breadcrumb-item">Responses </li>
  </ol>
</nav>
@elseif($exam->slug != 'proficiency-test')
<nav class="mb-0">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Report </li>
  </ol>
</nav>
@else
<nav class="mb-0">
  <ol class="breadcrumb p-0 pt-3" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ url('/dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proficiency_test') }}">Proficiency Test</a></li>
    <li class="breadcrumb-item">Analysis  </li>
  </ol>
</nav>
@endif
        
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
            <div class="row mb-0">
              <div class="col-4"> Auto Evaluation Score:</div>
              <div class="col-8">{{$test_overall['score']}} / {{$details['auto_max']}}</div>
            </div>
            <div class="row mb-0">
              <div class="col-4"> Responses under review:</div>
              <div class="col-8">{{$details['review']}}</div>
            </div>
            @endif

            @if($test_overall->comment)
            <div class="row mb-0">
              <div class="col-4"> Comment:</div>
              <div class="col-8"><b><span class="text-dark">{{$test_overall->comment }}</span></b></div>
            </div>
            @endif

             <div class="row mt-1">
              <div class="col-4"> Performance:</div>
              <div class="col-8"><a href="{{ route('assessment.analysis',$exam->slug)}}?student={{$student->username}}">view report</a></div>
            </div>

          </div>
          <div class="col-12 col-md-6">
           
            <div class="row">
              <div class="col-6 col-md-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
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
              <div class="col-6 col-md-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
                  <div class="h6">Percentage</div>
                  <div class="" >
                    @if(!$test_overall->status)
                    <div class="display-3 text-primary">{{ round($test_overall->score/$test_overall->max*100) }}% </div>
                    <div class="mt-2">out of 100</div>
                    @else
                    <div class="badge badge-primary " >Under <br>Review</div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
                  <div class="h6">Rank</div>
                  <div class="" >
                    @if(!$test_overall->status)
                    <div class="display-3 text-primary">#{{ $details['rank']['rank']}} </div>
                    <div class=" mt-2">out of {{$details['rank']['participants']}}</div>
                    @else
                    <div class="badge badge-primary " >Under <br>Review</div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              <h4 class="mt-4">Tools</h4>
               <a id="pdfbtn" class="btn btn-outline-dark btn-sm pdfbtn cursor" onclick="downloadpdf()" data-name="{{$student->roll_number}}_{{$student->name}}_{{$exam->name}}" data-html2canvas-ignore="true">PDF Format#1</a>
               <a class="btn btn-outline-dark btn-sm " href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&pdf3=1">PDF Format#2</a>
             
             
              <button  class="btn btn-outline-dark btn-sm ml-2" data-toggle="modal" data-target="#exampleModal2" data-html2canvas-ignore="true">Add Comment</button>
              <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&refresh=1"  class="btn btn-outline-dark btn-sm mt-2 mt-md-0" >Refresh Cache</a>

              @if(request()->get('mode')!=2)
                <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&mode=2"  class="btn btn-outline-dark btn-sm  mt-2 " >Mobile Mode</a>
              @else
                <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}"  class="btn btn-outline-dark btn-sm  mt-2 mt-md-0" >Desktop Mode</a>
              @endif

              @if(Storage::disk('s3')->exists('pdfuploads/'.$exam->slug.'/'.$exam->slug.'_'.$student->username.'.pdf'))
               <div class="mt-3">
                <a href="{{ route('test.pdfupload',$exam->slug)}}?student={{$student->username}}"  class="btn btn-outline-primary  btn-lg  mt-2 mt-md-0" ><i class="fa fa-file-pdf-o"></i> &nbsp;Answersheet PDF</a>
              </div>
              @endif
            </div>


            

          </div>

        </div>
       
      </div>
      
    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>
<div class="p-3 text-center bg-light sticky-top" id="item" style="margin-top:-2px;" data-html2canvas-ignore="true">

  @foreach($tests as $i=>$t)
<span class="border spanitem rounded p-1 px-2 @if($t->status!=2)qgreen @else qred @endif cursor qno_{{$t->question_id}}" href="#item{{($i+1)}}">{{($i+1)}}</span>
@endforeach
</div>





<div class="px-3  my-3 " id="wrapper">

@foreach($tests as $k=>$t)
<div class="row no-gutters" id="item{{($k+1)}}">
	<div class="col-12 ">
		<div class="card mb-3">
			<div class="card-body">

        <div class="row">
          <div class="@if(request()->get('mode')==2) col-12 @else col-9 @endif">

                <div class=" p-1 px-3 mr-2 rounded text-center bg-light border d-inline ">{{($k+1)}}</div>
                  <div class="d-none {{ $question = $t->question}} "></div>
        <p class="d-inline mb-3">{!! $questions[$t->question_id]->question !!}</p>

        @if($questions[$t->question_id]->type=='mcq')
        <div class="mt-3">
          <div class="row">
            <div class="col-12 col-md-6">
              @if($question->option_a)
          <div class=""><span class=" @if($t->answer=='A') text-success font-weight-bold @endif">(A)</span><div class="pt-1 d-inline "> {!! $question->option_a!!}</div></div>
          @endif
          @if($question->option_b)
          <div class=""><span class=" @if($t->answer=='B') text-success font-weight-bold @endif">(B)</span><div class="pt-1 d-inline "> {!! $question->option_b!!}</div></div>
          @endif

            </div>
            <div class="col-12 col-md-6">
              @if($question->option_c)
          <div class=""><span class=" @if($t->answer=='C') text-success font-weight-bold @endif">(C)</span><div class="pt-1 d-inline "> {!! $question->option_c!!}</div></div>
          @endif
          @if($question->option_d)
          <div class=""><span class=" @if($t->answer=='D') text-success font-weight-bold @endif">(D)</span><div class="pt-1 d-inline "> {!! $question->option_d!!}</div></div>
          @endif
            </div>
          </div>
          
          
          @if($question->option_e)
          <div class=""><span class=" @if($t->answer=='E') text-success font-weight-bold @endif">(E)</span><div class="pt-1 d-inline "> {!! $question->option_e!!}</div></div>
          @endif
        </div>
        @endif
        <hr>


        @if($questions[$t->question_id]->type=='code' || $questions[$t->question_id]->type=='csq')
        <p><b>User Code:</b></p>
        <pre class="mb-3" style="">
          <code style="overflow-wrap: break-word;word-wrap: break-word">{!! htmlentities($t->code) !!}
          </code>
        </pre>

        @endif

        

        <p><b>User Response: </b> <span class="float-right"><b><i class="fa fa-clock-o"></i> Time spent:</b> {{$t->time}} sec</span></p>

          @if($questions[$t->question_id]->type=='urq')
          <div class="{{$w=0}}">
           @if(isset($questions[$t->question_id]->images))

          @if(count($questions[$t->question_id]->images))
          @foreach($questions[$t->question_id]->images as $k=>$url)

             <div class=" {{$w=$w+1}}">
              
              <a href="#" id="{{$k}}" class="d-none" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}" data-id="{{$t->question_id}}_{{$w}}" data-eurl="{{ route('assessment.solutions.q.post',[$exam->slug,$t->question_id])}}?student={{request()->get('student')}}" data-qid="{{$t->question_id}}"><img src="{{$url}}"  class=" p-1  my-1 w-100 img_{{$t->question_id}}_{{$w}}" data-name="{{$k}}"  /></a>
                
               <div class="@if(request()->get('mode')==2) pr-4 @endif" style="width:{{$exam->getDimensions2($url,1,0.70)}}px;height:{{$exam->getDimensions2($url,2,0.7)}}px;"> 
              <canvas  id="sketchpad_{{$t->question_id}}_{{$k}}" class="@if(request()->get('mode')==2))  ml-4 @endif border" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}" data-id="{{$t->question_id}}_{{$w}}" data-eurl="{{ route('assessment.solutions.q.post',[$exam->slug,$t->question_id])}}?student={{request()->get('student')}}" data-qid="{{$t->question_id}}" style="background: url('{{$url}}');width:{{$exam->getDimensions2($url,1,0.70)}}px;height:{{$exam->getDimensions2($url,2,0.70)}}px;background-size: {{$exam->getDimensions2($url,1,0.70)}}px {{$exam->getDimensions2($url,2,0.70)}}px;"><canvas>
              
             </div>

          <div class=" pt-2 pb-4">
              <a href="#" class="btn btn-outline-primary @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif my-2  rotate_save2" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=90&name={{$k}}&url={{$url}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}" >Rotate Left</a>

              <a href="#" class="btn btn-outline-primary @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif my-2  rotate_save2" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=-90&name={{$k}}&url={{$url}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}">Rotate Right </a> 
              <a href="#" class="btn btn-outline-primary @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif my-2  rotate_save2 d-none" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=100&name={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$k}}">Load Original </a> 
                <a href="{{ route('assessment.responses',[$exam->slug])}}?k={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&imageback=1 @if(request()->get('mode')==2)) &mode=2 @endif" class="btn btn-outline-info @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif my-2   refresh_image" data-url="" data-id="{{$t->question_id}}_{{$k}}">Refresh Image </a> 
                &nbsp;&nbsp;

          <button type="button" class="btn btn-outline-dark  @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif   d-inline" data-item='sketchpad_{{$t->question_id}}_{{$k}}' onclick="clear_{{$t->question_id}}_{{$k}}()">Clear</button>
            <button type="button" class="btn btn-outline-dark  @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif   d-inline" data-item='sketchpad_{{$t->question_id}}_{{$k}}' onclick="undo_{{$t->question_id}}_{{$k}}()">Undo</button>
          <button type="button" class="btn btn-outline-dark  @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif  d-inline" data-item='sketchpad_{{$t->question_id}}_{{$k}}' onclick="redo_{{$t->question_id}}_{{$k}}()">Redo</button>
              
          <button type="button" class="btn btn-success save_image2 @if(request()->get('mode')==2)) btn-lg @else btn-sm @endif d-inline " data-url="{{ route('assessment.solutions.q.post',[$exam->slug,$t->question_id])}}?student={{request()->get('student')}}" data-name="{{$k}}"  data-named="sketchpad_{{$t->question_id}}_{{$k}}" data-imgurl="{{$url}}" data-student="{{request()->get('student')}}" data-token="{{ csrf_token() }}" data-user_id="{{ $student->id }}" data-slug="{{$exam->slug}}"  data-qid="{{$t->question_id}}" data-id="{{$t->question_id}}_{{$w}}"  data-width="{{$exam->getDimensions2($url,1,0.83)}}" data-height="{{$exam->getDimensions2($url,2,0.83)}}">
              Save Image
            </button>

            <div class="spinner-border  spinner-border-sm mt-1 ml-3  img_loading_{{$t->question_id}}_{{$w}}"  style="display:none" role="status">
                    <span class="sr-only">Loading...</span> 
                  </div>
                  <span class="text-success ml-4 saved_{{$t->question_id}}_{{$w}}" style="display:none" ><i class="fa fa-check-circle"></i> successfully saved</span>
                <div>
                <span class="text-secondary">Loading Original or Rotating the image will auto reload the page.</span>
              </div>
          </div>
          
          </div>

          @endforeach
          @else
            -
          @endif

          @else
          -

          @endif

         
          </div>

        @else

        @if($questions[$t->question_id]->type!='vq' && $questions[$t->question_id]->type!='aq')
          @if(trim(strip_tags($t->response)))
          {!! nl2br($t->response) !!} 
          @else
          -
          @endif
          @if($t->accuracy)
            @if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')

              @if(!$t->mark)
              <i class="fa fa-times-circle text-danger"></i>
              @else
              <i class="fa fa-check-circle text-success"></i>
              @endif
            @else
            <i class="fa fa-check-circle text-success"></i>
            @endif
          @else

            @if($questions[$t->question_id]->type=='mcq' || $questions[$t->question_id]->type=='maq' || $questions[$t->question_id]->type=='fillup')
            <i class="fa fa-times-circle text-danger"></i>
            @else
              @if($t->mark==0 && $questions[$t->question_id]->type!='urq' && $questions[$t->question_id]->type!='sq')

              <i class="fa fa-times-circle text-danger"></i>
              @endif
            @endif
          @endif
        @else

        @if($questions[$t->question_id]->type=='vq')
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_'.$t->question_id.'.webm'))
        <video
    id="my-video"
    class="video-js"
    controls
    preload="auto"
    width="400"
    data-setup="{}"
  >
    <source src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_video_'.$t->question_id.'.webm')}}" type="video/webm" />
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank"
        >supports HTML5 video</a
      >
    </p>
  </video>
        @endif
        @endif

        @if($questions[$t->question_id]->type=='aq')
         @if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_audio_'.$t->question_id.'.wav'))
       <audio controls="" src="{{Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$student->username.'_'.$exam->id.'_audio_'.$t->question_id.'.wav')}}">
            Your browser does not support the
            <code>audio</code> element.
    </audio>
        @endif
        @endif

        
          @endif
        @endif


        @if($questions[$t->question_id]->type=='sq')
        @if($d=json_decode($t->comment))
        
        <div class="row" >
            <div class="col-6 col-md-3">
              <div class="p-3 bg-light rounded my-3 border" >
                <h5>Engagement</h5>
                <div class="display-3">{{$d->Engagement}}</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 bg-light rounded my-3 border">
                <h5>Tone</h5>
                <div class="display-3">{{$d->Tone}}</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 bg-light rounded my-3 border">
                <h5>Correctness</h5>
                <div class="display-3">{{$d->Correctness}}</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 bg-light rounded my-3 border">
                <h5>Clarity</h5>
                <div class="display-3">{{$d->Clarity}}</div>
              </div>
            </div>
        </div>

        @endif
        @endif


        @if($questions[$t->question_id]->type=='aq')
        @if($d=json_decode($t->comment))
        <div class="row" >
            <div class="col-6 col-md-4">
              <div class="p-3 bg-light rounded my-3 border" >
                <h5>Accuracy</h5>
                @if(isset($d->Accuracy))
                <div class="display-3">{{$d->Accuracy}}</div>
                @elseif(isset($d->accuracy))
                <div class="display-3">{{$d->accuracy}}</div>
                @else
                <div class="display-3">-</div>
                @endif
              </div>
            </div>
            <div class="col-6 col-md-4">
              <div class="p-3 bg-light rounded my-3 border">
                <h5>Fluency</h5>
                @if(isset($d->Fluency))
                <div class="display-3">{{$d->Fluency}}</div>
                @elseif(isset($d->fluency))
                <div class="display-3">{{$d->fluency}}</div>
                @else
                <div class="display-3">-</div>
                @endif
              </div>
            </div>
            <div class="col-6 col-md-4">
              <div class="p-3 bg-light rounded my-3 border">
                <h5>Completeness</h5>
                @if(isset($d->Completeness))
                <div class="display-3">{{$d->Completeness}}</div>
                @elseif(isset($d->completeness))
                <div class="display-3">{{$d->completeness}}</div>
                @else
                <div class="display-3">-</div>
                @endif
              </div>
            </div>
           
        </div>

        @endif
        @endif

        @if($questions[$t->question_id]->type=='code')
       @if(isset(json_decode($t->comment,true)['pass_1']))
        <p class="mt-3"><b>Testcases:</b></p>
        
        <table>
        <thead style="background: #eee">
      <tr>
        <th></th>
        <th>Status</th>
        <th>Correct Output</th>
        <th>User Output</th>
        <th>Execution Time (ms)</th>
      </tr>
    </thead>
    <tbody>
      @if(isset(json_decode($t->comment,true)['pass_1']))
      <tr>
        <td>#1</td>
        <td>@if(json_decode($t->comment,true)['pass_1']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        <td>@if(trim(json_decode($t->comment,true)['response_1']['stderr'])) {{ json_decode($t->comment,true)['response_1']['stderr']}} @else
          {!! nl2br(json_decode($t->comment,true)['response_1']['stdout']) !!}
        @endif</td>
        <td>{{ json_decode($t->comment,true)['response_1']['time']}}</td>
      </tr>
      @if(isset(json_decode($question->a)->out_2) && isset(json_decode($question->a)->out_2))
      <tr>

        @if(isset(json_decode($t->comment,true)['pass_2']))
        <td>#2</td>
        <td>@if(json_decode($t->comment,true)['pass_2']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>@if(json_decode($question->a)->out_2){{ json_decode($question->a)->out_2 }} @else {{json_decode($question->a)->out_1}} @endif</td>
        <td>@if(trim(json_decode($t->comment,true)['response_2']['stderr'])) {{ json_decode($t->comment,true)['response_2']['stderr']}} @else
          {!! nl2br(json_decode($t->comment,true)['response_2']['stdout']) !!}
        @endif</td>
        <td>{{ json_decode($t->comment,true)['response_2']['time']}}</td>
      </tr>
      <tr>
        <td>#3</td>
        <td>@if(json_decode($t->comment,true)['pass_3']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>@if(json_decode($question->a)->out_3){{ json_decode($question->a)->out_3 }} @else {{json_decode($question->a)->out_1}} @endif</td>
        <td>@if(trim(json_decode($t->comment,true)['response_3']['stderr'])) {{ json_decode($t->comment,true)['response_3']['stderr']}} @else
          {!! nl2br(json_decode($t->comment,true)['response_3']['stdout']) !!}
        @endif</td>
        <td>{{ json_decode($t->comment,true)['response_3']['time']}}</td>
      </tr>
      @endif

      @endif

      @if(isset(json_decode($t->comment,true)['pass_4']) && isset(json_decode($question->a)->out_4))
      <tr>
        <td>#4</td>
        <td>@if(json_decode($t->comment,true)['pass_4']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>@if(json_decode($question->a)->out_4){{ json_decode($question->a)->out_4 }} @else {{json_decode($question->a)->out_1}} @endif</td>
        <td>@if(trim(json_decode($t->comment,true)['response_4']['stderr'])) {{ json_decode($t->comment,true)['response_4']['stderr']}} @else
          {!! nl2br(json_decode($t->comment,true)['response_4']['stdout']) !!}
        @endif</td>
        <td>{{ json_decode($t->comment,true)['response_4']['time']}}</td>
      </tr>

      @endif

        @if(isset(json_decode($t->comment,true)['pass_5']) && isset(json_decode($question->a)->out_5))
      <tr>
        <td>#5</td>
        <td>@if(json_decode($t->comment,true)['pass_5']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>@if(json_decode($question->a)->out_5){{ json_decode($question->a)->out_5 }} @else {{json_decode($question->a)->out_1}} @endif</td>
        <td>@if(trim(json_decode($t->comment,true)['response_5']['stderr'])) {{ json_decode($t->comment,true)['response_5']['stderr']}} @else
          {!! nl2br(json_decode($t->comment,true)['response_5']['stdout']) !!}
        @endif</td>
        <td>{{ json_decode($t->comment,true)['response_5']['time']}}</td>
      </tr>

      @endif

      @endif
      
    </tbody>
  </table>

        @endif
        @endif

          </div>
          <div class=" @if(request()->get('mode')==2) col-12 @else col-3 @endif">
            <div class="item fixed sticky rounded @if($t->status!=2)qgreen @else qyellow @endif mb-3 mt-3 mt-md-0 box_{{$t->question_id}}">
      <div class="card-body ">

        <p>Status: @if($t->status==2)<span class="badge badge-warning review_{{$t->question_id}}">Q{{(intval($k)+1)}} - under review</span>
        @else
        <span class="badge badge-success review_{{$t->question_id}}">evaluated</span>
        @endif</p>
        <hr>
        <b>Score</b><br>
        

     <div class="mb-3 score_entry_{{$t->question_id}}"  style="@if($t->status!=2) display:none @endif">
      @foreach(range(0,$questions[$t->question_id]->mark,0.5) as $r)
        <div class="form-check form-check-inline">
        <input class="form-check-input score_{{$t->question_id}}" type="radio" name="score_{{$t->question_id}}" id="" value="{{$r}}" @if($t->mark==$r)checked @endif>
        <label class="form-check-label" for="inlineRadio1">{{$r}}</label>
      </div>
      @endforeach
      
      <div class="my-2"><b>Feedback</b></div>
      <textarea class="form-control comment_{{$t->question_id}}" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>

      <div class="d-flex align-items-center float-right" style="@if($t->status!=2) display: none @endif">
        <div class="spinner-border spinner-border-sm  float-right loading_{{$t->question_id}}"  style="display:none" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <button class="btn btn-primary btn-sm score_save score_save_{{$t->question_id}}" data-id="{{$t->question_id}}" data-slug="{{$exam->slug}}"  data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?ajax=1" data-student="{{request()->get('student')}}" data-token="{{csrf_token()}}" style="@if($t->status!=2) display: none @endif">Save Score</button>


         
        
     
     <div class="score_entry_val_{{$t->question_id}}" style="@if($t->status==2) display:none @endif"><div>{{$t->mark}} <i class="fa fa-edit text-primary cursor score_edit" data-id="{{$t->question_id}}"></i></div></div>

       @if(isset($t->comment))
         @if($t->comment)
         @if($questions[$t->question_id]->type!='code')
          @if(!isset(json_decode($t->comment,true)['response_1']) && $t->comment!='null')
          @if(!json_decode($t->comment))
          <div class="feedback_{{$t->question_id}}">
          <div class="my-2"><b>Feedback</b></div>
          <p> {{$t->comment}} </p>
          </div>
          @endif
          @endif
         @endif

         @endif
       @endif
     

       

      </div>

    </div>

   
          </div>
        </div>
    
			</div>
		</div>
	</div>

	<div class="col-12 col-md-2 col-lg-3 "  data-html2canvas-ignore="true">
    <div class="mt-1 ml-2">
		
  </div>
	</div>
</div>
@endforeach


</div>

</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Correct Paper</h1>
        <button type="button" class="btn btn-danger clear_image float-right d-inline">clear</button>
        <button type="button" class="btn btn-primary save_image float-right d-inline" data-url="{{ route('assessment.solutions.q.post',[$exam->slug,11])}}?student={{request()->get('student')}}" data-name="" data-imgurl="" data-student="{{request()->get('student')}}" data-token="{{ csrf_token() }}" data-user_id="{{ $student->id }}" data-slug="{{$exam->slug}}"  data-qid="11" data-id="" data-width="1100" data-height="">
          Save
        </button>
      </div>
      <div class="modal-body">
        <div class="canvas_message"></div>
        <div class="canvas">
        
      </div>
        <img id="image_display" style="display: none">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Add Comment</h1>
        <button type="button" class="btn btn-danger  float-right d-inline" data-dismiss="modal">close</button>
      </div>
      <div class="modal-body">
          <div >
      <form method="POST" action="{{route('assessment.comment',$exam->slug)}}" >
  <div class="form-group">
    <label for="exampleInputPassword1">Enter your comment</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment">@if(trim($test_overall->comment)!='') {{$test_overall->comment}}@endif</textarea>
    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ $student->id }}">
        <input type="hidden" name="username" value="{{ $student->username }}">
        <input type="hidden" name="test_id" value="{{ $exam->id }}">
        <input type="hidden" name="slug" value="{{ $exam->slug }}">
          <input type="hidden" name="refresh" value="1">
        <input type="hidden" name="test_overall" value="{{ $test_overall->id }}">

  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

  </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Refresh Image (Load Original)</h1>
      </div>
      <div class="modal-body">
          <div >
  <div class="form-group">
    Kindly note that refreshing the image will load the original image by which any annotations made will be lost. Use this option only when you want to discard all the changes made and revert back the original image.
  </div>
  <button type="button" class="btn btn-danger  d-inline dclose">No, close this tab</button>
  <a href="#"  class="btn btn-primary refresh_image_url mt-2 mt-md-0">Yes, I confirm to load the original image</a>


  </div>
      </div>
    </div>
  </div>
</div>

</div>

<script src="{{ asset('js/script.js')}}?new=35"></script>
<script src="{{asset('js/sketch.js')}}"></script>  
<script>



@foreach($tests as $k=>$t)
@if($questions[$t->question_id]->type=='urq')
@if(isset($questions[$t->question_id]->images))
@if(count($questions[$t->question_id]->images))
@foreach(array_reverse($questions[$t->question_id]->images) as $k=>$url)
if($('#sketchpad_{{$t->question_id}}_{{$k}}').length){
var sketchpad_{{$t->question_id}}_{{$k}} = new Sketchpad({
  element: '#sketchpad_{{$t->question_id}}_{{$k}}',
  width: {{$exam->getDimensions2($url,1,0.7)}},
  height: {{$exam->getDimensions2($url,2,0.7)}}
});

sketchpad_{{$t->question_id}}_{{$k}}.color = '#ff0000'
}

function clear_{{$t->question_id}}_{{$k}}(){
  sketchpad_{{$t->question_id}}_{{$k}}.clear();
}

function undo_{{$t->question_id}}_{{$k}}(){
  sketchpad_{{$t->question_id}}_{{$k}}.undo();
}

function redo_{{$t->question_id}}_{{$k}}(){
  sketchpad_{{$t->question_id}}_{{$k}}.redo();
}
@endforeach
@endif
@endif
@endif
@endforeach




</script>

<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>

<script>

    // function downloadpdf(){
    //     var element = document.getElementById('pdf');
    //     var pdfbtn = document.getElementById('pdfbtn');
    //     var name = pdfbtn.getAttribute('data-name');
    //     //alert(name);
    //     html2pdf().from(element).save(name+'.pdf');

    // }

  function downloadpdf() {
      var element = document.getElementById('pdf');
      var pdfbtn = document.getElementById('pdfbtn');
      var name = pdfbtn.getAttribute('data-name')+'.pdf';
        var opt = {
            margin: 0 ,
            dpi: 96,
            filename: name,
            image: { type: 'jpeg', quality: 1 },
      html2canvas: {
        dpi: 130,
        scale:1,
        letterRendering: true,
        useCORS: true
      },
            jsPDF:{ unit: 'in', format: 'letter', orientation: 'portrait' },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        }
        // var input = document.getElementById("pdfContainer");
        // console.log(input)
        html2pdf(element, opt)
    }

  

</script>
<script>
  if(typeof video !== 'undefined'){
      video.addEventListener('loadedmetadata', function() {
    if (video.buffered.length === 0) return;

    const bufferedSeconds = video.buffered.end(0) - video.buffered.start(0);
    console.log(`${bufferedSeconds} seconds of video are ready to play.`);
  });
  }

  $(function(){
    $(document).on('click','.refresh_image',function(e){
      $url = $(this).attr('href');
      $('.refresh_image_url').attr('href',$url);
      e.preventDefault();
      $('#exampleModal3').modal();
    });

    $(document).on('click','.dclose',function(e){
      $('#exampleModal3').modal('hide');
    });
  });

</script>

<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>


@endsection           