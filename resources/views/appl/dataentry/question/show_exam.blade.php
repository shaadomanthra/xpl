@extends('layouts.app')
@section('title', 'Test '.$exam->name.' | Xplore')
@section('content')

<div class="">
<div class="d-none d-md-block">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.index')}}">Exam</a></li>
      <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug)}}">{{ $exam->name }}</a></li>
      <li class="breadcrumb-item"> Questions</li>
      <li class="breadcrumb-item">Q{{ $details['qno'] }}</li>
    </ol>
  </nav>
</div>
<div class="d-block d-md-none mb-3">
  <div class="bg-light border rounded p-2 pl-3">
    <a href="{{ route('exam.show',$exam->slug)}}"><i class="fa fa-angle-double-left"></i> {{ $exam->name }}</a>
  </div>
</div>

<div class="d-block d-md-none mb-3">
  <div class="bg-light border rounded p-3">
    <div class="row ">
      <div class="col-3">
        @if($details['prev'])
        <a href="{{ $details['prev'] }}">
        <div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
        </a>
        @endif
      </div>
      <div class="col-6"> <div class="mt-1 text-center">Q({{$details['qno']}}/{{ count($questions) }})</div></div>
      <div class="col-3"> 
        @if($details['next'])
        <a href="{{ $details['next'] }}">
        <div class=" w100 p-1 text-center mr-3"><i class="fa fa-angle-double-right"></i></div>
        </a>
        @endif
      </div>
    </div>
  </div>
</div>
@include('flash::message')

  <div class="row">

    <div class="col-md-8 col-lg-8">

<div class="row no-gutters">
        @if(trim($question->passage))
  <div class="col-12 col-md-12 col-lg-7 pbox" >
  <div class="card my-0" style="background: #ddffef;border: 1px solid #caefdd;border-radius: 5px;max-height:300px; overflow: scroll;">
    <div class="card-body">
      <b>Passage</b> 
      <div class="passage pt-2 fsmall" style="">
        {!! $question->passage !!}
      </div>
    </div>
  </div>
  </div>
  @endif

    <div class="col12 col-md col-lg">
      <div class="card  mb-3">
        <div class="card-header ">
          @can('update',$question)
                <a href="{{ route('question.edit',['project'=>$question->project->slug,'question'=>$question->id,'url'=> url()->current()]) }}&exam={{$exam->id}}&default=1"><i class="fa fa-edit"></i> edit</a> &nbsp;&nbsp;&nbsp;
          @endcan

          @can('update',$question)
            <a href="#"  data-toggle="modal" data-target="#exampleModal3">
         <i class="fa fa-unlink"></i> remove</a>
                
          <a href="#"  data-toggle="modal" data-target="#exampleModal4">
         <i class="fa fa-retweet ml-2"></i> copy</a>
          @endcan
          @if($question->level)<span class="badge badge-info float-right mt-1  ml-2">Level {{$question->level}}</span>@endif
          <span class="badge badge-success float-right mt-1  ml-2">{{$question->mark}}M</span>
          <span class="badge   badge-warning float-right mt-1 ml-2">{{ strtoupper($question->type) }}</span>
          <span class="badge badge-primary float-right mt-1 ">{{$question->topic}}</span>
        </div>
        <div class="card-body ">

@if($question->type=='pdf')
      <style>
      .pdfobject-container { height: 30rem; border: 1px solid rgba(0,0,0,.2); }
      .toolbar {
        display: none !important;
      }
      .end
      {
          display:none !important;    
      }

      .print
      {
          display:none !important;
      }
      </style>
          <div class="pdfobject-container">
      <div id="resume"></div>
      </div>


      <script src="{{ asset('js/pdf.js')}}"></script>
      <script>PDFObject.embed("{{ Storage::disk('s3')->url('pdf_ques/'.$question->slug.'.pdf')}}?time={{microtime()}}", "#resume");</script>

@else 
        <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2 " >
        			<div class="text-center p-1 rounded  w100 qyellow"  style="">
        				{{ $details['qno'] }} 
                
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="qu_1" data-toggle="tab" href="#q_1" role="tab" aria-controls="question" aria-selected="true">Question</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="qu_2" data-toggle="tab" href="#q_2" role="tab" aria-controls="exams" aria-selected="false">Version 2</a>
        
      </li>
      <li class="nav-item">
        <a class="nav-link" id="qu_3" data-toggle="tab" href="#q_3" role="tab" aria-controls="a" aria-selected="false">Version 3</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="qu_4" data-toggle="tab" href="#q_4" role="tab" aria-controls="a" aria-selected="false">Version 4</a>
      </li>
      </ul>

      <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="q_1" role="tabpanel" aria-labelledby="q_1">
        <div class="pt-1 border p-3 mt-2">{!! $question->question!!}</div>
      </div>
      <div class="tab-pane" id="q_2" role="tabpanel" aria-labelledby="q_2">
        <div class="pt-1 mt-2 border p-3">@if($question->question_b) {!! $question->question_b!!} @else - @endif</div>
      </div>

      <div class="tab-pane" id="q_3" role="tabpanel" aria-labelledby="q_3">
        <div class="pt-1 mt-2 border p-3">@if($question->question_c) {!! $question->question_c!!} @else - @endif</div>
      </div>
      <div class="tab-pane" id="q_4" role="tabpanel" aria-labelledby="q_4">
        <div class="pt-1 mt-2 border p-3">@if($question->question_d) {!! $question->question_d!!} @else - @endif</div>
      </div>
      </div>

  
      
      



        </div>
        </div>
@endif


        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 border rounded bg-light w100  " >
                @if($question->type=='code') Testcases @else A @endif</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 a ">
            @if($question->type=='code')
            @if(isset(json_decode($question->a)->in_1))
              <table class="table table-bordered bg-light">
    <thead style="background: #eee">
      <tr>
        <th></th>
        <th>Input</th>
        <th>Output</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#1</td>
        <td>{{ json_decode($question->a)->in_1 }}</td>
        @if($question->b=='sql')
        <td>{!! json_decode($question->a)->out_1 !!}</td>
        @else
        <td>{{ json_decode($question->a)->out_1 }}</td>
        @endif
      </tr>
      @if(isset(json_decode($question->a)->in_2))
      <tr>
        <td>#2</td>
        <td>{{ json_decode($question->a)->in_2 }}</td>
        <td>{{ json_decode($question->a)->out_2 }}</td>
      </tr>
      @endif
      @if(isset(json_decode($question->a)->in_3))
      <tr>
        <td>#3</td>
        <td>{{ json_decode($question->a)->in_3 }}</td>
        <td>{{ json_decode($question->a)->out_3}}</td>
      </tr>
      @endif
      @if(isset(json_decode($question->a)->in_4))
       <tr>
        <td>#4</td>
        <td>{{ json_decode($question->a)->in_4 }}</td>
        <td>{{ json_decode($question->a)->out_4}}</td>
      </tr>
      @endif
      @if(isset(json_decode($question->a)->in_5))
       <tr>
        <td>#5</td>
        <td>{{ json_decode($question->a)->in_5 }}</td>
        <td>{{ json_decode($question->a)->out_5}}</td>
      </tr>
      @endif
    </tbody>
  </table>
      
              @endif
            @else {!! $question->a!!}
            @endif
          </div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 border rounded bg-light w100 " >
                 @if($question->type=='code') Language @else B @endif</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->b!!}</div></div>
        </div>
        @endif

        

        @if($question->c || $codes)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 border rounded bg-light w100 " >
               @if($question->type=='code') Preset  @else C @endif</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">
           @if($question->c)
            <div>{!! $question->c !!}</div>
           @elseif($question->type=='code')

              @if($codes)
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#c" role="tab" aria-controls="home" aria-selected="true">C</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#cpp" role="tab" aria-controls="profile" aria-selected="false">C++</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#csharp" role="tab" aria-controls="contact" aria-selected="false">C#</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " id="java-tab" data-toggle="tab" href="#java" role="tab" aria-controls="java" aria-selected="false">Java</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="javascript-tab" data-toggle="tab" href="#javascript" role="tab" aria-controls="javascript" aria-selected="false">Javascript</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="python-tab" data-toggle="tab" href="#python" role="tab" aria-controls="python" aria-selected="false">Python</a>
                    </li>
                    
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="c" role="tabpanel" aria-labelledby="home-tab">
                      <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_c) !!}</code></pre>
                    </div>
                    <div class="tab-pane fade" id="cpp" role="tabpanel" aria-labelledby="profile-tab">
                      <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_cpp) !!}</code></pre>
                    </div>
                    <div class="tab-pane fade" id="csharp" role="tabpanel" aria-labelledby="contact-tab">
                      <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_csharp) !!}</code></pre>
                    </div>
                     <div class="tab-pane fade" id="java" role="tabpanel" aria-labelledby="java-tab">
                       <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_java) !!}</code></pre>
                     </div>
                      <div class="tab-pane fade" id="javascript" role="tabpanel" aria-labelledby="javascript-tab">
                        <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_javascript) !!}</code></pre>
                      </div>
                       <div class="tab-pane fade" id="python" role="tabpanel" aria-labelledby="python-tab">
                         <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->preset_python) !!}</code></pre>
                       </div>
                      
                  </div>
              @endif
            @else
            {!! $question->c!!}
            @endif 
          </div></div>
        </div>
        @endif
        @if($question->type!='code')
        @if(trim($question->d))
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 border rounded bg-light w100 " >
                 D</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 d">{!! $question->d!!}</div></div>
        </div>
        @endif
        @endif

        @if($question->e)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 pb-2" >
        	<div class="text-center p-1 border rounded bg-light w100 " > 
                
                E
              </div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->e!!}</div></div>
        </div>
        @endif
         
        </div>
      </div>
</div>
</div>


      @if($question->type!='sq' && $question->type!='urq' && $question->type!='code' )
      <div class="card mb-3 ">
      	<div class="card-body">
      		<h3>@if($question->type=='code') Output @else Answer @endif</h3>
      		<div class="answer">{!! $question->answer !!}</div>
      	</div>
      </div>
      @endif
      
      @if($question->type!='code' )
      <div class="card mb-3 mb-md-0">
      	<div class="card-body">
      		<h3>Explanation</h3>
      		<div class="explanation">@if($question->explanation) {!! $question->explanation !!} @else - @endif</div>
      	</div>
      </div>

      @else
      <div class="card mb-3 mb-md-0">
        <div class="card-body">
          <h3 class="mb-3">Code Solution</h3>
           @if($codes)
               
<ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="chome-tab" data-toggle="tab" href="#cc" role="tab" aria-controls="chome" aria-selected="true">C</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cprofile-tab" data-toggle="tab" href="#ccpp" role="tab" aria-controls="cprofile" aria-selected="false">C++</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="ccontact-tab" data-toggle="tab" href="#ccsharp" role="tab" aria-controls="ccontact" aria-selected="false">C#</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " id="cjava-tab" data-toggle="tab" href="#cjava" role="tab" aria-controls="cjava" aria-selected="false">Java</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cjavascript-tab" data-toggle="tab" href="#cjavascript" role="tab" aria-controls="cjavascript" aria-selected="false">Javascript</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cpython-tab" data-toggle="tab" href="#cpython" role="tab" aria-controls="cpython" aria-selected="false">Python</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="csql-tab" data-toggle="tab" href="#csql" role="tab" aria-controls="csql" aria-selected="false">SQL</a>
                    </li>
                  </ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="cc" role="tabpanel" aria-labelledby="chome-tab">

     <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_1) !!}</code></pre>
      <div class="card"><div class="card-body"><h5 class="text-secondary">Output</h5><hr>{!! htmlentities($codes->output_1) !!}</div></div>

  </div>
  <div class="tab-pane fade" id="ccpp" role="tabpanel" aria-labelledby="cprofile-tab">

     <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_2) !!}</code></pre>
      <div class="card"><div class="card-body">{!! htmlentities($codes->output_2) !!}</div></div>

  </div>
    <div class="tab-pane fade" id="ccsharp" role="tabpanel" aria-labelledby="ccontact-tab">
       <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_3) !!}</code></pre>
        <div class="card"><div class="card-body">{!! htmlentities($codes->output_3) !!}</div></div>
      </div>
      <div class="tab-pane fade" id="cjava" role="tabpanel" aria-labelledby="cjava-tab">
        <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_4) !!}</code></pre>
          <div class="card"><div class="card-body">{!! htmlentities($codes->output_4) !!}</div></div>
       </div>
       <div class="tab-pane fade" id="cjavascript" role="tabpanel" aria-labelledby="cjavascript-tab">
         <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_5) !!}</code></pre>
          <div class="card"><div class="card-body">{!! htmlentities($codes->output_5) !!}</div></div>
        </div>
        <div class="tab-pane fade" id="cpython" role="tabpanel" aria-labelledby="cpython-tab">
         <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_6) !!}</code></pre>
          <div class="card"><div class="card-body">{!! htmlentities($codes->output_6) !!}</div></div>
        </div>
        @if(isset($codes->codefragment_7))
         <div class="tab-pane fade" id="csql" role="tabpanel" aria-labelledby="csql-tab">
         <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_7) !!}</code></pre>
          <div class="card"><div class="card-body">{!! $codes->output_7 !!}</div></div>
        </div>
        @endif
</div>



  



                  
              @else
              <div class="solution">@if($question->explanation) {!! $question->explanation !!} @else - @endif</div>
            @endif
        </div>
      </div>
      @endif

     

    </div>

     <div class="col-md-4 col-lg-4 pl-md-0">
      @include('appl.dataentry.snippets.qset-exam')
    </div>

  </div> 

</div>

  <!-- Modal 3-->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This action will remove the question from this test. It will be available in the database. To permanently delete question, use edit button.  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <a href="{{ route('exam.question',[$exam->slug,$question->id]) }}?remove=1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Remove </button>
        </a>
      </div>
    </div>
  </div>
</div>

  <!-- Modal 3-->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 >Exam Name : {{ request()->session()->get('session_exam_name') }}</h3>
        <p> Section Name : {{ request()->session()->get('session_section_name') }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <a href="{{ route('question.copy',$question->id)}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Add </button>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection