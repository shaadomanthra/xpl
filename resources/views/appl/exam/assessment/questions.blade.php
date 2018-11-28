@extends('layouts.app')
@section('content')

<form method="post" action="" >
  <div class="row">

    <div class="col-md-9">

      <div class=" mb-3 d-block d-md-none ">
  <div class="">
    <div class="mb-2 text-center"> Timer : <span class="text-bold " id="timer2"></span></div>
    

    <div class="border bg-light p-2 mb-2 rounded">
    <div class="row ">
      <div class="col-3">
        
        <div class="left testqno w100 p-1 text-center pl-2 @if(!$details['prev']) d-none @endif" data-qno="{{$details['prev']}}" data-testname="{{$exam->slug}}"><i class="fa fa-angle-double-left" ></i></div>
        
      </div>
      <div class="col-6"> <div class="mt-1 text-center">Q(<span class="qset_qno">1</span>/{{ count($questions) }})</div></div>
      <div class="col-3"> 
        
        <div class="right testqno w100 p-1 text-center mr-3 @if(!$details['next']) d-none @endif" data-qno="{{$details['next']}}" data-testname="{{$exam->slug}}"><i class="fa fa-angle-double-right" ></i></div>
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
        			<div class="text-center p-1 rounded  w100 qno @if(!$details['response']) qyellow @else  qblue @endif "  style="" data-qqno="{{$question->id}}">
        				{{ $details['qno'] }}
        			</div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 question">{!! $question->question!!}</div>

          

        </div>
        </div>

        @if($question->a)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 border" >
                
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="A" @if($details['response']=='A') checked @endif > A </div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 a">{!! $question->a!!}</div></div>
        </div>
        @endif

        @if($question->b)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 border" >
                
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="B" @if($details['response']=='B') checked @endif>  B</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 b">{!! $question->b!!}</div></div>
        </div>
        @endif

        @if($question->c)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 border" >
                
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="C" @if($details['response']=='C')  checked @endif> C</div>
        		</div>
        	</div>
        	<div class="col-9 col-md-10"><div class="pt-1 c">{!! $question->c!!}</div></div>
        </div>
        @endif
        
        @if($question->d)
         <div class="row no-gutters">
        	<div class="col-3 col-md-2">
        		<div class="pr-3" >
        			<div class="text-center p-1 rounded bg-light w100 border" >
                
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="D" @if($details['response']=='D') checked @endif>
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
        	<div class="text-center p-1 rounded bg-light w100 border" > 
                
                <input class="form-check-input" type="radio" name="response" id="exampleRadios1" value="E" @if($details['response']=='E') checked @endif
                >
                E
              </div>
        		</div>
        	</div>
        	<div class="col-10 col-md-10"><div class="pt-1 e">{!! $question->e!!}</div></div>
        </div>
        @endif
         
        </div>
      </div>
  
  	<div class="card mb-3">
         <div class="card-body">
         	<button type="button" class="btn  btn-outline-primary testqno @if(!$details['prev']) d-none @endif" data-qno="{{$details['prev']}}" data-testname="{{$exam->slug}}">
	          <i class="fa fa-angle-double-left"></i> Previous
	      </button>
	        <button type="button" class="btn  btn-info qno-save mb-2" data-qno="{{$details['curr']}}">
	          Save Response
	      </button>
	      <button type="button" class="btn  btn-secondary qno-clear mb-2" data-qno="{{$details['curr']}}">
	          Clear Response
	      </button>
	      <a href="#" data-toggle="modal" data-target="#exampleModal">
	      <button type="button" class="btn  btn-success qno-submit mb-2" data-qno="{{$details['curr']}}" data-tooltip="tooltip" data-placement="top" title="Submit">
	          Submit Test
	      </button></a>
	      <button type="button" class="btn  btn-outline-primary mb-2 testqno @if(!$details['next']) d-none @endif" data-qno="{{$details['next']}}" data-testname="{{$exam->slug}}" >
	           Next <i class="fa fa-angle-double-right"></i>
	      </button>
    	</div>
    </div>

     </div>
     
    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.exam.assessment.qno')
    </div>

  </div> 


</form>
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Confirm Submission</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Kindly confirm your submission of the test.
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <a href="{{ route('assessment.submit',$exam->slug)}}" >
	      <button type="button" class="btn  btn-success " >
	          Submit Test
	      </button></a>
      </div>
    </div>
  </div>
</div>


@endsection