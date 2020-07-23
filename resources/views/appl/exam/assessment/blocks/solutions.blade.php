<form method="post" action="" >

 <div class="p-3 border rounded bg-light mb-3">
    <div class="  display-4  mb-3 d-none d-md-block"><b>{{ ucfirst($exam->name) }} - Solutions</b></div>
    <p class="mb-0">Name : <span class="text-primary">{{$student->name}}</span>
      
    </p>

  </div>
  <div class="">
    <div class="row">
   
    <div class="col-md-9">

      <div class=" mb-3 d-block d-md-none ">
    <div class="">
    <div class="text-bold mb-3 d-none ">Solutions : <a href="{{ route('assessment.analysis',$exam->slug)}}">
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
      <div class="col-6"> <div class="mt-1 text-center">Q({{ $details['qno'] }}/{{ count($questions) }})</div></div>
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

       @if($question->type!='code' && $question->type!='urq' && $question->type!='sq')
        
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

      @elseif($question->type=='urq')
     
        @if(Storage::disk('s3')->exists('urq/'.$exam->slug.'_'.$student->id.'_'.$question->id.'.jpg'))
          <div class="border border-secondary">
          <img src="{{ Storage::disk('s3')->url('urq/'.$exam->slug.'_'.$student->id.'_'.$question->id.'.jpg')}}" class="w-100" />
        </div>

      
        @else
          <div class="alert alert-warning alert-important mb-0" role="alert">
  User has not uploaded the response image.
</div>
        @endif
      @elseif($question->type=='sq')
        <div class="alert alert-warning alert-important mb-0" role="alert">
          <h3>User Response:</h3>
          {{ ($details['response'])?$details['response']:'-' }}
        </div>
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
              <div class="bg-light p-3 border rounded" >

                <h3><i class="fa fa-clock-o"></i> Response Time</h3>
                <div class="p-1">{{ $details['time']}} sec</div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0" >

                <h3><i class="fa fa-flash"></i> Your Response</h3>
                <div class="p-1">{{ ($details['response'])?$details['response']:'-' }}</div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      @endif

      @if($question->type=='sq' || $question->type=='urq')
      <div class="card bg-light mb-3 ">
        <div class="card-body">
          <div class="row">
            <div class="col-6 col-md-4">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0">
                <h3><i class="fa fa-lightbulb-o"></i> Score</h3>
                <div class="answer">{{ ($details['mark'])?$details['mark']:'-' }}</div>
              </div>
            </div>
            <div class="col-6 col-md-4">
              <div class="bg-light p-3 border rounded" >

                <h3><i class="fa fa-clock-o"></i> <span class="d-none">Response</span> Time</h3>
                <div class="p-1">{{ $details['time']}} sec</div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="bg-light p-3 border rounded  mb-md-0">
                <h3><i class="fa fa-comment-o"></i> Feedback</h3>
                <div class="p-1">{{ ($details['comment'])?$details['comment']:'-' }}</div>
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

      @if(auth::user()->checkRole(['hr-manager']))
      <div class="card">
        <div class="card-body">
          <h3>Faculty Input</h3>
          <form id="award_score" action="{{ request()->url()}}" method="post">
  @if($question->type=='sq' || $question->type=='urq')
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Score</label>
    <div class="col-sm-10">
      @foreach(range(0.5,$details['section']->mark,0.5) as $r)
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="score" id="inlineRadio1" value="{{$r}}" @if($details['mark']==$r)checked @endif>
        <label class="form-check-label" for="inlineRadio1">{{$r}}</label>
      </div>
      @endforeach
    </div>
  </div>
  @endif
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Feedback</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="4">@if(@details['comment']){{$details['comment']}}@endif</textarea>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="student" value="{{ request()->get('student') }}">
      <input type="hidden" name="slug" value="{{ $exam->slug }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</form>
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