@extends('layouts.app')
@section('title', 'Create/Edit Questions ')
@section('content')

<style>
tr{ border:1px solid silver; }
td{ border:1px solid silver; }
th{ border:1px solid silver; }

</style>
@include('flash::message')
  <div class="card">
    <div class="card-body">
      
      
      @if($stub=='Create')
      <form method="post" action="{{route('question.store',$project->slug)}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('question.update',[$project->slug,$question->id])}}" enctype="multipart/form-data" >
      @endif  

      <h1 class="bg-light p-3 mb-3 border rounded">
        @if($stub=='Create')
          Create Question ({{ strtoupper($type) }})
        @else
          Update Question ({{ strtoupper($type) }})
        @endif  

        <button type="submit" class="btn btn-sm btn-outline-success float-right">
          @if($stub=='Create')
            Save
          @else
            Update
          @endif
      </button>

      @if($stub!='Create')
        <a href="#" data-toggle="modal" data-target="#exampleModal" class='btn btn-sm btn-outline-danger float-right mr-3'>
      <i class="fa fa-trash" data-tooltip="tooltip" data-placement="top" title="Delete"></i> Delete
      </a>
      @endif

       </h1>

      <div class="form-group mt-3">
          <label for="formGroupExampleInput ">Reference (optional) </label>
          <input type="text" class="form-control" name="reference" id="formGroupExampleInput" placeholder="Enter the Reference" 
              @if($stub=='Create')
              value="{{ (old('reference')) ? old('reference') : substr(md5(time()),0,6) }}"
              @else
              value = "{{ $question->reference }}"
              @endif
            >
        </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="question-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="true">Ques</a>
      </li>

      @if($type=='mcq' || $type=='maq' || $type=='mbdq')
      <li class="nav-item">
        <a class="nav-link" id="a-tab" data-toggle="tab" href="#a" role="tab" aria-controls="a" aria-selected="false">A</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="b-tab" data-toggle="tab" href="#b" role="tab" aria-controls="b" aria-selected="false">B</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="c-tab" data-toggle="tab" href="#c" role="tab" aria-controls="c" aria-selected="false">C</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="d-tab" data-toggle="tab" href="#d" role="tab" aria-controls="d" aria-selected="false">D</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="e-tab" data-toggle="tab" href="#e" role="tab" aria-controls="e" aria-selected="false">E</a>
      </li>

      
     
      @endif

      @if($type=='mcq' || $type=='maq' || $type=='mbdq' || $type =='zip')
      <li class="nav-item">
        <a class="nav-link" id="answer-tab" data-toggle="tab" href="#answer" role="tab" aria-controls="answer" aria-selected="false">Ans</a>
      </li>
      @endif

      @if($type=='code' )
      <li class="nav-item">
        <a class="nav-link" id="a-tab" data-toggle="tab" href="#a" role="tab" aria-controls="a" aria-selected="false">Testcases</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="b-tab" data-toggle="tab" href="#b" role="tab" aria-controls="b" aria-selected="false">Lang</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="c-tab" data-toggle="tab" href="#c" role="tab" aria-controls="c" aria-selected="false">Preset Code</a>
      </li>
      @endif
      @if($type=='fillup' || $type=='mbfq' )
      <li class="nav-item">
        <a class="nav-link" id="answer-tab" data-toggle="tab" href="#answer" role="tab" aria-controls="answer" aria-selected="false">Ans</a>
      </li>
      @endif
       
       <li class="nav-item">
        <a class="nav-link" id="explanation-tab" data-toggle="tab" href="#explanation" role="tab" aria-controls="explanation" aria-selected="false">@if($type=='code') Solution @else Expl @endif</a>
      </li>
      @if($type!='code')
      <li class="nav-item">
        <a class="nav-link" id="passage-tab" data-toggle="tab" href="#passage" role="tab" aria-controls="passage" aria-selected="false">Passage</a>
      </li>
      @endif

      @if(request()->get('exam'))
      <li class="nav-item">
        <a class="nav-link" id="tag-tab" data-toggle="tab" href="#exam" role="tab" aria-controls="exam" aria-selected="false">Exam</a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Details</a>
      </li>
      @if(!request()->get('default'))

      <li class="nav-item">
        <a class="nav-link" id="dynamic-tab" data-toggle="tab" href="#dynamic" role="tab" aria-controls="dynamic" aria-selected="false">Dyn</a>
      </li>
       
       <li class="nav-item">
        <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="false">Category</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" id="tag-tab" data-toggle="tab" href="#tag" role="tab" aria-controls="tag" aria-selected="false">Tag</a>
      </li>
      
     
      @endif
       
    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
        @include('appl.dataentry.question.ques')
        

      </div>

      @if($type=='code')
       <div class="tab-pane fade" id="a" role="tabpanel" aria-labelledby="a-tab">
        <div class="form-group mt-3">
          <p>Minimum one testcase is required for the compiler to work. If no testcases are provided, then the questions is considered as code submission question where the compiler button is disabled.</p>
          <table class="table">
  <thead>
    <tr class="bg-light">
      <th scope="col" width="10%">#</th>
      <th scope="col" width="45%">Input<br>
      <small>Input arguments have to be seperated by spaces only. For multi string input you have to warp the string with single quotes. <br>eg: 'apple' 'we are good' 'open house'</small></th>
      <th scope="col" width="45%">Output<br>
       <small>Output supports multiple lines.</small></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><input class="form-control " type="text" name="in_1" value="@if($stub=='Create'){{ (old('in_1')) ? old('in_1') : '' }}@else{{ $testcases['in_1'] }}@endif"  ></td>
      <td><textarea class="form-control " name="out_1"  rows="3">@if($stub=='Create'){{ (old('out_1')) ? old('out_1') : '' }}@else {{ $testcases['out_1'] }}@endif</textarea></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><input class="form-control " type="text" name="in_2" value="@if($stub=='Create'){{ (old('in_2')) ? old('in_2') : '' }}@else{{ $testcases['in_2'] }}@endif"  ></td>
      <td><textarea class="form-control " name="out_2"  rows="3">@if($stub=='Create'){{ (old('out_2')) ? old('out_2') : '' }}@else {{ $testcases['out_2'] }}@endif</textarea></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td><input class="form-control " type="text" name="in_3" value="@if($stub=='Create'){{ (old('in_3')) ? old('in_3') : '' }}@else{{ $testcases['in_3'] }}@endif"  ></td>
      <td><textarea class="form-control " name="out_3"  rows="3">@if($stub=='Create'){{ (old('out_3')) ? old('out_3') : '' }}@else {{ $testcases['out_3'] }}@endif</textarea></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td><input class="form-control " type="text" name="in_4" value="@if($stub=='Create'){{ (old('in_4')) ? old('in_4') : '' }}@else{{ $testcases['in_4'] }}@endif"  ></td>
      <td><textarea class="form-control " name="out_4"  rows="3">@if($stub=='Create'){{ (old('out_4')) ? old('out_4') : '' }}@else {{ $testcases['out_4'] }}@endif</textarea></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td><input class="form-control " type="text" name="in_5" value="@if($stub=='Create'){{ (old('in_5')) ? old('in_5') : '' }}@else{{ $testcases['in_5'] }}@endif"  ></td>
      <td><textarea class="form-control " name="out_5"  rows="3">@if($stub=='Create'){{ (old('out_5')) ? old('out_5') : '' }}@else {{ $testcases['out_5'] }}@endif</textarea></td>
    </tr>
  </tbody>
</table>
         
      </div>
      </div>
      <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="b-tab">
        <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Language </label><br>
  <select class="form-control"  name="b">
   <option value="" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='') selected @endif @endif >-NA- (User can select the language)</option>
    <option value="c" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='C') selected @endif @endif >c</option>
    <option value="cpp" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='CPP') selected @endif @endif >cpp</option>
    <option value="java" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='JAVA') selected @endif @endif >java</option>
    <option value="python" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='PYTHON') selected @endif @endif >python</option>
    <option value="csharp" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='CSHARP') selected @endif @endif >c#</option>
    <option value="javascript" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='JAVASCRIPT') selected @endif @endif >javascript</option>
     <option value="php" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='PHP') selected @endif @endif >php</option>
     <option value="ruby" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='RUBY') selected @endif @endif >ruby</option>
     <option value="swift" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='SWIFT') selected @endif @endif >swift</option>
     <option value="bash" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='BASH') selected @endif @endif >bash</option>
     <option value="sql" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='SQL') selected @endif @endif >SQL</option>
     <option value="nolang" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='NOLANG') selected @endif @endif >NoLang</option>
  </select>
  <p class="mt-4"><b>Note:</b><br> if -NA- is selected, user will have the choice to select his desired language to write the code. And if a specific language is selected, user has to program only in the specified language.</p>
      </div>
      </div>

       <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="c-tab">
        <div class="form-group mt-3">
        <div class="row">
          <div class="col-12 ">
            <p class="mt-4"><b>Generic</b></p>
<textarea class="form-control " name="preset_generic"  rows="5">@if($stub=='Create'){{ (old('preset_generic')) ? old('preset_generic') : '' }}@else{{ $question->c }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
            <p class="mt-4"><b>C Programming</b></p>
<textarea class="form-control " name="preset_c"  rows="5">@if($stub=='Create'){{ (old('preset_c')) ? old('preset_c') : '' }}@else{{ $codes->preset_c }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
<p class="mt-4"><b>C++</b></p>
<textarea class="form-control " name="preset_cpp"  rows="5">@if($stub=='Create'){{ (old('preset_cpp')) ? old('preset_cpp') : '' }}@else{{ $codes->preset_cpp }}@endif</textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <p class="mt-4"><b>Python</b></p>
<textarea class="form-control " name="preset_python"  rows="5">@if($stub=='Create'){{ (old('preset_python')) ? old('preset_python') : '' }}@else{{ $codes->preset_python }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
<p class="mt-4"><b>Java</b></p>
<textarea class="form-control " name="preset_java"  rows="5">@if($stub=='Create'){{ (old('preset_java')) ? old('preset_java') : '' }}@else{{ $codes->preset_java }}@endif</textarea>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <p class="mt-4"><b>C#</b></p>
<textarea class="form-control " name="preset_csharp"  rows="5">@if($stub=='Create'){{ (old('preset_csharp')) ? old('preset_csharp') : '' }}@else{{ $codes->preset_csharp }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
<p class="mt-4"><b>Javascript</b></p>
<textarea class="form-control " name="preset_javascript"  rows="5">@if($stub=='Create'){{ (old('preset_javascript')) ? old('preset_javascript') : '' }}@else{{ $codes->preset_javascript }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
<p class="mt-4"><b>Nolang</b></p>
<textarea class="form-control " name="preset_nolang"  rows="5">@if($stub=='Create'){{ (old('preset_nolang')) ? old('preset_nolang') : '' }}@else{{ $codes->preset_nolang }}@endif</textarea>
          </div>
          <div class="col-12 col-md-6">
<p class="mt-4"><b>Constraints</b></p>
<textarea class="form-control " name="constraints"  rows="5">@if($stub=='Create'){{ (old('constraints')) ? old('constraints') : '' }}@else{{ $codes->constraints }}@endif</textarea>
          </div>
        </div>

      </div>
      </div>

      @endif

      @if($type=='mcq' || $type=='maq' || $type=='mbdq')
      <div class="tab-pane fade" id="a" role="tabpanel" aria-labelledby="a-tab">
        <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Option A</label>
         <textarea class="form-control summernote" name="a"  rows="5">
            @if($stub=='Create')
            {{ (old('a')) ? old('a') : '' }}
            @else
            {{ $question->a }}
            @endif
        </textarea>
      </div>
      </div>
      <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="b-tab">
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Option B</label>
         <textarea class="form-control summernote" name="b"  rows="5">
            @if($stub=='Create')
            {{ (old('b')) ? old('b') : '' }}
            @else
            {{ $question->b }}
            @endif
        </textarea>
      </div>
      </div>
      <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="c-tab">
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Option C</label>
         <textarea class="form-control summernote" name="c"  rows="5">
            @if($stub=='Create')
            {{ (old('c')) ? old('c') : '' }}
            @else
            {{ $question->c }}
            @endif
        </textarea>
      </div>
      </div>
      <div class="tab-pane fade" id="d" role="tabpanel" aria-labelledby="d-tab">
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Option D</label>
         <textarea class="form-control summernote" name="d"  rows="5">
            @if($stub=='Create')
            {{ (old('d')) ? old('d') : '' }}
            @else
            {{ $question->d }}
            @endif
        </textarea>
      </div>
      </div>
      <div class="tab-pane fade" id="e" role="tabpanel" aria-labelledby="e-tab">
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Option E</label>
         <textarea class="form-control summernote" name="e"  rows="5">
            @if($stub=='Create')
            {{ (old('e')) ? old('e') : '' }}
            @else
            {{ $question->e }}
            @endif
        </textarea>
      </div>
      </div>
      @endif

      @if($type=='mcq' || $type=='maq' || $type=='mbdq' || $type =='zip')
      <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
         @include('appl.dataentry.snippets.answer')
      </div>
      @endif
      <div class="tab-pane fade" id="explanation" role="tabpanel" aria-labelledby="explanation-tab">
       <div class="form-group mt-3">
        @if($type!='code')
        <label for="formGroupExampleInput2">Explanation / Solution (Visible to candidates only if solutions are enabled for the test report)</label>
         <textarea class="form-control summernote" name="explanation"  rows="5">
            @if($stub=='Create')
            {{ (old('explanation')) ? old('explanation') : '' }}
            @else
            {{ $question->explanation }}
            @endif
        </textarea>
       @else
           
           @include('appl.dataentry.question.code_compiler')

       @endif
      </div>
      </div>
      <div class="tab-pane fade" id="dynamic" role="tabpanel" aria-labelledby="dynamic-tab">
        <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Dynamic</label>
         <textarea id="code" class="form-control code" name="dynamic"  rows="5">@if($stub=='Create'){{ (old('dynamic')) ? old('dynamic') : '' }}@else{{ $question->dynamic }}@endif
        </textarea>
      </div>
      </div>

      <div class="tab-pane fade" id="passage" role="tabpanel" aria-labelledby="passage-tab">

       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Passage</label>
         <textarea class="form-control summernote" name="passage"  rows="5">
            @if($stub=='Create')
            {{ (old('passage')) ? old('passage') : '' }}
            @else
            {{ $question->passage }}
            @endif
        </textarea>
      </div>
       
      </div>
      <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
        <div class="form-group mt-3">
          <div class="card mb-3 bg-light border">
            <div class="card-body">Category</div>
          </div>
        @if(!request()->get('default'))
         @if($categories)
          <div class="dd">
          {!! $categories !!}
          </div>
          @else
          <div class="card card-body bg-light">
          No Categories listed
        </div>
          @endif
        @else
          <input type="hidden" name="categories[]" value="@if($_SERVER['SERVER_NAME']=='xp.test') 1118 @else 1215 @endif">
        @endif
        </div>
      </div>
      <div class="tab-pane fade" id="tag" role="tabpanel" aria-labelledby="tag-tab">
        @include('appl.dataentry.snippets.tag')
      </div>

      @if(request()->get('exam'))
      <div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="tag-tab">
        @include('appl.dataentry.snippets.exam')
      </div>
      @endif
      <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
        
        <div class="form-group mt-3">
          <label for="formGroupExampleInput ">Slug</label>
          <input type="text" class="form-control"  id="formGroupExampleInput" 
              @if($stub=='Create')
              value="{{ (old('slug')) ? old('slug') : str_random(10) }}"
              @else
              value = "{{ $question->slug }}"
              @endif
              disabled
            >
            <input type="hidden" class="form-control" name="slug" id="formGroupExampleInput" 
              @if($stub=='Create')
              value="{{ (old('slug')) ? old('slug') : str_random(10) }}"
              @else
              value = "{{ $question->slug }}"
              @endif
            >
        </div>

        <div class="form-group mt-3">
          <label for="formGroupExampleInput ">Topic</label>
          <input type="text" class="form-control"  id="formGroupExampleInput"  name="topic"
              @if($stub=='Create')
              value="{{ (old('topic')) ? old('topic') : '' }}"
              @else
              value = "{{ $question->topic }}"
              @endif
            >
        </div>

        <div class="form-group mt-3">
          <label for="formGroupExampleInput ">Mark</label>
          <input type="text" class="form-control"  id="formGroupExampleInput"  name="mark"
              @if($stub=='Create')
              value="{{ (old('mark')) ? old('mark') : '1' }}"
              @else
              value = "{{ $question->mark }}"
              @endif
            >
        </div>

        <div class="form-group mt-3">
          <label for="formGroupExampleInput ">Type {{$type}}</label>
          @if($stub=='Update')
          <select class="form-control" name="type" >
            <option value="mcq" @if(isset($question)) @if($question->type=='mcq') selected @endif @endif >Multiple Choice Question</option>
            <option value="naq" @if(isset($question)) @if($question->type=='naq') selected @endif @endif >Numerical Answer Question</option>
            <option value="maq" @if(isset($question)) @if($question->type=='maq') selected @endif @endif >Multi Answer Question</option>
            <option value="eq" @if(isset($question)) @if($question->type=='eq') selected @endif @endif >Explanation Question</option>
            <option value="code" @if(isset($question)) @if($question->type=='code') selected @endif @endif >Code Question</option>
            <option value="vq" @if(isset($question)) @if($question->type=='vq') selected @endif @endif >Video Question</option>
            <option value="aq" @if(isset($question)) @if($question->type=='aq') selected @endif @endif >Audio Question</option>
            <option value="fillup" @if(isset($question)) @if($question->type=='fillup') selected @endif @endif >Fillup Question</option>
            <option value="mbfq" @if(isset($question)) @if($question->type=='mbfq') selected @endif @endif >Multiblank Fillup Question</option>
            <option value="mbdq" @if(isset($question)) @if($question->type=='mbdq') selected @endif @endif >Multiblank Dropdown Question</option>
            <option value="sq" @if(isset($question)) @if($question->type=='sq') selected @endif @endif >Subjective Question</option>
            <option value="csq" @if(isset($question)) @if($question->type=='csq') selected @endif @endif >Code Submission Question</option>
            <option value="urq" @if(isset($question)) @if($question->type=='urq') selected @endif @endif >Upload Response Question</option>
            <option value="typing" @if(isset($question)) @if($question->type=='typing') selected @endif @endif >Typing Question</option>
            <option value="pdf" @if(isset($question)) @if($question->type=='pdf') selected @endif @endif >Question PDF Question</option>
            <option value="zip" @if(isset($question)) @if($question->type=='zip') selected @endif @endif >Zip Question</option>
            <option value="updf" @if(isset($question)) @if($question->type=='updf') selected @endif @endif >Upload PDF Question</option>
            
          </select>
          @else
          <select class="form-control" name="type" >
            <option value="mcq" @if($type =='mcq') selected @endif  >Multiple Choice Question</option>
            <option value="naq" @if($type =='naq') selected @endif  >Numerical Answer Question</option>
            <option value="maq" @if($type =='maq') selected @endif  >Multi Answer Question</option>
            <option value="eq" @if($type =='eq') selected @endif  >Explanation Question</option>
            <option value="code" @if($type =='code') selected @endif  >Code Question</option>
            <option value="vq" @if($type =='vq') selected @endif  >Video Question</option>
             <option value="aq" @if($type =='aq') selected @endif  >Audio Question</option>
            <option value="fillup" @if($type =='fillup')  selected  @endif >Fillup Question</option>

            <option value="mbfq" @if($type =='mbfq')  selected  @endif >Multiblank Fillup Question</option>
            <option value="mbdq" @if($type =='mbdq')  selected  @endif >Multiblank Dropdown Question</option>
            <option value="sq" @if($type =='sq')  selected  @endif >Subjective Question</option>
            <option value="csq" @if($type =='csq')  selected  @endif >Code Submission Question</option>
            <option value="urq" @if($type =='urq')  selected  @endif >Upload Response Question</option>
            <option value="typing" @if($type =='typing')  selected  @endif >Typing Question</option>

            <option value="pdf" @if($type =='pdf')  selected  @endif >Question PDF Question</option>
              <option value="zip" @if($type =='zip')  selected  @endif >Zip Question</option>
            <option value="updf" @if($type =='updf')  selected  @endif >Upload PDF Question</option>
          </select>
          @endif
            
        </div>

        <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Level</label>
        <select class="form-control" name="level" >
          <option value="0" @if(isset($question)) @if($question->level==0) selected @endif @endif >None</option>
          <option value="1" @if(isset($question)) @if($question->level==1) selected @endif @endif >Level 1</option>
          <option value="2" @if(isset($question)) @if($question->level==2) selected @endif @endif >Level 2</option>
          <option value="3" @if(isset($question)) @if($question->level==3) selected @endif @endif >Level 3</option>
        </select>

      </div>

      @if(!request()->get('default'))
       <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Include in Test</label>
        <select class="form-control" name="intest" >
          <option value="0" @if(isset($question)) @if($question->intest==0) selected @endif @endif >No</option>
          <option value="1" @if(isset($question)) @if($question->intest==1) selected @endif @endif >Yes</option>
        </select>

      </div> 
      @endif

        <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Status</label>
        @can('publish',$question)
        <select class="form-control" name="status" >
          <option value="0" @if(isset($question)) @if($question->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($question)) @if($question->status==1) selected @endif @endif >Published</option>
          <option value="2" @if(isset($question)) @if($question->status==2) selected @endif @endif >Live</option>
        </select>
        @endcan

        @cannot('publish',$question)
        <select class="form-control" name="status" >
          <option value="0" @if(isset($question)) @if($question->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($question)) @if($question->status==1) selected @endif @endif >Published</option>
        </select>
        @endcannot
      </div>

       <div class="form-group mt-3">


        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        @if(request()->get('exam'))
        <input type="hidden" name="exam" value="{{ request()->get('exam') }}">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="hidden" name="url" value=" {{ request()->get('url') }}">
       
        <input type="hidden" name="stage" value="1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      </div>
    </div>

    </form>
    </div>
  </div>

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
        
        This following action will delete the question data and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('question.destroy',['project'=>$project->slug,'question'=>$question->id,'url'=>request()->get('url')])}}">
        <input type="hidden" name="exam" value="{{request()->get('exam')}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection