@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Exam
        @else
          Update Exam
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('exam.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('exam.update',$exam->slug)}}" enctype="multipart/form-data">
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Exam Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Exam Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $exam->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Exam Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $exam->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Access Code</label>
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter the Access Code" 
            @if($stub=='Create')
            value="{{ (old('code')) ? old('code') : '' }}"
            @else
            value = "{{ $exam->code }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Examtype</label>
        <select class="form-control" name="examtype_id">
          @foreach($examtypes as $et)
          <option value="{{ $et->id }}"  @if($exam->examtype_id== $et->id) selected @endif  >{{ $et->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Course</label>
        <select class="form-control" name="course_id">
          <option value="">None</option>
          @foreach($courses as $c)
          <option value="{{ $c->id }}"  @if($exam->course_id== $c->id) selected @endif  >{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Description</label>
        <textarea class="form-control summernote" name="description"  rows="5">
            @if($stub=='Create')
            {{ (old('description')) ? old('description') : '' }}
            @else
            {{ $exam->description }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Instructions</label>
        <textarea class="form-control summernote" name="instructions"  rows="5">
            @if($stub=='Create')
            {{ (old('instructions')) ? old('instructions') : '' }}
            @else
            {{ $exam->instructions }}
            @endif
        </textarea>
      </div>
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Image</label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
      </div>
      
       <div class="form-group">
        <label for="formGroupExampleInput ">Solutions</label>
        <select class="form-control" name="solutions">
          <option value="0" @if(isset($exam)) @if($exam->solutions==0) selected @endif @endif >Yes</option>
          <option value="1" @if(isset($exam)) @if($exam->solutions==1) selected @endif @endif >No</option>
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