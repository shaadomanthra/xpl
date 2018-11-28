@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Section
        @else
          Update Section
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('sections.store',$exam->slug)}}" >
      @else
      <form method="post" action="{{route('sections.update',[$exam->slug,$section->id])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupsectionspleInput ">Section Name</label>
        <input type="text" class="form-control" name="name" id="formGroupsectionspleInput" placeholder="Enter the Section Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $section->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>



      <div class="form-group">
        <label for="formGroupsectionspleInput ">Instructions</label>
        <textarea class="form-control summernote" name="instructions"  rows="5">
            @if($stub=='Create')
            {{ (old('instructions')) ? old('instructions') : '' }}
            @else
            {{ $section->instructions }}
            @endif
        </textarea>
      </div>
      

      <div class="form-group">
        <label for="formGroupsectionspleInput ">Correct Mark</label>
        <input type="text" class="form-control" name="mark" id="formGroupsectionspleInput" placeholder="Enter the Mark per question" 
            @if($stub=='Create')
            value="{{ (old('mark')) ? old('mark') : '' }}"
            @else
            value = "{{ $section->mark }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupsectionspleInput ">Negative Marks</label>
        <input type="text" class="form-control" name="negative" id="formGroupsectionspleInput" placeholder="Enter the negative mark per question" 
            @if($stub=='Create')
            value="{{ (old('negative')) ? old('negative') : '' }}"
            @else
            value = "{{ $section->negative }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupsectionspleInput ">Time in minutes</label>
        <input type="text" class="form-control" name="time" id="formGroupsectionspleInput" placeholder="Enter the time in seconds" 
            @if($stub=='Create')
            value="{{ (old('time')) ? old('time') : '' }}"
            @else
            value = "{{ $section->time }}"
            @endif
          >
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection