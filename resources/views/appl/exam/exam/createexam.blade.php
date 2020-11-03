@extends('layouts.app')
@section('title', 'Generate Exam ')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Generate Exam Paper
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('exam.save')}}" >
      @endif  

      <div class="row ">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Test Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Test Name" value="{{ (old('name')) ? old('name') : 'Aptitude Test #' }}" >
       
      </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="form-group  ">
        <label for="formGroupExampleInput2">Test Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" value="{{ (old('slug')) ? old('slug') : 'aptitude-' }}" >

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
        </div>
      </div>

      
      
      <div class="row  d-none">
        <div class="col-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Exam Loop Start</label>
            <input type="hidden" class="form-control" name="l_start" id="formGroupExampleInput" placeholder="Enter the loop i start" value="1" >
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Exam Loop End</label>
        <input type="hidden" class="form-control" name="l_end" id="formGroupExampleInput" placeholder="Enter the loop i end" value="2" >
        </div>
        </div>
      </div>
      
      

      @for($i=1;$i<6;$i++)
      <div class="bg-light border p-3 mb-3">
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Section {{$i}} Name </label>
            <input type="text" class="form-control" name="sec_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section name" value="{{ (old('sec_'.$i)) ? old('sec_'.$i) : '' }}" >
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Question Bank</label>
        <select class="form-control" name="sec_slug_{{$i}}">
          <option value="" >-None-</option>
          <option value="quantitative-aptitude" >Quantitative Aptitude</option>
          <option value="verbal-ability-1" >Verbal Ability</option>
          <option value="mental-ability" >Mental Ability</option>
          <option value="programming-concepts-2" >C Programming</option>
          <option value="data-structures" >Data Structures & Algorithms</option>
        </select>
        </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Question Count</label>
        <input type="text" class="form-control" name="sec_count_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section question count" value="{{ (old('sec_count_'.$i)) ? old('sec_count_'.$i) : '10' }}" >
        </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Section Mark</label>
        <input type="text" class="form-control" name="sec_mark_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section Mark" value="{{ (old('sec_mark_'.$i)) ? old('sec_mark_'.$i) : '1' }}" >
        </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Section Negative</label>
        <input type="text" class="form-control" name="sec_negative_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section Negative" value="{{ (old('s_4_negative')) ? old('s_4_negative') : '0' }}" >
        </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Section Time</label>
        <input type="text" class="form-control" name="sec_time_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section time" value="{{ (old('sec_time_'.$i)) ? old('sec_time_'.$i) : '10' }}" >
        </div>
        </div>
      </div>
      </div>
      @endfor

      <div class="row ">
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Description</label>
        <textarea class="form-control summernote" name="description"  rows="5">
            
            <p>Xplore Aptitude tests will test your ability to perform tasks and react to situations at work. This includes problem-solving, prioritisation and numerical skills, amongst other things.</p>
            
        </textarea>
      </div>
        </div>
        <div class="col-12 col-md-6">
           <div class="form-group">
        <label for="formGroupExampleInput ">Instructions</label>
        <textarea class="form-control summernote" name="instructions"  rows="5">
            @if($stub=='Create')
            <ul ><li>This test contains 45 questions to be answered in 45 minutes</li><li>For every question there are either four options A,B,C,D or five options A,B,C,D,E out of which only one option is correct</li><li>Each question carries 1 mark and there is no negative marking</li></ul>
            @else
            {{ $exam->instructions }}
            @endif
        </textarea>
      </div>
        </div>
      </div>


       <div class="row ">
        <div class="col-12 col-md-6">

      <div class="form-group">
        <label for="formGroupExampleInput ">Examtype</label>
        <select class="form-control" name="examtype_id">
          @foreach($examtypes as $et)
          <option value="{{ $et->id }}"  @if($et->slug=='general') selected @endif >{{ $et->name }}</option>
          @endforeach
        </select>
      </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($exam)) @if($exam->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($exam)) @if($exam->status==1) selected @endif @endif >Published</option>
          <option value="2" @if(isset($exam)) @if($exam->status==2) selected @endif @endif >Premium</option>
        </select>
      </div>
        </div>
      </div>

      
      <button type="submit" class="btn btn-info">Generate Exam</button>
    </form>
    </div>
  </div>
@endsection