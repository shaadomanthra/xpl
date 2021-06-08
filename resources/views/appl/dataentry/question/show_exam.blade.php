@extends('layouts.app')
@section('title', 'Test '.$exam->name.' | Xplore')
@section('content')

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

    <div class="col-md-8">

      @if($passage)
      <div class="card mb-3">
        <div class="card-body">
          <b>Passage</b> <span class="btn view badge badge-warning" data-item="passage">view</span><br>
          <div class="passage" style="display: none;">
          {!! $passage->passage !!}
          </div>
        </div>
      </div>
      @elseif($question->passage)
      <div class="card mb-3">
        <div class="card-body">
          <b>Passage</b> <span class="btn view badge badge-warning" data-item="passage">view</span><br>
          <div class="passage" style="display: none;">
          {!! $question->passage !!}
          </div>
        </div>
      </div>
      @endif
      <div class="card  mb-3">
        <div class="card-header ">
          @can('update',$question)
                <a href="{{ route('question.edit',['project'=>$question->project->slug,'question'=>$question->id,'url'=> url()->current()]) }}&exam={{$exam->id}}&default=1"><i class="fa fa-edit"></i> edit</a> &nbsp;&nbsp;&nbsp;
          @endcan

          @can('update',$question)
            <a href="#"  data-toggle="modal" data-target="#exampleModal3">
         <i class="fa fa-unlink"></i> remove</a>
                
          @endcan
          @if($question->level)<span class="badge badge-info float-right mt-1  ml-2">Level {{$question->level}}</span>@endif
          <span class="badge badge-success float-right mt-1  ml-2">{{$question->mark}}M</span>
          <span class="badge   badge-warning float-right mt-1 ml-2">{{ strtoupper($question->type) }}</span>
          <span class="badge badge-primary float-right mt-1 ">{{$question->topic}}</span>
        </div>
        <div class="card-body ">
          
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
        <td>{{ json_decode($question->a)->out_1 }}</td>
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

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 pb-2" >
        			<div class="text-center p-1 border rounded bg-light w100 " >
               @if($question->type=='code') Preset Code @else C @endif</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">
           @if($question->type=='code')
            <pre class="p-3"><code class="text-light ">{!! htmlentities($question->c) !!}
          </code></pre>
            @else
            {!! $question->c!!}
            @endif 
          </div></div>
        </div>
        @endif
        
        @if($question->d)
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



      @if($question->type!='sq' && $question->type!='urq')
      <div class="card mb-3 ">
      	<div class="card-body">
      		<h3>@if($question->type=='code') Output @else Answer @endif</h3>
      		<div class="answer">{!! $question->answer !!}</div>
      	</div>
      </div>
      @endif
      

      <div class="card mb-3 mb-md-0">
      	<div class="card-body">
      		<h3>Explanation</h3>
      		<div class="explanation">@if($question->explanation) {!! $question->explanation !!} @else - @endif</div>
      	</div>
      </div>

     

    </div>

     <div class="col-md-4 pl-md-0">
      @include('appl.dataentry.snippets.qset-exam')
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

@endsection