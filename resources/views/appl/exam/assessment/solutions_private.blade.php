@extends('layouts.app-border')
@section('title', 'Solutions - '.$exam->name.' - '.\auth::user()->name.' | Xplore')
@section('content')


<form method="post" action="" >
  <div class="">
    <div class="p-3 border rounded bg-light mb-4">
    <div class="  display-4  mb-3"><b>{{ ucfirst($exam->name) }} - Solutions</b></div>
    <p>Name : <span class="text-primary">{{$student->name}}</span><br>
      College : <span class="text-primary">{{$student->colleges()->first()->name}}</span><br>
      Branch : <span class="text-primary">{{$student->branches()->first()->name}}</span><br>
    </p>
  </div>
  <div class="row">


    <div class="col-md-9">

      <div class=" mb-3 d-block d-md-none ">
    <div class="bg-light p-2 pr-3 pl-3 rounded border">
    <div class="text-bold mb-3">Solutions : <a href="{{ route('assessment.analysis',$exam->slug)}}">
    {{ ucfirst($exam->name)  }} - Analysis
    </a></div>

    <div class="border p-2 mb-2 rounded">
    <div class="row ">
      <div class="col-3">
        @if($details['prev'])
        <a href="{{ $details['prev'] }}">
        <div class=" w100 p-1 text-center pl-2"><i class="fa fa-angle-double-left"></i></div>
        </a>
        @endif
      </div>
      <div class="col-6"> <div class="mt-1 text-center">Q({{ count($questions) }})</div></div>
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
</div>

    <div class="question_block">

      @if($passage)
      <div class="card mb-3" style="background: #ddffef;border: 1px solid #caefdd;border-radius: 5px;">
        <div class="card-body">
          <b>Passage</b> <span class="btn view badge badge-warning" data-item="passage">view</span><br>
          <div class="passage pt-2" style="display: none;">
          {!! $passage->passage !!}
          </div>
        </div>
      </div>
      @endif
      <div class="card  mb-3">
        <div class="card-body ">
          
        <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 mb-2" >
        			<div class="text-center p-1 rounded  w100 qno @if(!$details['response']) qyellow @else @if($details['accuracy']==1) qgreen @else qred @endif @endif "  style="" data-qqno="{{$question->id}}">
        				{{ $details['qno'] }}
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div>

     

        </div>
        </div>

       @if($question->type!='code')
        
        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 mb-2" >
              
        			<div class="text-center p-1 rounded bg-light w100  @if($details['response']=='A') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='A') qgreen-border @else border @endif @endif" >
                 A </div>
                 
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 a">{!! $question->option_a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 mb-2" >
        			<div class="text-center p-1 rounded bg-light w100  @if($details['response']=='B') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='B') qgreen-border @else border @endif @endif" >
                
                 B</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->option_b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 mb-2" >
        			<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='C') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='C') qgreen-border @else border @endif @endif" >
                C</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">{!! $question->option_c!!}</div></div>
        </div>
        @endif
        
        @if($question->d)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3 mb-2" >
        			<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='D') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='D') qgreen-border @else border @endif @endif" >
                
                D</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 d">{!! $question->option_d!!}</div></div>
        </div>
        @endif

        @if($question->e)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 mb-2" >
        	<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='E') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='E') qgreen-border @else border @endif @endif" > 
                E
              </div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->option_e!!}</div></div>
        </div>
        @endif
      @else
        @if($question->a)
         <div class="row no-gutters">
          <div class="col-2 col-md-2">
            <div class="pr-3 mb-2 " >
          <div class="text-center p-1 rounded bg-light w100 border" > 
                Input
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 a">
            {!! $question->a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
          <div class="col-2 col-md-2">
            <div class="pr-3 mb-2 " >
          <div class="text-center p-1 rounded bg-light w100 border" > 
                Language
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 b">
            {!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
          <div class="col-2 col-md-2">
            <div class="pr-3 mb-2 " >
          <div class="text-center p-1 rounded bg-light w100 border" > 
                Preset Code
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 c">
            <pre class='p-3'><code class="text-light">{!! htmlentities($question->c)!!}
          </code></pre>
          </div></div>
        </div>
        @endif

        @if($details['code'])
         <div class="row no-gutters">
          <div class="col-2 col-md-2">
            <div class="pr-3 mb-2 " >
          <div class="text-center p-1 rounded bg-light w100 border" > 
                User Code
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 code"><pre class='p-3'><code class="text-light">{!! htmlentities($details['code'])!!}
          </code></pre></div></div>
        </div>
        @endif

      @endif

         
        </div>
      </div>
  
  	@if($question->type!='code')
      @if($question->answer )
      <div class="card bg-light mb-3 ">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0">
                <h3><i class="fa fa-lightbulb-o"></i> Correct  Answer</h3>
                <div class="answer">{!! $question->answer !!}</div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0" >

                <h3><i class="fa fa-flash"></i> Your Response</h3>
                <div class="p-1">{{ ($details['response'])?$details['response']:'-' }}</div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="bg-light p-3 border rounded" >

                <h3><i class="fa fa-clock-o"></i> Response Time</h3>
                <div class="p-1">{{ $details['time']}} sec</div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      @endif

      @else

      <div class="card bg-light mb-3 ">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0">
                <h3><i class="fa fa-lightbulb-o"></i> Expected Output</h3>
                <div class="answer">{!! $question->answer !!}</div>
              </div>
            </div>
            
            <div class="col-12 col-md-6 mb-3">
              <div class="bg-light p-3 border rounded" >

                <h3><i class="fa fa-clock-o"></i> Response Time</h3>
                <div class="p-1">{{ $details['time']}} sec</div>
              </div>
            </div>

            <div class="col-12">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0" >

                <h3><i class="fa fa-flash"></i> Complilation Report / Output</h3>
                <div class="p-1">{{ (!$details['response'] && $details['response']!=0)?'-':$details['response'] }}</div>
              </div>
            </div>
          </div>

          
          
        </div>
      </div>

      @endif

      @if($question->explanation )
      <div class="card mb-3 mb-md-0">
        <div class="card-body">
          <h3>Explanation</h3>
          <div class="explanation">{!! $question->explanation !!}</div>
        </div>
      </div>
      @endif

     </div>
     
    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.exam.assessment.q2')
    </div>

  </div> 


</form>



@endsection