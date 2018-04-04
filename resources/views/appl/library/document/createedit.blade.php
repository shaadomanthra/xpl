@extends('layouts.app')
@section('content')

  @include('appl.library.snippets.breadcrumbs')
  @include('flash::message')

  <div class="card">
    <div class="card-body">
      <h1 class="bg-light p-3 mb-3 border">
        @if($stub=='Create')
          Create Document
        @else
          Update Document
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('document.store',$repo->slug)}}" >
      @else
      <form method="post" action="{{route('document.update',[$repo->slug,$document->id])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Document Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the document Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $document->name }}"
            @endif
          >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Document Link</label>
          <input type="text" class="form-control" name="document" id="formGroupExampleInput" placeholder="Enter the document link" 
            @if($stub=='Create')
            value="{{ (old('document')) ? old('document') : '' }}"
            @else
            value = "{{ $document->document }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="repository_id" value="{{ $repo->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Chapter</label>

        <select class="custom-select" name="structure_id">
          {!! $select_options !!}
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($document)) @if($document->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($document)) @if($document->status==1) selected @endif @endif >Published</option>
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