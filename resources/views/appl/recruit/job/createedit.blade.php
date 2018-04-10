@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('recruit') }}">Recruit</a></li> 
    <li class="breadcrumb-item "><a href="{{ route('job.index')}}">Jobs</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      @if($stub=='Create')
          Post Job
        @else
          Update Job
        @endif  
    </li>
  </ol>
</nav>
@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light p-3 border mb-3">
        @if($stub=='Create')
          Post Job
        @else
          Update Job
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('job.store')}}" >
      @else
      <form method="post" action="{{route('job.update',$job->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Job Title</label>
        <input type="text" class="form-control" name="title" id="formGroupExampleInput" placeholder="Enter the Job Title" 
            @if($stub=='Create')
            value="{{ (old('title')) ? old('title') : '' }}"
            @else
            value = "{{ $job->title }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Job Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $job->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

     <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="5">
            @if($stub=='Create')
            {{ (old('content')) ? old('content') : '' }}
            @else
            {{ $job->content }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Vacancy</label>
        <input type="number" class="form-control" name="vacancy" id="formGroupExampleInput" placeholder="Enter the Job Title" 
            @if($stub=='Create')
            value="{{ (old('vacancy')) ? old('vacancy') : '1' }}"
            @else
            value = "{{ $job->vacancy }}"
            @endif
          >
       
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0"  @if($job->status==0) selected @endif >Open</option>
          <option value="1" @if($job->status==1) selected @endif >Closed</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection