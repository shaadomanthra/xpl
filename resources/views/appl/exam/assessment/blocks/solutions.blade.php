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
     
        <div class="" >
          @if(isset($images[$question->id]))
          @foreach(array_reverse($images[$question->id]) as $k=>$url)
          <div class="border border-secondary">
              <a href="#" id="{{$k}}" class="@if(auth::user()->checkRole(['hr-manager','administrator'])) correct_image @endif" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}"><img src="{{$url }}"  class=" p-1  my-1 w-100" data-name="{{$k}}"/>
              </a>
              @if(auth::user()->checkRole(['hr-manager','administrator']))
              @if(auth::user()->checkExamRole($exam,['evaluator','owner']))
              <a href="{{ route('assessment.solutions.q',[$exam->slug,$question->id])}}?rotate=90&name={{$k}}&imgurl={{$url}}&qid={{$question->id}}&student={{$student->username}}" class="btn btn-outline-primary my-2 mr-1 ml-1">left <i class="fa fa-rotate-left"></i></a>
              <a href="{{ route('assessment.solutions.q',[$exam->slug,$question->id])}}?rotate=-90&name={{$k}}&imgurl={{$url}}&qid={{$question->id}}&student={{$student->username}}" class="btn btn-outline-primary my-2 mr-1 ml-1">right <i class="fa fa-rotate-right"></i></a>
              <a href="#" class="btn btn-outline-success my-2 correct_image float-right mr-1" data-url="{{$url}}?time={{strtotime('now')}}" data-name="{{$k}}" data-imgurl="{{$url}}" data-dimensions="{{$exam->getDimensions($url)}}"> <i class="fa fa-pencil"></i> pen</a>
              @endif
              @endif
          </div>
          @endforeach
          @endif
        </div>

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
                Testcases
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 a">
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
      <tr>
        <td>#2</td>
        @if(json_decode($question->a)->in_2)
        <td>{{ json_decode($question->a)->in_2 }}</td>
        <td>{{ json_decode($question->a)->out_2 }}</td>
        @else
        <td>{{ json_decode($question->a)->in_1 }}</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        @endif
      </tr>
      <tr>
        <td>#3</td>
        @if(json_decode($question->a)->in_3)
        <td>{{ json_decode($question->a)->in_3 }}</td>
        <td>{{ json_decode($question->a)->out_3 }}</td>
        @else
        <td>{{ json_decode($question->a)->in_1 }}</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        @endif
      </tr>
       <tr>
        <td>#4</td>
        @if(json_decode($question->a)->in_4)
        <td>{{ json_decode($question->a)->in_4 }}</td>
        <td>{{ json_decode($question->a)->out_4 }}</td>
        @else
        <td>{{ json_decode($question->a)->in_1 }}</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        @endif
      </tr>
       <tr>
        <td>#5</td>
        @if(json_decode($question->a)->in_5)
        <td>{{ json_decode($question->a)->in_5 }}</td>
        <td>{{ json_decode($question->a)->out_5 }}</td>
        @else
        <td>{{ json_decode($question->a)->in_1 }}</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        @endif
      </tr>
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
                Your Code
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10"><div class="pt-1 code"><pre class='p-3'><code class="text-light">{!! htmlentities($details['code'])!!}
          </code></pre></div></div>
        </div>
        @endif

        @if($details['coder'])
         <div class="row no-gutters">
          <div class="col-2 col-md-2">
            <div class="pr-3 mb-2 " >
          <div class="text-center p-1 rounded bg-light w100 border" > 
                Compilation
              </div>
            </div>
          </div>
          <div class="col-10 col-md-10">
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
      @if(isset($details['coder']['response_1']))
      <tr>
        <td>#1</td>
        <td>@if($details['coder']['pass_1']) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger"></i> Fail @endif</td>
        <td>{{ json_decode($question->a)->out_1 }}</td>
        <td>@if($details['coder']['response_1']['stderr']) {{ $details['coder']['response_1']['stderr']}} @else
          {!! nl2br($details['coder']['response_1']['stdout']) !!}
        @endif</td>
        <td>{{ $details['coder']['response_1']['time']}}</td>
      </tr>
      @endif

      @for($j=2;$j<6;$j++)
      @if(isset($details['coder']['response_'.$j]))
      <tr>
        <td class="i {{ $out ='out_'.$j}} a_{{json_decode($question->a)->$out}}">#{{$j}}</td>
        <td>@if($details['coder']['pass_'.$j]) <i class="fa fa-check-circle text-success"></i> success @else <i class="fa fa-times-circle text-danger "></i> Fail @endif</td>
        <td>@if(trim(json_decode($question->a)->$out)) {{ json_decode($question->a)->$out }} @else  {{ json_decode($question->a)->out_1 }}@endif</td>
        <td>@if($details['coder']['response_'.$j]['stderr']) {{ $details['coder']['response_'.$j]['stderr']}} @else
          {!! nl2br($details['coder']['response_'.$j]['stdout']) !!}
        @endif</td>
        <td>{{ $details['coder']['response_'.$j]['time']}}</td>
      </tr>
      @endif
      @endfor
      
    </tbody>
  </table>
          </div>
        </div>
        @endif

      @endif

         
        </div>
      </div>
  
  	@if($question->type!='code')
      

      @if($question->type=='sq' || $question->type=='urq')
      <div class="card bg-light mb-3 ">
        <div class="card-body">
          <div class="row">
            <div class="col-6 col-md-4">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0">
                <h3><i class="fa fa-lightbulb-o"></i> Score</h3>
                <div class="answer">@if($details['status']!=2){{ $details['mark'] }} @else - @endif</div>
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
      @elseif($question->answer )
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

      @else

      <div class="card bg-light mb-3 ">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <div class="bg-light p-3 border rounded mb-3 mb-md-0">
                <h3><i class="fa fa-lightbulb-o"></i> Expected Output</h3>
                <div class="answer">@if($question->answer){!! $question->answer !!} @else - @endif</div>
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

     


      @if($question->type=='code')
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
                      <a class="nav-link" id="nolang-tab" data-toggle="tab" href="#nolang" role="tab" aria-controls="nolang" aria-selected="false">Nolang</a>
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
         <div class="tab-pane fade" id="nolang" role="tabpanel" aria-labelledby="nolang-tab">
          @if(isset($codes->codefragment_8))
         <pre class="p-3"><code class="text-light ">{!! htmlentities($codes->codefragment_8) !!}</code></pre>
          <div class="card"><div class="card-body">{!! htmlentities($codes->output_8) !!}</div></div>
          @endif
        </div>
        </div>                  
              @else
              <div class="solution">@if($question->explanation) {!! $question->explanation !!} @else - @endif</div>
            @endif
        </div>
      </div>
      @endif
     

      @if($question->type!='code')
      @if($question->explanation )
      <div class="card mb-3 mb-md-0">
        <div class="card-body">
          <h3>Explanation</h3>
          <div class="explanation">{!! $question->explanation !!}</div>
        </div>
      </div>
      @endif
      @endif

     </div>
     
    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.exam.assessment.q2')
    </div>

  </div> 


</form>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Correct Paper</h1>
        <span @if(!auth::user()->checkExamRole($exam,['evaluator','owner'])) style="display:none" @endif>
        <button type="button" class="btn btn-danger clear_image float-right d-inline">clear</button>
        <button type="button" class="btn btn-primary save_image float-right d-inline" data-url="{{ route('assessment.solutions.q.post',[$exam->slug,$question->id])}}?student={{request()->get('student')}}" data-name="" data-imgurl="" data-student="{{request()->get('student')}}" data-token="{{ csrf_token() }}" data-user_id="{{ $student->id }}" data-slug="{{$exam->slug}}"  data-qid="{{$question->id}}" data-width="1100" data-height="">
          Save
        </button>
      </span>

      </div>
      <div class="modal-body">
        <div class="canvas">
        
      </div>
        <img id="image_display" style="display: none">
      </div>
    </div>
  </div>
</div>