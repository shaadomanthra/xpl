@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assessment.index') }}">Online Tests</a></li>
    <li class="breadcrumb-item">{{ ucfirst($exam->name) }} </li>
    <li class="breadcrumb-item">Solutions </li>
  </ol>
</nav>
<form method="post" action="" >
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
      <div class="card mb-3">
        <div class="card-body">
          <b>Passage</b> <span class="btn view badge badge-warning" data-item="passage">view</span><br>
          <div class="passage" style="display: none;">
          {!! $passage->passage !!}
          </div>
        </div>
      </div>
      @endif
      <div class="card  mb-3">
        <div class="card-body ">
          
        <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3 " >
        			<div class="text-center p-1 rounded  w100 qno @if(!$details['response']) qyellow @else @if($details['accuracy']==1) qgreen @else qred @endif @endif "  style="" data-qqno="{{$question->id}}">
        				{{ $details['qno'] }}
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div>

          @if(count($question->tags)!=0)
      @foreach($question->tags as $k => $tag)
      @if(!in_array($exam->slug,$tests))
      <span class="badge @if($k==0) badge-danger @else  badge-warning @endif mb-3">{{ strtoupper($exam->slug) }}</span>
      @endif
      @endforeach
    @endif

        </div>
        </div>

        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
              
        			<div class="text-center p-1 rounded bg-light w100  @if($details['response']=='A') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='A') qgreen-border @else border @endif @endif" >
                 A </div>
                 
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 a">{!! $question->a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100  @if($details['response']=='B') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='B') qgreen-border @else border @endif @endif" >
                
                 B</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='C') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='C') qgreen-border @else border @endif @endif" >
                C</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">{!! $question->c!!}</div></div>
        </div>
        @endif
        
        @if($question->d)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='D') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='D') qgreen-border @else border @endif @endif" >
                
                D</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 d">{!! $question->d!!}</div></div>
        </div>
        @endif

        @if($question->e)
         <div class="row no-gutters">
        	<div class="col-2 col-md-2">
        		<div class="pr-3" >
        	<div class="text-center p-1 rounded bg-light w100 @if($details['response']=='E') @if($details['accuracy']==1) qgreen-border @else qred-border @endif @else @if($question->answer=='E') qgreen-border @else border @endif @endif" > 
                E
              </div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->e!!}</div></div>
        </div>
        @endif
         
        </div>
      </div>
  
  	
    @if($question->answer )
      <div class="card mb-3 bg-light">
        <div class="card-body">
          <h3>Answer</h3>
          <div class="answer">{!! $question->answer !!}</div>
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