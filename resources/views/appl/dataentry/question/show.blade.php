@extends('layouts.app')
@section('title', 'Questions ')
@section('content')

@include('appl.dataentry.snippets.breadcrumbs')
@include('flash::message')


  <div class="row">

    <div class="col-md-9">

      <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="question-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="true">Question</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="a" aria-selected="false">Category</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab" aria-controls="a" aria-selected="false">InTest</a>
      </li>
      </ul>

      <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
        <br>


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
</div>



  



                  
              @else
              <div class="solution">@if($question->explanation) {!! $question->explanation !!} @else - @endif</div>
            @endif
        </div>
      </div>
      @endif

        
      </div>

      
      <div class="tab-pane fade " id="category" role="tabpanel" aria-labelledby="category-tab">
        @if(isset($list))
        @if(count($list)!=0)
        <div class="card mt-3">
        <div class="card-body details">
          <div class="bg-light p-1 rounded border mb-2">Category</div>
          
          <div class="row">
            <div class="col-12 mb-1">
              @foreach($list as $k=>$cat)
               <div class="form-check">
                  <input type="checkbox" class="form-check-input n" name="category" data-id="{{$cat->id}}" data-url="{{ url('/') }}" data-ques={{ $question->id }} @if($cat->questions->contains($question->id)) checked @endif>
                  <label class="form-check-label" for="exampleCheck1">{{$cat->name}}</label>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
        @endif
        @endif
      </div>

      <div class="tab-pane fade  " id="test" role="tabpanel" aria-labelledby="test-tab">
        <div class="border p-3 mt-3">
          <input  class="intest" type="checkbox" name="intest" value="{{$question->id}}"  data-ques="{{$question->id}}" data-url="{{ URL::to('/') }}"
              
                @if($question->intest)
                  checked
                @endif
              
            >
            make it a test question 
          </div>
      </div>

      </div>
      

      

    </div>

     <div class="col-md-3 pl-md-0">
      @include('appl.dataentry.snippets.qset')
      @include('appl.dataentry.snippets.qdetails')
    </div>

  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        
        This following action will delete the node and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('question.destroy',['project'=>$project->slug,'question'=>$question->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-warning">Warning !</span></h3>
        This following action will publish the question to LIVE status which disables the editing option.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <a href="{{ $details['curr'].'?publish=true'}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Publish</button>
        </a>
      </div>
    </div>
  </div>
</div>

  <!-- Modal 3-->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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