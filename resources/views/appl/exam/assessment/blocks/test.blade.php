@extends('layouts.none')
@section('title', $exam->name.' ')
@section('content')


<div class="testpage_wrap">
<div class="p-2 p-md-3 testpage " style="display: none">
<form method="post" class="assessment" id="assessment" data-window_swap="{{$exam->window_swap}}"  data-camera="{{$exam->camera}}" data-auto_terminate="{{$exam->auto_terminate}}" data-username="{{\auth::user()->username}}" data-uname="{{\auth::user()->name}}" data-rollnumber="{{\auth::user()->roll_number}}" data-exam_time="{{$time}}" data-start="@if(isset($settings['start_time'])) {{$settings['start_time']}} @endif" data-fullscreen="@if(isset($settings['fullscreen'])) {{$settings['fullscreen']}} @endif" data-upload_time="@if(isset($settings['upload_time'])) {{$settings['upload_time']}} @endif" data-camera360="@if(isset($cam360)) {{$cam360}} @endif" data-videosnaps="@if(isset($settings['videosnaps'])) {{$settings['videosnaps']}}@else 0 @endif" data-first="{{$data['first']}}" data-last="{{$data['last']}}" data-stopswap="{{$data['stopswap']}}" data-slast="{{$data['slast']}}" data-vques="0" data-system_check="@if(isset($settings['system_check'])) {{$settings['system_check']}}@else 1 @endif" data-face_detect="@if(isset($settings['videosnaps'])) @if($settings['videosnaps']==100) 1 @else 0 @endif @else 0 @endif"

action="{{ route('assessment.submission',$exam->slug)}}" enctype="multipart/form-data">
  <style>
.blink {
  animation: blinker 1s linear infinite;
}
.video_small{ max-width:80px;height:60px; }

@keyframes blinker {
  50% {
    opacity: 0;
  }
  
}
</style>


  <div class="row">
    <div class="col-md-9">

      <div class=" rounded p-3 mb-3 h4 d-none d-md-block  sample" style="border:#dad6b5;background:#f8efba;">
     
        @if(isset($exam->image))
        @if(Storage::disk('s3')->exists($exam->image))
        <picture>
        <img 
      src="@if(isset($images['logo'])){{ $images['logo'] }} @endif " class="test_logo d-print-none mr-2" alt="{{  $exam->name }}" style='max-width:40px;'>
      </picture>
        @endif
        @else
        <i class="fa fa-newspaper-o"></i> 
        @endif

        {{$exam->name}} 
        @if(request()->get('admin'))
        <span class="badge badge-primary">Admin Mode</span> <span class="badge badge-success"><i class="fa fa-user"></i> {{$user->name}}</span>
        @endif

        <div class="float-right d-inline">
          <a href="#" data-toggle="modal" data-target="#instructions">
            <i class="fa fa-info-circle ml-2 cursor" data-toggle="tooltip"  title="View Instructions" ></i></a>
          
            @if(isset($settings['upload_time']))
          @if($settings['upload_time']!=0)
          <a href="#" data-toggle="modal" data-target="#questions">
            <i class="fa fa-question-circle ml-2 cursor" data-toggle="tooltip"  title="View Questions"></i></a>
            @endif
            @endif
          
          @if(isset($settings['chat']))
          @if(strtolower($settings['chat'])=='yes')
             <i class="fa fa-commenting-o text-success ml-2 text-primary cursor m_student m_{{$user->username}}" data-urlpost="{{$urls['chat_post']}}" data-toggle="tooltip"  title="Message proctor" data-username="{{$user->username}}" data-name="{{$user->name}}"data-url="{{$urls['chat']}}" data-lastchat=""></i> 
          @endif
          @endif
        
      </div>
      </div>
          <div class=" mb-3 d-block d-md-none ">
  <div class="blogd text-white pl-3 pr-3 pb-2 pt-3 pb-2 rounded" style="background:#ca2428">

@if(isMobileDevice())
    <div class="camera_holder d-inline d-md-none float-right">
<div class="">
  <img id="photo3" class="d-none" style="position: absolute;right:31px;top:15px" src=""> 
    <video id="video" class="video_small" data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="{{ ($time*60*1000)/20}}" data-c="{{$c}}" data-cc="0" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}" style="width:60px;height:60px;position: absolute;right:31px;top:15px">Video stream not available.</video>
    <canvas id="canvas" style='display: none'></canvas>
     <canvas id="canvas3" style='display: none' ></canvas>
    <div class="output">
    <img id="photo" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="{{ ($time*60*1000)/20}}" data-c="{{$c}}"  data-cc="0" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}" data-bucket="{{ env('AWS_BUCKET')}}" data-region="{{ env('AWS_DEFAULT_REGION')}}" data-rollnumber="{{\auth::user()->roll_number}}" data-uname="{{\auth::user()->name}}" data-last_photo="" style='display: none'> 
  </div>
</div>
</div>
@endif



    @if(isset($settings['section_timer']))
      @if($settings['section_timer']!='unlimited')
    <div class="mb-2 h5"> <i class="fa fa-clock-o"></i> <span class="text-bold " id="timer2"></span></div>
    @endif
    @endif
    <div class="text-warning mb-3">
      <div class="d-inline">
          <a href="#" class="text-light" data-toggle="modal" data-target="#instructions">
            <i class="fa fa-info-circle  mr-4 cursor" data-toggle="tooltip"  title="View Instructions" ></i></a>

           @if(isset($settings['upload_time']))
          @if($settings['upload_time']!=0)
          <a href="#" class="text-light" data-toggle="modal" data-target="#questions">
            <i class="fa fa-question-circle mr-4 cursor" data-toggle="tooltip"  title="View Questions"></i></a>
            @endif
            @endif

            @if(isset($settings['chat']))
          @if(strtolower($settings['chat'])=='yes')
             <i class="fa fa-commenting-o text-light mr-4 cursor m_student m_{{$user->username}}" data-urlpost="{{$urls['chat_post']}}" data-toggle="tooltip"  title="Message proctor" data-username="{{$user->username}}" data-name="{{$user->name}}"data-url="{{$urls['chat']}}" data-lastchat=""></i> 
          @endif
          @endif
        @if(isset($exam->calculator))
    @if($exam->calculator)
    <span class=" mr-4 text-light" style="cursor: pointer" data-toggle="modal" data-target="#calculator"><i class="fa fa-calculator text-light" aria-hidden="true"></i> </span>
    @endif
    @endif

        <a href="#" data-toggle="modal" class="text-light" data-target="#student_info">
            <i class="fa fa-user-circle mr-4 cursor" data-toggle="tooltip"  title="View Student Info"></i></a>
      </div>
    </div>

    <div class="p-2 mb-2 rounded" style="border:2px solid #bb061c">
    <div class="row ">
      <div class="col-3">
        <div class="left-qno cursor w100 p-1 text-center pl-2 " @if($data['sno']==1) data-sno="" @else data-sno="{{($data['sno']-1)}}" @endif  style="display:none"><i class="fa fa-angle-double-left"data-testname="{{$exam->slug}}" ></i></div>
      </div>

      <div class="col-6"> <div class="mt-1 text-center ques_count cursor" data-count="{{count($questions)}}" data-url="{{route('assessment.savetest',$exam->slug)}}" data-save="@if(isset($exam->save)) @if($exam->save) 1 @else 0 @endif @else 0 @endif">Q({{ count($questions) }})</div></div>
      <div class="col-3"> 
        <div class="right-qno cursor w100 p-1 text-center mr-3 " data-sno="{{($data['sno']+1)}}" data-testname="{{$exam->slug}}" ><i class="fa fa-angle-double-right" ></i></div>
      </div>


    </div>
    </div>

    @if(isMobileDevice())
    <div class="qsset" style="display:none">
    <div class="qset" style="max-height: 170px;overflow-y: auto;" data-url="{{ URL::current() }}" data-lastsno="{{ count($questions)  }}" data-counter="0" data-user="{{ \auth::user()->id }}" data-sno="{{ $i=0 }}" >
      <div class="start"></div> 
      @foreach($exam->sections as $section)
        @if(count($exam->sections)!=1)
        <div class="mb-1 " style="background:#b91427; color:white;border: 1px solid #ab0014;padding:3px;border-radius:4px;"><div class="p-1 ">{{$section->name}}</div></div>
        @endif
        <div class="row no-gutters ">
        @if(isset($section_questions[$section->id]))
        @foreach($section_questions[$section->id] as $key=> $q)
          <div class="col-3 mb-1">
            <div class="pr-1">
            <div class="w100 p-1 test2qno s{{ (++$i ) }} cursor text-center rounded qborder  @if($q->response) qblue-border @endif @if(count($q->images)) qblue-border @endif @if(!$data['qid']) @if($i==1) active @endif @else @if($q->id==$data['qid']) active @endif @endif" id="q{{ ($q->id )}}" data-qno="{{$q->id}}"  data-sno="{{ ($i) }}" 
                >{{ ($i ) }}</div>
            </div>
          </div>
        @endforeach
        @endif
        </div>
      @endforeach
    </div>
  </div>
  @endif
    
  </div>
</div>
 
<div class="p-3 border rounded bg-light {{ $i=0 }}" style="margin-bottom: -5px;"> <h5 class="mb-1">Sections: &nbsp;&nbsp;
  @foreach($exam->sections as $section)
        
        @if(isset($section_questions[$section->id][0]))
         @foreach($section_questions[$section->id] as $key=> $q)
         @if($key==0)
        <span class="cursor bg-white border p-1 px-2 rounded test2qno " id="q{{ ($section_questions[$section->id][0]->id )}}" data-qno="{{$section_questions[$section->id][0]->id}}"  data-sno="{{($i+1)}}"  style="line-height: 30px">{{$section->name}} <span class="badge badge-light border">{{count($section_questions[$section->id])}}</span></span>
        @endif
        <span class="d-none">{{$i=$i+1}}</span>
        @endforeach
        @endif

     
      @endforeach
  
</h5></div>


     @include('appl.exam.assessment.blocks.questions')
    </div>
     <div class="col-md-3 pl-md-0">
      @include('appl.exam.assessment.blocks.qset')
    </div>
  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Confirm Submission</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

        <div class="alert alert-warning alert-important mb-3">
          The following action will save the responses and ends the test.
        </div>
        
<!--
        <div class="row mb-3">
          <div class="col-12 col-lg-2">
            <div class="row">
              <div class="col-6 col-md-12">
                <div class="bg-light p-3 border rounded mb-3">
              <h5>Attempted</h5>
              <div class="display-3 attempt_count">234</div>
            </div>
              </div>
              <div class="col-6 col-md-12">
                <div class="bg-light p-3 border rounded mb-3">
              <h5>Not Attempted</h5>
              <div class="display-3 notattempt_count">24</div>
            </div>
              </div>
            </div>
            
            
          </div>
          <div class="col-12 col-lg-10">
            <div class="p-1 p-md-4 rounded attempted">
              <div class="row">
          @for($i=1;$i<= count($questions);$i++)
          <div class="col-6 col-md-6 col-lg-3"><div class="mb-2"><div class=" px-2 py-1 rounded notattempt_color_{{$i}} d-inline ">{{$i}}. <span class="notattempt_message_{{$i}}">Attempted</span></div></div></div>
          @endfor
        </div>
            </div>
          </div>
        </div>
   -->   

       <div class="attempted @if(isset($code_ques))@if(count($code_ques)) d-none @endif @endif"  >
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col" width="20%" style="text-align: center;">Qno</th>
              <th scope="col">Response</th>
            </tr>
          </thead>
          <tbody>
            @foreach($questions as $i=> $question)
             <tr>
                <th scope="row">
                  <div class="w100 p-1 test2qno s{{ ($i+1 ) }} cursor text-center rounded qborder  @if($question->response) qblue-border text-white @endif @if(count($question->images)) qblue-border text-white @endif active " id="q{{ ($question->id )}}" data-qno="{{$question->id}}"  data-sno="{{ ($i+1) }}" 
                >{{ ($i+1 ) }}</div>
                </th>
                <td>
                  <div class="final_response final_response_{{($i+1)}}">
                    @if($question->response)
                    {{$question->response}}
                    @endif
                  </div>
                  <div class="img_c img_c_{{$i+1}} {{$m=0}}" style="width:150px;">
                    @if($question->images)
                      @foreach(array_reverse($question->images) as $img)
                        <img id="" class="img_{{$i+1}} w-100 {{$m=1}} my-2 border" src="{{$img}}" style="max-width:150px"/>
                      @endforeach
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I will solve more questions</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @if(request()->get('admin'))
        <input type="hidden" name="admin" value="1">
        @else
        <input type="hidden" name="admin" value="0">
        @endif

        @if(request()->get('responses'))
        <input type="hidden" name="responses" value="1">
        @else
        <input type="hidden" name="responses" value="0">
        @endif

        <input type="hidden" name="test_id" value="{{ $exam->id }}">
        <input type="hidden" name="save" class="save_test" value="{{ $exam->save }}">
        <input type="hidden" name="code" value="{{ request()->get('code') }}">
        <input type="hidden" name="window_change" value="{{ isset(json_decode($json_log,true)['window_change'])?json_decode($json_log,true)['window_change'] : '0'}}" id="window_change">
        <button type="submit" class="btn  btn-warning " data-submit="1">
           I confirm, End Test
        </button>
      </div>
    </div>
  </div>
</div>
<style>
div.attempted {
  background-color: #f4fbff;
  border:1px solid #e1eef5;
  height: 230px;
  overflow: auto;
}
div.attempted2 {
  background-color: #f4fbff;
  border:1px solid #e1eef5;
  height: 430px;
  overflow: auto;
}

div.chats {
  background-color: #f4fbff;
  border:1px solid #e1eef5;
  height: 200px;
  overflow: auto;
  border-radius: 5px;
  padding:20px;
}
.notattempted{
  background: #ec6868;
  color:white;
}
.nattempted{
  background: #4caf50;
  color:white;
}
 </style>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Window Swap Detected</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body swap-message">
        We have noticed a window swap. Kindly note that 3 swaps will lead to cancellation of the test.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-commenting-o"></i> Message Proctor</h3>
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
        <button type="button" class="btn btn-primary s_chat" data-user="{{$user->name}}" data-testid="{{$exam->id}}" data-username="{{$user->username}}">Send message</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="instructions" tabindex="-1" role="dialog" aria-labelledby="instructions" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-info-circle"></i> Instructions</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        {!! $exam->instructions !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="questions" tabindex="-1" role="dialog" aria-labelledby="questions" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-info" id="exampleModalLongTitle"><i class="fa fa-question-circle"></i> Question List</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body attempted2">
         <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col" width="10%" style="text-align: center;">Qno</th>
              <th scope="col">Questions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($questions as $i=> $question)
             <tr>
                <th scope="row">
                  <div class="w100 p-1 test2qno s{{ ($i+1 ) }} cursor text-center rounded qborder  @if($question->response) qblue-border text-white @endif @if(count($question->images)) qblue-border text-white @endif active " id="q{{ ($question->id )}}" data-qno="{{$question->id}}"  data-sno="{{ ($i+1) }}" 
                >{{ ($i+1 ) }}</div>
                </th>
                <td>
                  <div class="">
                    @if(isset($question->passage))
                    @if($question->passage)
                    <div class="p-4 mb-3" style="background-color: #ddffef;border: 1px solid #caefdd;border-radius: 5px;">
                      {!!$question->passage!!}
                    </div>
                    @endif
                    @endif
                    <p>
                    {!! $question->question !!}
                    </p>
                    @if(isset($question->a))
                    @if($question->a)
                    @if(!is_object($question->d))
                    <div class="row">
                      <div class="col-1">(A)</div>
                      <div class="col-5">{{$question->a}}</div>
                      <div class="col-1">(B)</div>
                      <div class="col-5">{{$question->b}}</div>
                      <div class="col-1">(C)</div>
                      <div class="col-5">{{$question->c}}</div>
                      <div class="col-1">(D)</div>
                      <div class="col-5">{{$question->d}}</div>
                    </div>
                    @endif
                    @endif
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="student_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary" id="exampleModalLongTitle"><i class="fa fa-user"></i> Student Info</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <div class="row">
    <div class="col-6">
      <h4>{{ auth::user()->name}}</h4>
      <p class="mb-0">
        {{ auth::user()->roll_number}}<br>
          {{ auth::user()->email}}<br>
        @if(isset($data['branches'][auth::user()->branch_id])) {{ $data['branches'][auth::user()->branch_id]->name}} <br>@endif
        <span class="badge badge-warning connection_status" data-status=1></span>
      </p>

    </div>
    <div class="col-6">
      @if($user->getImage())
        <img 
      src="{{ $user->getImage() }}  " class="rounded d-inline float-right" alt="{{  $exam->name }}" style='max-width:60px;' data-toggle="tooltip"  title="Profile Picture">
      @endif
      @if(isset($exam->settings))
      @if(isset($exam->settings->signature))
          @if(strtolower($exam->settings->signature)=='yes')
      <img 
      src="{{ $user->getImage('signature') }}  " class="rounded d-inline" alt="{{  $exam->name }}" style='max-width:60px;' data-toggle="tooltip"  title="Signature" >
      @endif @endif @endif
    </div>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




@if(isset($settings['section_timer']))
      @if($settings['section_timer']!='unlimited')
<div class="modal fade" id="timer_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary" id="exampleModalLongTitle"><i class="fa fa-clock-o"></i> Timer Alert</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        Last few minutes are left. Kindly review your answers before submitting.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif
@endif

<div class="modal fade" id="camera_test" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Unable to Access Webcam</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        If the webcam is not enabled or if the candiate is not visible in the continuous monitoring, then the test will be invalid.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('appl.exam.assessment.blocks.code_instructions')



@if(isset($exam->calculator))
  @if($exam->calculator)
    @include('appl.exam.assessment.blocks.calculator')
  @endif
@endif
</form>
</div>

<div class="pre-singedurl-set">
  @if($urls)
  @foreach($urls as $k=> $url)
    
    @if($k=='testlog_log')
    <div class="url_{{$k}} d-none " data-url="{{$url}}" data-json="@if($json_log){{$json_log}}@endif"></div>
    @elseif($k=='testlog_b1')
    <div class="url_{{$k}} d-none " data-url="{{$url}}" data-json="@if($json_b1){{$json_b1}}@endif"></div>
    @else
    <div class="url_{{$k}} d-none " data-url="{{$url}}" ></div>

    @endif
  @endforeach
  @endif
  
  @if($urls2)
  @foreach($urls2 as $k=> $url2)
    <div class="url2_{{$k}} d-none " data-url="{{$url2}}" ></div>
  @endforeach
  @endif

   @if($urls3)
  @foreach($urls3 as $k=> $url3)
    <div class="url_{{$k}} d-none " data-url="{{$url3}}" ></div>
  @endforeach
  @endif
</div>

<div class="container fullscreen_container">
  <div class='border rounded p-4 mt-5'>
    <h3 class="mb-3 full_screen_message"><i class=" fa fa-check"></i> System Check </h3>
    <div id="check" class="check_status">
    @include('appl.exam.assessment.blocks.check')
    
    <p><div class="spinner-border spinner-border-sm cam_spinner " role="status">
  <span class="sr-only">Loading...</span>
</div> @if($exam->camera) <span class="cam_message">checking for webcam access ...</span> <span class="cam_message2 mt-1"></span> @endif</p>



@if(isset($settings['start_time']))
<p class="my-2"><div class="alert alert-important alert-warning">
  Exam <span class="started">starts in</span> <b><span id="d" class="d"></span></b>
</div></p>
@endif
</div>

    <div class="btn btn-primary disabled  fullscreen start_btn">Start Test</div>
    <div class="btn btn-primary    d-none">back to fullscreen</div>
  </div>

</div>

</div>


<div class="modal fade" id="vsc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary" id="exampleModalLongTitle"><i class="fa fa-check"></i> 360<sup>o</sup> Screening</h3>
      
      </div>
      <div class="modal-body ">
        <p class="alert alert-info alert-important"><span class="">For the next 20 seconds you are required to turn your device in all directions to show the room, desk space and walls. This screening is validated by administrators for any potential cheating. </span></p>
       <div id="">

    <video id="gum_1000" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    <video id="recorded" playsinline loop></video>
    <div class="recording text-danger " style="display: none">
      <span class="blink"><i class="fa fa-circle"></i></span> Recording</div>
    <div>
        <button id="start" type="button" class='d-none'>Start camera</button>
        <button id="record" type="button" class="btn btn-outline-danger d-none" disabled>Start Recording</button>
        <button id="play"  type="button" class='d-none' disabled>Play</button>
        <button id="download" type="button" class='d-none' disabled>Download</button>
    </div>


</div>
      </div>
      
    </div>
  </div>
</div>

<div class="d-none">
    <video id="gum_2000" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    <video id="gum_2001" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    <video id="gum_2002" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    <video id="gum_2003" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    <video id="gum_2004" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    @for($hk=3000;$hk<3010;$hk++)
    <video id="gum_{{$hk}}" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;display: none"></video>
    @endfor
</div>

<div class="modal fade" id="no_connectivity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Not connected to internet</h3>
      
      </div>
      <div class="modal-body ">
        <p><span class="badge badge-warning "><i class="fa fa-circle text-secondary"></i> Offline</span></p>
       The test will auto resume as the device gets connected to the internet. For persistent disconnectivity, kindly reach out to the test administrator.
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="terminated" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa fa-times-circle"></i> Exam Terminated</h3>
      
      </div>
      <div class="modal-body ">
       Due to the misconduct during the exam, the proctor has terminated your test. The responses saved till this point will be auto submitted.
      </div>
      
    </div>
  </div>
</div>

@endsection