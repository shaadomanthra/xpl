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
        <div class="col-12 col-md-3">

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
        <input type="hidden" name="client" value="{{ $exam->client }}">
        @else
        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="client" value="{{ subdomain() }}">
        <input type="hidden" name="examtype_id" value="6">

        @endif


        <input type="hidden" name="course_id" value="">
         
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
    </div>

    <div class="col-12 col-md-3">
      <label for="formGroupExampleInput ">Test type</label>
      <select class="form-control" name="examtype_id">
        @if(subdomain()=='xplore')
        <option value="6" @if(isset($exam)) @if($exam->examtype_id==6) selected @endif @endif >General</option>
        @endif

        @if(count($examtypes)==0)
        <option value="1" @if(isset($exam)) @if($exam->examtype_id==1) selected @endif @endif >General</option>
        @endif
        @foreach($examtypes as $et)
          <option value="{{$et->id}}" @if(isset($exam)) @if($exam->examtype_id==$et->id) selected @endif @endif >{{$et->name}}</option>
        @endforeach
        </select>
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

      <div class="border p-3 my-3">
        <h4><i class="fa fa-gear"></i> Additional Settings</h4>
        <hr>
      <div class="row">
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Report</label>
            <select class="form-control" name="solutions">
              <option value="1" @if(isset($exam)) @if($exam->solutions==1) selected @endif @endif >Yes without solutions</option>
              <option value="0" @if(isset($exam)) @if($exam->solutions==0) selected @endif @endif >Yes with solutions</option>
              <option value="3" @if(isset($exam)) @if($exam->solutions==3) selected @endif @endif >Yes (comments +  marks)</option>
               <option value="4" @if(isset($exam)) @if($exam->solutions==4) selected @endif @endif >Yes (only comments)</option>
               <option value="5" @if(isset($exam)) @if($exam->solutions==5) selected @endif @endif >Yes (only responses)</option>
              <option value="2" @if(isset($exam)) @if($exam->solutions==2) selected @endif @endif >No report</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Calculator</label>
            <select class="form-control" name="calculator">
              <option value="0" @if(isset($exam)) @if($exam->calculator==0) selected @endif @endif >Disable</option>
              <option value="1" @if(isset($exam)) @if($exam->calculator==1) selected @endif @endif >Enable</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Link Auto Activation</label>
            <input id="datetimepicker" class="form-control" type="text" value="{{isset($exam->auto_activation)? $exam->auto_activation:''}}"  name="auto_activation"></input>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Link Auto Deactivation</label>
            <input id="datetimepicker2" class="form-control" type="text" value="{{isset($exam->auto_deactivation)? $exam->auto_deactivation:''}}"  name="auto_deactivation"></input>
          </div>
        </div>
      </div>
      
      
        

      <div class="row">
        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Camera</label>
            <select class="form-control" name="camera">
              <option value="0" @if(isset($exam)) @if($exam->camera==0) selected @endif @endif >Disable</option>
              <option value="1" @if(isset($exam)) @if($exam->camera==1) selected @endif @endif >Enable</option>
            </select>
            
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Photo Capture Frequency</label>
            <select class="form-control" name="capture_frequency">
              <option value="0" @if(isset($exam)) @if($exam->capture_frequencys==0) selected @endif @endif >None</option>
              <option value="5" @if(isset($exam)) @if($exam->capture_frequency==5) selected @endif @endif >Every 5 secs</option>
              <option value="10" @if(isset($exam)) @if($exam->capture_frequency==10) selected @endif @endif >Every 10 secs</option>
              <option value="20" @if(isset($exam)) @if($exam->capture_frequency==20) selected @endif @endif >Every 20 secs</option>
              <option value="30" @if(isset($exam)) @if($exam->capture_frequency==30) selected @endif @endif >Every 30 secs</option>
              <option value="60" @if(isset($exam)) @if($exam->capture_frequency==60) selected @endif @endif >Every 1 min</option>
              <option value="300" @if(isset($exam)) @if($exam->capture_frequency==300) selected @endif @endif >Every 5 mins</option>
              <option value="600" @if(isset($exam)) @if($exam->capture_frequency==600) selected @endif @endif >Every 10 mins</option>
            </select>
          </div>
        </div>
         <div class="col-12 col-md-3">
           <div class="form-group">
            <label for="formGroupExampleInput ">Window Swap Alert </label>
            <select class="form-control" name="window_swap">
              <option value="1" @if(isset($exam)) @if($exam->window_swap==1) selected @endif @endif >Enable</option>
              <option value="0" @if(isset($exam)) @if($exam->window_swap==0) selected @endif @endif >Disable</option>
              
            </select>
          </div>
        </div>
        <div class="col-12 col-md-3">
           <div class="form-group">
            <label for="formGroupExampleInput ">Auto Terminate </label>
            <select class="form-control" name="auto_terminate">
              <option value="0" @if(isset($exam)) @if($exam->auto_terminate==0) selected @endif @endif >None</option>
              <option value="3" @if(isset($exam)) @if($exam->auto_terminate==3) selected @endif @endif >after 3 window swaps</option>
              <option value="6" @if(isset($exam)) @if($exam->auto_terminate==6) selected @endif @endif >after 6 window swaps</option>
              <option value="10" @if(isset($exam)) @if($exam->auto_terminate==10) selected @endif @endif >after 10 window swaps</option>
            </select>
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Message in 'No Report' page</label>
            <input  class="form-control" type="text" value="{{($exam->message)? $exam->message:'Your responses are recorded for internal evaluation.'}}"  name="message"></input>
          </div>
        </div>

        <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Mobile Disable</label>
        <select class="form-control" name="extra">
          <option value="1" @if(isset($exam)) @if($exam->extra==1) selected @endif @endif >Yes</option>
          <option value="0" @if(isset($exam)) @if($exam->extra==0) selected @endif @endif >No</option>
        </select>
      </div>
        </div>

         <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Question Shuffle</label>
        <select class="form-control" name="shuffle">
          <option value="1" @if(isset($exam)) @if($exam->shuffle==1) selected @endif @endif >Yes</option>
          <option value="0" @if(isset($exam)) @if($exam->shuffle==0) selected @endif @endif >No</option>
        </select>
      </div>
        </div>

         <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Save Responses(every 10 secs)</label>
        <select class="form-control" name="save">
          <option value="1" @if(isset($exam)) @if($exam->save==1) selected @endif @endif >Yes</option>
          <option value="0" @if(isset($exam)) @if($exam->save==0) selected @endif @endif >No</option>
        </select>
      </div>
        </div>

         <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Approval</label>
        <select class="form-control" name="manual_approval">
          <option value="no" @if(isset($exam)) @if($exam->manual_approval=="no") selected @endif @endif >Automatic</option>
          <option value="yes" @if(isset($exam)) @if($exam->manual_approval=="yes") selected @endif @endif >Manual</option>
        </select>
      </div>
      <small class='text-secondary'>Choose 'manual' if proctors have to verify student data before exam</small>
        </div>

         <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Proctor Chat</label>
        <select class="form-control" name="chat">
          <option value="no" @if(isset($exam)) @if($exam->chat=="no") selected @endif @endif >No</option>
          <option value="yes" @if(isset($exam)) @if($exam->chat=="yes") selected @endif @endif >Yes</option>
        </select>
      </div>
      <small class='text-secondary'>Enable it only, if proctors are assigned for the exam</small>
        </div>


        <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Section Timer</label>
        <select class="form-control" name="section_timer">
          <option value="no" @if(isset($exam)) @if($exam->section_timer=="no") selected @endif @endif >No</option>
          <option value="yes" @if(isset($exam)) @if($exam->section_timer=="yes") selected @endif @endif >Yes</option>
        </select>
      </div>
        </div>

        <div class="col-12 col-md-3">
           <div class="form-group">
        <label for="formGroupExampleInput ">Marking Scheme</label>
        <select class="form-control" name="section_marking">
          <option value="no" @if(isset($exam)) @if($exam->section_marking=="no") selected @endif @endif >Question wise</option>
          <option value="yes" @if(isset($exam)) @if($exam->section_marking=="yes") selected @endif @endif >Section wise</option>
        </select>
      </div>
        </div>

         <div class="col-12 col-md-3">
           <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Fullscreen mode</label>
        <select class="form-control" name="fullscreen">

          
          <option value="yes" @if(isset($exam)) @if($exam->fullscreen=="yes") selected @endif @endif >Yes</option>
          <option value="no" @if(isset($exam)) @if($exam->fullscreen=="no") selected @endif @endif >No</option>
        </select>
      </div>
        </div>

        <div class="col-12 col-md-3">
           <div class="form-group mt-3">
        <label for="formGroupExampleInput ">Upload Time (Descriptive Paper)</label>
        <select class="form-control" name="upload_time">

          <option value="0" @if(isset($exam)) @if($exam->upload_time==0) selected @endif @endif >None</option>
          <option value="600" @if(isset($exam)) @if($exam->upload_time==600) selected @endif @endif >Full Exam</option>
          <option value="1" @if(isset($exam)) @if($exam->upload_time==1) selected @endif @endif >last 1 minute</option>
          <option value="2" @if(isset($exam)) @if($exam->upload_time==2) selected @endif @endif >last 2 minutes</option>
          <option value="3" @if(isset($exam)) @if($exam->upload_time==3) selected @endif @endif >last 3 minutes</option>
          <option value="4" @if(isset($exam)) @if($exam->upload_time==4) selected @endif @endif >last 4 minutes</option>
          <option value="5" @if(isset($exam)) @if($exam->upload_time==5) selected @endif @endif >last 5 minutes</option>
          <option value="8" @if(isset($exam)) @if($exam->upload_time==8) selected @endif @endif >last 8 minutes</option>
          <option value="10" @if(isset($exam)) @if($exam->upload_time==10) selected @endif @endif >last 10 minutes</option>
          <option value="15" @if(isset($exam)) @if($exam->upload_time==15) selected @endif @endif >last 15 minutes</option>
          <option value="20" @if(isset($exam)) @if($exam->upload_time==20) selected @endif @endif >last 20 minutes</option>
          <option value="30" @if(isset($exam)) @if($exam->upload_time==30) selected @endif @endif >last 30 minutes</option>
          <option value="45" @if(isset($exam)) @if($exam->upload_time==45) selected @endif @endif >last 45 minutes</option>
          <option value="60" @if(isset($exam)) @if($exam->upload_time==60) selected @endif @endif >last 60 minutes</option>
          <option value="75" @if(isset($exam)) @if($exam->upload_time==75) selected @endif @endif >last 75 minutes</option>
          <option value="90" @if(isset($exam)) @if($exam->upload_time==90) selected @endif @endif >last 90 minutes</option>
          <option value="120" @if(isset($exam)) @if($exam->upload_time==120) selected @endif @endif >last 120 minutes</option>


        </select>
      </div>
        </div>


        <div class="col-12 col-md-3">
           <div class="form-group mt-3">
            <label for="formGroupExampleInput ">360<sup>o</sup> Camera Test</label>
            <select class="form-control" name="camera360">
              <option value="0" @if(isset($exam)) @if($exam->camera360==0) selected @endif @endif >-NA-</option>
              <option value="1" @if(isset($exam)) @if($exam->camera360==1) selected @endif @endif >After 1 min</option>
              <option value="5" @if(isset($exam)) @if($exam->camera360==5) selected @endif @endif >After 5 min</option>
              <option value="10" @if(isset($exam)) @if($exam->camera360==10) selected @endif @endif >After 10 min</option>
              <option value="15" @if(isset($exam)) @if($exam->camera360==15) selected @endif @endif >After 15 min</option>
            </select>

          <small class='text-secondary'>Enable it only if required, as it consumes more bandwidth.</small>
          </div>
        </div>

        <div class="col-12 col-md-3">
           <div class="form-group mt-3">
            <label for="formGroupExampleInput ">Video Snaps </label>
            <select class="form-control" name="videosnaps">
              <option value="0" @if(isset($exam)) @if($exam->videosnaps==0) selected @endif @endif >None</option>
              <option value="4" @if(isset($exam)) @if($exam->videosnaps==4) selected @endif @endif >Enable</option>
            </select>

          <small class='text-secondary'>4 videosnaps are recorded in the background at random intervals</small>
          </div>
        </div>


      </div>
    </div>
    </div>


    <div class="form-group p-3 d-none">
        <label for="formGroupExampleInput ">Extra Settings</label>

<textarea class="form-control " name="settings"  rows="5">@if($stub=='Create'){{ (old('settings')) ? old('settings') : '' }} @else{{ $exam->settings }} @endif
        </textarea>
      </div>

      

     

      



      <button type="submit" class="btn btn-info btn-lg">Save</button>
    </form>
    </div>
  </div>
 
@endsection