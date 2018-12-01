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
      <form method="post" action="{{route('examtype.store')}}" >
      @else
      <form method="post" action="{{route('examtype.update',$examtype->slug)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Examtype Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Exam Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $examtype->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Examtype Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $examtype->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection