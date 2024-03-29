@extends('layouts.nowrap-white')
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
              <div class="col-6 col-md-4">
                <div class=" p-3  mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
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

            <div class="col-12">
              <h4 class="mt-4">Tools</h4>
              <div class="dropdown d-inline mb-3">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fa fa-download"></i>&nbsp; Download PDF
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index:2000">
              <a id="pdfbtn" class="dropdown-item pdfbtn cursor" onclick="downloadpdf()" data-name="{{$student->roll_number}}_{{$student->name}}_{{$exam->name}}" data-html2canvas-ignore="true">Format #1</a>
              <a class="dropdown-item" href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&pdf3=1&screen=1">Format #2</a>
                <a class="dropdown-item" href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&pdf3=1">Format #3</a>
            </div>
          </div>
             
              <button  class="btn btn-outline-dark btn-sm ml-2" data-toggle="modal" data-target="#exampleModal2" data-html2canvas-ignore="true">Add Comment</button>
              <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$student->username}}&refresh=1"  class="btn btn-outline-dark btn-sm mt-2 mt-md-0" >Refresh Cache</a>
               <a href="{{ route('test.attempt',$exam->slug)}}"  class="btn btn-outline-dark btn-sm  mt-2 mt-md-0" >Add Attempt</a>
            
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
	<div class="col-12 col-md col-lg">
		<div class="card mb-3">
			<div class="card-body">
        <div class=" p-1 px-3 mr-2 rounded text-center bg-light border d-inline ">{{($k+1)}}</div>
           <div class="d-none {{ $question = $t->question}} "></div>
				<p class="d-inline  mb-3">{!! $questions[$t->question_id]->question !!}</p>


       
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
          @foreach(array_reverse($questions[$t->question_id]->images) as $k=>$url)

             <div class="border border-secondary {{$w=$w+1}}">
              <a href="#" id="{{$k}}" class="@if(auth::user()->checkRole(['hr-manager','administrator'])) correct_image @endif" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}" data-id="{{$t->question_id}}_{{$w}}" data-eurl="{{ route('assessment.solutions.q.post',[$exam->slug,$t->question_id])}}?student={{request()->get('student')}}" data-qid="{{$t->question_id}}"><img src="{{$url }}"  class=" p-1  my-1 w-100 img_{{$t->question_id}}_{{$w}}" data-name="{{$k}}"  />
              </a>
              @if(auth::user()->checkRole(['hr-manager','administrator']))
              <a href="#" class="btn btn-outline-primary my-2 mr-1 ml-1 rotate_save" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=90&name={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}" >left <i class="fa fa-rotate-left"></i></a>

              <a href="#" class="btn btn-outline-primary my-2 mr-1 ml-1 rotate_save" data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?rotate=-90&name={{$k}}&qid={{$t->question_id}}&student={{$student->username}}&ajax=1" data-id="{{$t->question_id}}_{{$w}}">right <i class="fa fa-rotate-right"></i></a>

               <div class="d-flex align-items-center float-right p-3" >
  <div class="spinner-border spinner-border-sm   img_loading_{{$t->question_id}}_{{$w}}"  style="display:none" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>

              <a href="#" class="btn btn-outline-success my-2 correct_image  correct_image_{{$t->question_id}}_{{$w}} ml-1" data-eurl="{{ route('assessment.solutions.q.post',[$exam->slug,$t->question_id])}}?student={{request()->get('student')}}" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-id="{{$t->question_id}}_{{$w}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}" data-qid="{{$t->question_id}}"> <i class="fa fa-pencil"></i> pen</a>
              @endif
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

        @if($questions[$t->question_id]->type!='vq')
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
		</div>
	</div>

	<div class="col-12 col-md-2 col-lg-3 "  data-html2canvas-ignore="true">
    <div class="mt-md-1 ml-md-2">
		<div class="sticky rounded @if($t->status!=2)qgreen @else qyellow @endif mb-5 mb-md-3 mt-1 mt-md-3 mt-md-0 box_{{$t->question_id}}">
			<div class="card-body ">

				<p>Status: @if($t->status==2)<span class="badge badge-warning review_{{$t->question_id}}">under review</span>
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
      <button class="btn btn-primary btn-sm score_save score_save_{{$t->question_id}}" data-id="{{$t->question_id}}" data-slug="{{$exam->slug}}"  data-url="{{ route('assessment.solutions.q',[$exam->slug,$t->question_id])}}?ajax=1" data-student="{{request()->get('student')}}" data-token="{{csrf_token()}}" style="@if($t->status!=2) display: none @endif">save</button>
     
     <div class="score_entry_val_{{$t->question_id}}" style="@if($t->status==2) display:none @endif"><div>{{$t->mark}} <i class="fa fa-edit text-primary cursor score_edit" data-id="{{$t->question_id}}"></i></div></div>

       @if(isset($t->comment))
         @if($t->comment)
         @if($questions[$t->question_id]->type!='code')
          @if(!isset(json_decode($t->comment,true)['response_1']) && $t->comment!='null')
          @if(!json_decode($t->comment))
          <div class="my-2"><b>Feedback</b></div>
          <p> {{$t->comment}} </p>
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
@endforeach


<a href="{{ route('test.attempt',$exam->slug)}}"  class="btn btn-outline-dark   my-3 w-100 " >Add User Attempt</a>

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
        <button type="button" class="btn btn-danger  float-right d-inline">close</button>
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
        <input type="hidden" name="test_overall" value="{{ $test_overall->id }}">

  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

  </div>
      </div>
    </div>
  </div>
</div>

</div>


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

</script>

<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>


@endsection           