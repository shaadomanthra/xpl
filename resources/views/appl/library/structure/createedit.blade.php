@extends('layouts.app')
@section('content')

  @include('appl.dataentry.snippets.breadcrumbs')
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light p-3 mb-3">
        @if($stub=='Create')
          Create Structure
        @else
          Update Structure
        @endif  
      </h1>
      
       @if($stub=='Create')
      <form method="post" action="{{route('structure.store',$repo->slug)}}" >
      @else
      <form method="post" action="{{route('structure.update',['repo_slug'=>$repo->slug,'struct_slug'=>$struct->slug])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Structure Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the struct Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $struct->name }}"
            @endif>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">struct Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" 
           @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $struct->slug }}"
            @endif
        >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="repo_slug" value="{{ $repo->slug }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Parent struct</label>

        <select class="custom-select" name="parent_id">
          {!! $select_options !!}
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Type</label>
        <select class="form-control" name="type">
          <option value="1" @if(isset($struct)) @if($struct->status==1) selected @endif @endif >Subject</option>
          <option value="2" @if(isset($struct)) @if($struct->status==2) selected @endif @endif >Chapter</option>
          <option value="3" @if(isset($struct)) @if($struct->status==3) selected @endif @endif >Lesson</option>
          <option value="4" @if(isset($struct)) @if($struct->status==4) selected @endif @endif >Concept</option>
          <option value="5" @if(isset($struct)) @if($struct->status==5) selected @endif @endif >Variant</option>
        </select>
      </div>
      
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection