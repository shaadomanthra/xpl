@extends('layouts.app')
@section('title', 'Create/Edit - '.$exam->name)
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Test
        @else
          Update Test
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('exam.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('exam.update',$exam->slug)}}" enctype="multipart/form-data">
      @endif  

      <div class='row'>
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Test Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Test Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $exam->name }}"
            @endif
          >
       
      </div>
        </div>
        <div class="col-12 col-md-6">

          <div class="form-group">
        <label for="formGroupExampleInput ">Test Slug (unique identifier)</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput" placeholder="Enter unique identifier" 
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : $slug }}"
            @else
            value = "{{ $exam->slug }}"
            @endif
          >
          <small class="text-secondary">https://{{ $_SERVER['HTTP_HOST'].'/test/{slug}'}}</small>

           @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="examtype_id" value="{{$exam->examtype_id}}">
        @else
        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="examtype_id" value="6">

        @endif


        <input type="hidden" name="course_id" value="">
         
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
    </div>
        
        
      </div>

      <div class='row'>
        <div class="col-12 col-md-6">
          <div class="form-group @if(request()->get('id')=='description') p-3  pactive rounded bg-success text-white @endif">
        <label for="formGroupExampleInput ">Description</label>
        <textarea class="form-control summernote" name="description"  rows="5">
            @if($stub=='Create')
            {{ (old('description')) ? old('description') : '' }}
            @else
            {{ $exam->description }}
            @endif
        </textarea>
      </div>

        </div>
        <div class="col-12 col-md-6">
           <div class="form-group @if(request()->get('id')=='instructions') p-3  pactive rounded bg-success text-white @endif">
        <label for="formGroupExampleInput ">Instructions</label>
        <textarea class="form-control summernote" name="instructions"  rows="5">
            @if($stub=='Create')
            {{ (old('instructions')) ? old('instructions') : '' }}
            @else
            {{ $exam->instructions }}
            @endif
        </textarea>
      </div>

        </div>
        
      </div>

      
      

      <div class="form-group     @if(request()->get('id')=='accesscode') p-3  pactive rounded bg-success text-white @endif" id="accesscode">
        <label for="formGroupExampleInput ">Access Code</label>
        
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="{{ (old('code')) ? old('code') : '' }}"
            @else
            value = "{{ $exam->code }}"
            @endif
          >
          <div class="mt-2">
          <small class=" "> 
            <ul class="pt-2">
              <li>You can add multiple access code seperated by commas.</li>
              <li>Employer can uniquely name the access codes to categorise the participants based on job opening.</li>
              <li>Candidate has to enter the following code to write the exam.</li>
            </ul>
            </small>
          </div>
          
      </div>
      

      <div class="form-group @if(request()->get('id')=='emails') p-3  pactive rounded bg-success text-white @endif">
        <label for="formGroupExampleInput ">Candidates Emails</label>

<textarea class="form-control " name="emails"  rows="5">@if($stub=='Create'){{ (old('emails')) ? old('emails') : '' }} @else{{ $exam->emails }} @endif
        </textarea>
        <small class=''>
        <ul class="pt-2">
              <li>Candidates with above mentioned email ids will get the access to the test. </li>
              <li>Leave the field empty to make the test open for all.</li>
                          </ul></small>
      </div>

      <div class="row" id="image">
        <div class="col-12 col-md-6">
           <div class="form-group">
        <label for="formGroupExampleInput ">Logo</label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
      </div>
      
        </div>
        <div class="col-12 col-md-6">
           <div class="form-group">
        <label for="formGroupExampleInput ">Banner in report page</label>
        <input type="file" class="form-control" name="file2_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
      </div>
      
        </div>
      </div>
     
     
      <div class="@if(request()->get('id')=='settings') p-3  pactive rounded bg-success text-white mb-3 @endif">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Report</label>
        <select class="form-control" name="solutions">
          <option value="0" @if(isset($exam)) @if($exam->solutions==0) selected @endif @endif >Yes with solutions</option>
          <option value="1" @if(isset($exam)) @if($exam->solutions==1) selected @endif @endif >Yes without solutions</option>
          <option value="2" @if(isset($exam)) @if($exam->solutions==2) selected @endif @endif >No report</option>
        </select>
      </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">

        <label for="formGroupExampleInput ">Camera</label>
        @if(\auth::user()->checkRole(['administrator']))
        <select class="form-control" name="camera">
          <option value="0" @if(isset($exam)) @if($exam->camera==0) selected @endif @endif >Disable</option>
          <option value="1" @if(isset($exam)) @if($exam->camera==1) selected @endif @endif >Enable</option>
        </select>
        @elseif(\auth::user()->role==11 || \auth::user()->role ==12 )
        <select class="form-control" name="camera">
          <option value="0" @if(isset($exam)) @if($exam->camera==0) selected @endif @endif >Disable</option>
          <option value="1" @if(isset($exam)) @if($exam->camera==1) selected @endif @endif >Enable</option>
        </select>
        @else
        <select class="form-control" name="camera" disabled>
          <option value="0" @if(isset($exam)) @if($exam->camera==0) selected @endif @endif >Disable</option>
          <option value="1" @if(isset($exam)) @if($exam->camera==1) selected @endif @endif >Enable</option>
        </select>
        <input type="hidden" name="camera" value="0">
        @endif
        <small class='text-secondary'>Camera option is available for pro and advanced accounts only</small>
      </div>
        </div>
      </div>
      
      
        <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($exam)) @if($exam->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($exam)) @if($exam->status==1) selected @endif @endif >Free Access</option>
          <option value="2" @if(isset($exam)) @if($exam->status==2) selected @endif @endif >Private</option>
        </select>
      </div>
        </div>
        <div class="col-12 col-md-6">
           <div class="form-group">
        <label for="formGroupExampleInput ">Link</label>
        <select class="form-control" name="active">
          <option value="0" @if(isset($exam)) @if($exam->active==0) selected @endif @endif >Active</option>
          <option value="1" @if(isset($exam)) @if($exam->active==1) selected @endif @endif >Inactive</option>
        </select>
      </div>
        </div>
      </div>
    </div>

      

     

      



      <button type="submit" class="btn btn-info btn-lg">Save</button>
    </form>
    </div>
  </div>
 
@endsection