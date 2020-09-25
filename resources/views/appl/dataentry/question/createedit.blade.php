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
      <form method="post" action="{{route('question.store',$project->slug)}}" >
      @else
      <form method="post" action="{{route('question.update',[$project->slug,$question->id])}}" >
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

      @if($type=='mcq' || $type=='maq' )
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
      <li class="nav-item">
        <a class="nav-link" id="answer-tab" data-toggle="tab" href="#answer" role="tab" aria-controls="answer" aria-selected="false">Ans</a>
      </li>
     
      @endif
      @if($type=='code')
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
      @if($type=='fillup')
      <li class="nav-item">
        <a class="nav-link" id="answer-tab" data-toggle="tab" href="#answer" role="tab" aria-controls="answer" aria-selected="false">Ans</a>
      </li>
      @endif
       
       <li class="nav-item">
        <a class="nav-link" id="explanation-tab" data-toggle="tab" href="#explanation" role="tab" aria-controls="explanation" aria-selected="false">Expl</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="passage-tab" data-toggle="tab" href="#passage" role="tab" aria-controls="passage" aria-selected="false">Passage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tag-tab" data-toggle="tab" href="#exam" role="tab" aria-controls="exam" aria-selected="false">Exam</a>
      </li>
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
      
      <li class="nav-item">
        <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Details</a>
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
          <table class="table">
  <thead>
    <tr class="bg-light">
      <th scope="col" width="10%">#</th>
      <th scope="col" width="45%">Input<br>
      <small>Input arguments have to be seperated by spaces only.</small></th>
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
    <option value="perl" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='PERL') selected @endif @endif >perl</option>
    <option value="csharp" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='CSHARP') selected @endif @endif >c#</option>
    <option value="javascript" @if(isset($question)) @if(strtoupper(strip_tags($question->b))=='JAVASCRIPT') selected @endif @endif >javascript</option>
     
  </select>
      </div>
      </div>

       <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="c-tab">
        <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Preset Code (Use this only if, language is fixed)</label><br>
        <textarea class="form-control " name="c"  rows="5">@if($stub=='Create'){{ (old('c')) ? old('c') : '' }}@else{{ $question->c }}@endif
        </textarea>
      </div>
      </div>

      @endif
      @if($type=='mcq' || $type=='maq')
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
      <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
         @include('appl.dataentry.snippets.answer')
       
      </div>
      <div class="tab-pane fade" id="explanation" role="tabpanel" aria-labelledby="explanation-tab">
       <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Explanation / Solution (Visible to candidates only if solutions are enabled for the test report)</label>
         <textarea class="form-control summernote" name="explanation"  rows="5">
            @if($stub=='Create')
            {{ (old('explanation')) ? old('explanation') : '' }}
            @else
            {{ $question->explanation }}
            @endif
        </textarea>
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
        @if(request()->get('default'))
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

      <div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="tag-tab">
        @include('appl.dataentry.snippets.exam')
      </div>
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
            <option value="fillup" @if(isset($question)) @if($question->type=='fillup') selected @endif @endif >Fillup Question</option>
            <option value="sq" @if(isset($question)) @if($question->type=='sq') selected @endif @endif >Subjective Question</option>
            <option value="urq" @if(isset($question)) @if($question->type=='urq') selected @endif @endif >Upload Response Question</option>
            <option value="typing" @if(isset($question)) @if($question->type=='typing') selected @endif @endif >Typing Question</option>
          </select>
          @else
          <select class="form-control" name="type" >
            <option value="mcq" @if($type =='mcq') selected @endif  >Multiple Choice Question</option>
            <option value="naq" @if($type =='naq') selected @endif  >Numerical Answer Question</option>
            <option value="maq" @if($type =='maq') selected @endif  >Multi Answer Question</option>
            <option value="eq" @if($type =='eq') selected @endif  >Explanation Question</option>
            <option value="code" @if($type =='code') selected @endif  >Code Question</option>
            <option value="fillup" @if($type =='fillup')  selected  @endif >Fillup Question</option>
            <option value="sq" @if($type =='sq')  selected  @endif >Subjective Question</option>
            <option value="urq" @if($type =='urq')  selected  @endif >Upload Response Question</option>
            <option value="typing" @if($type =='typing')  selected  @endif >Typing Question</option>
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
<!--
       <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Include in Test</label>
        <select class="form-control" name="intest" >
          <option value="0" @if(isset($question)) @if($question->intest==0) selected @endif @endif >No</option>
          <option value="1" @if(isset($question)) @if($question->intest==1) selected @endif @endif >Yes</option>
        </select>

      </div> -->

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