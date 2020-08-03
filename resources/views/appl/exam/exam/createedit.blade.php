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
        <option value="6" @if(isset($exam)) @if($exam->examtype_id==6) selected @endif @endif >General</option>
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

        <div class="col-12 col-md-3">
          <div class="form-group">
            <label for="formGroupExampleInput ">Photo Capture Frequency</label>
            @if(\auth::user()->checkRole(['administrator']))
            <select class="form-control" name="capture_frequency">
              <option value="0" @if(isset($exam)) @if($exam->capture_frequencys==0) selected @endif @endif >None</option>
              <option value="30" @if(isset($exam)) @if($exam->capture_frequency==30) selected @endif @endif >Every 30 secs</option>
              <option value="60" @if(isset($exam)) @if($exam->capture_frequency==60) selected @endif @endif >Every 1 min</option>
              <option value="300" @if(isset($exam)) @if($exam->capture_frequency==300) selected @endif @endif >Every 5 mins</option>
              <option value="600" @if(isset($exam)) @if($exam->capture_frequency==600) selected @endif @endif >Every 10 mins</option>
            </select>
            @elseif(\auth::user()->role==11 || \auth::user()->role ==12 )
            <select class="form-control" name="capture_frequency">
              <option value="0" @if(isset($exam)) @if($exam->capture_frequencys==0) selected @endif @endif >None</option>
              <option value="30" @if(isset($exam)) @if($exam->capture_frequency==30) selected @endif @endif >Every 30 secs</option>
              <option value="60" @if(isset($exam)) @if($exam->capture_frequency==60) selected @endif @endif >Every 1 min</option>
              <option value="300" @if(isset($exam)) @if($exam->capture_frequency==300) selected @endif @endif >Every 5 mins</option>
              <option value="600" @if(isset($exam)) @if($exam->capture_frequency==600) selected @endif @endif >Every 10 mins</option>
            </select>
            @else
            <select class="form-control" name="capture_frequency" disabled>
              <option value="0" @if(isset($exam)) @if($exam->capture_frequencys==0) selected @endif @endif >None</option>
              <option value="30" @if(isset($exam)) @if($exam->capture_frequency==30) selected @endif @endif >Every 30 secs</option>
              <option value="60" @if(isset($exam)) @if($exam->capture_frequency==60) selected @endif @endif >Every 1 min</option>
              <option value="300" @if(isset($exam)) @if($exam->capture_frequency==300) selected @endif @endif >Every 5 mins</option>
              <option value="600" @if(isset($exam)) @if($exam->capture_frequency==600) selected @endif @endif >Every 10 mins</option>
            </select>
            <input type="hidden" name="capture_frequency" value="0">
            @endif

            
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

        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Message in 'No Report' page</label>
            <input  class="form-control" type="text" value="{{($exam->message)? $exam->message:'Your responses are recorded for internal evaluation.'}}"  name="message"></input>
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

        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Viewers </label>
            <div class="border p-3">
              <div class="row">
              @foreach($hr_managers as $hr)
                 <div class="col-12 col-md-4">
                  <input  type="checkbox" name="viewers[]" value="{{$hr->id}}"
                    @if($stub=='Create')
                      @if(old('viewer'))
                        @if(in_array($hr->id,old('viewer')))
                        checked
                        @endif
                      @endif
                    @else
                      @if($exam->viewers)
                        @if(in_array($hr->id,$exam->viewers()->wherePivot('role','viewer')->pluck('id')->toArray()))
                        checked
                        @endif
                      @endif
                    @endif
                  > 
                  {{$hr->name }}
                </div>
              @endforeach
            </div>
            </div>
            <div class="mt-2">
          <small class=" "> 
            <ul class="pt-2">
              <li>Viewers can see the reports.</li>
              <li>Download the excel.</li>
              <li>Cannot modify test settings and responses.</li>
            </ul>
            </small>
          </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Evaluators </label>
            <div class="border p-3">
              <div class="row">
              @foreach($hr_managers as $hr)
                 <div class="col-12 col-md-4">
                  <input  type="checkbox" name="evaluators[]" value="{{$hr->id}}"
                    @if($stub=='Create')
                      @if(old('evaluator'))
                        @if(in_array($hr->id,old('evaluator')))
                        checked
                        @endif
                      @endif
                    @else
                      @if($exam->evaluators)
                        @if(in_array($hr->id,$exam->viewers()->wherePivot('role','evaluator')->pluck('id')->toArray()))
                        checked
                        @endif
                      @endif
                    @endif
                  > 
                  {{$hr->name }}
                </div>
              @endforeach
            </div>
            </div>
            <div class="mt-2">
          <small class=" "> 
            <ul class="pt-2">
              <li>Evaluators can award marks to subjective questions.</li>
              <li>View reports and download excel.</li>
              <li>Cannot modify test settings.</li>
            </ul>
            </small>
          </div>
          </div>
        </div>


      </div>
    </div>
    </div>

      

     

      



      <button type="submit" class="btn btn-info btn-lg">Save</button>
    </form>
    </div>
  </div>
 
@endsection