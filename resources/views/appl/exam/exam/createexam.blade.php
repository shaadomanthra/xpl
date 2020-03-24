@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Exam Loop
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('exam.save')}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Test Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Test Name" value="{{ (old('name')) ? old('name') : 'Cocubes Aptitude Practice Test #' }}" >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Test Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" value="{{ (old('slug')) ? old('slug') : 'cocubes-aptitude-' }}" >

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <div class="row">
        <div class="col-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Exam Loop Start</label>
            <input type="text" class="form-control" name="l_start" id="formGroupExampleInput" placeholder="Enter the loop i start" value="{{ (old('l_start')) ? old('l_start') : '1' }}" >
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
        <label for="formGroupExampleInput ">Exam Loop End</label>
        <input type="text" class="form-control" name="l_end" id="formGroupExampleInput" placeholder="Enter the loop i end" value="{{ (old('l_end')) ? old('l_end') : '5' }}" >
        </div>
        </div>
      </div>
      
      <hr>

      @for($i=1;$i<5;$i++)
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Section {{$i}} Name </label>
            <input type="text" class="form-control" name="sec_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section name" value="{{ (old('sec_'.$i)) ? old('sec_'.$i) : '' }}" >
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Section Slug</label>
        <input type="text" class="form-control" name="sec_slug_{{$i}}" id="formGroupExampleInput" placeholder="Enter the section slug" value="{{ (old('sec_slug_'.$i)) ? old('sec_slug_'.$i) : '' }}" >
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
      <hr>
      @endfor

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
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Examtype</label>
        <select class="form-control" name="examtype_id">
          @foreach($examtypes as $et)
          <option value="{{ $et->id }}"  @if($et->slug=='general') selected @endif >{{ $et->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($exam)) @if($exam->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($exam)) @if($exam->status==1) selected @endif @endif >Published</option>
          <option value="2" @if(isset($exam)) @if($exam->status==2) selected @endif @endif >Premium</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection