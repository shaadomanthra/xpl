@extends('layouts.app')
@section('content')

  @include('appl.library.snippets.breadcrumbs')
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light p-3 mb-3 border">
        @if($stub=='Create')
          Create Passage
        @else
          Update Passage
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('lpassage.store',$repo->slug)}}" >
      @else
      <form method="post" action="{{route('lpassage.update',[$repo->slug,$lpassage->id])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Passage Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Passage Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $lpassage->name }}"
            @endif
          >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="passage"  rows="5">
            @if($stub=='Create')
            {{ (old('passage')) ? old('passage') : '' }}
            @else
            {{ $lpassage->passage }}
            @endif
        </textarea>

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="repository_id" value="{{ $repo->id }}">
        <input type="hidden" name="stage" value="
            @if(auth::user()->checkRole(['feeder'])) 1 
            @elseif(auth::user()->checkRole(['proof-reader'])) 2
            @elseif(auth::user()->checkRole(['renovator'])) 3
            @elseif(auth::user()->checkRole(['validator'])) 4
            @else 5
            @endif
             ">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($lpassage)) @if($lpassage->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($lpassage)) @if($lpassage->status==1) selected @endif @endif >Published</option>
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