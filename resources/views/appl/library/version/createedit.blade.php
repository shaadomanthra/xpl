@extends('layouts.app')
@section('content')

  @include('appl.library.snippets.breadcrumbs')
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light p-3 mb-3 border">
        @if($stub=='Create')
          Create Version
        @else
          Update Version
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('version.store',$repo->slug)}}" >
      @else
      <form method="post" action="{{route('version.update',[$repo->slug,$version->id])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Version Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Version Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $version->name }}"
            @endif
          >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="5">
            @if($stub=='Create')
            {{ (old('content')) ? old('content') : '' }}
            @else
            {{ $version->content }}
            @endif
        </textarea>

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="repository_id" value="{{ $repo->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Concept</label>

        <select class="custom-select" name="structure_id">
          {!! $select_options !!}
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($version)) @if($version->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($version)) @if($version->status==1) selected @endif @endif >Published</option>
        </select>
      </div>

      <button type="submit" class="btn btn-outline-info">
          @if($stub=='Create')
            Save
          @else
            Update
          @endif
      </button>
    </form>
    </div>
  </div>
@endsection