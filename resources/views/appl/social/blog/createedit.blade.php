@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social</li>
  </ol>
</nav>
  @include('flash::message')
  <div class="card">
    <div class="card-body">

      <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bullhorn"></i> {{ $stub }} Blog </a>
      </nav>    
      



      @if($stub=='Create')
      <form method="post" action="{{route('blog.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route('blog.update',$blog->id)}}" enctype="multipart/form-data" >
      @endif  
      
      

      <div class="form-group">
        <label for="formGroupExampleInput ">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title of the Blog" 
          @if($stub=='Create')
            value="{{ (old('title')) ? old('title') : '' }}"
            @else
            value = "{{ $blog->title }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Slug</label>
        <input type="text" class="form-control" name="slug" placeholder="slug" 
          @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $blog->slug }}"
            @endif
        >
      </div>

       <div class="form-group">
          <label for="formGroupExampleInput " class="root" data-rooturl="{{URL::to('/')}}">Header Image</label>
          <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" >
          <br>
          <input type="hidden" name="username" value="{{ auth::user()->username }}">
          <div class="image_container">
          @if(isset($blog->image ))
            @if($blog->image!=' ')
            <img src="{{ URL::to('/').'/'.$blog->image }}" class="image"  width="25%"/>
            @endif
          @endif
          </div>  
        </div>
      

      <div class="form-group">
        <label for="formGroupExampleInput2">Intro</label>
         <textarea class="form-control summernote" name="intro"  rows="5">
            @if($stub=='Create')
            {{ (old('intro')) ? old('intro') : '' }}
            @else
            {{ $blog->intro }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="5">
            @if($stub=='Create')
            {{ (old('content')) ? old('content') : '' }}
            @else
            {{ $blog->content }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Keywords</label>
        <input type="text" class="form-control" name="keywords" placeholder="keywords seperated by commas" 
          @if($stub=='Create')
            value="{{ (old('keywords')) ? old('keywords') : '' }}"
            @else
            value = "{{ $blog->keywords }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Schedule</label>
      <input type="text" class="form-control" name="schedule"   value="{{isset($blog->schedule)? \carbon\carbon::parse($blog->schedule)->format('Y-m-d'):''}}" id="datepicker">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Label</label>
        <select class="form-control" name="label_id">
          <option value="1" @if(isset($blog)) @if($blog->label_id==1) selected @endif @endif >General</option>
          <option value="2" @if(isset($blog)) @if($blog->label_id==2) selected @endif @endif >Life Skills</option>
          <option value="3" @if(isset($blog)) @if($blog->label_id==3) selected @endif @endif >Career Guidance</option>
          <option value="4" @if(isset($blog)) @if($blog->label_id==4) selected @endif @endif >Campus Stories</option>
          <option value="5" @if(isset($blog)) @if($blog->label_id==5) selected @endif @endif >Inspiration</option>
          <option value="6" @if(isset($blog)) @if($blog->label_id==6) selected @endif @endif >Exam Tips</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($blog)) @if($blog->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($blog)) @if($blog->status==1) selected @endif @endif >Preview</option>
          <option value="2" @if(isset($blog)) @if($blog->status==2) selected @endif @endif >Final</option>
        </select>
      </div>

      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="image" class="formimage" value="@if(isset($blog->image)) {{$blog->image}} @else &nbsp; @endif">
        <input type="hidden" name="user_id_writer" value="@if(isset($blog->user_id_writer)) {{$blog->user_id_writer}} @else {{auth::user()->id }} @endif">
        <input type="hidden" name="user_id_moderator" value="@if(isset($blog->user_id_moderator)) {{$blog->user_id_moderator}} @else {{auth::user()->id }} @endif">
      </div>

      
      
      @if($stub=='Update')
      <input type="hidden" name="_method" value="PUT">
      @endif
      <button type="submit" class="btn btn-info">Save</button>
       <a href="#" class="btn  btn-outline-danger" data-toggle="modal" data-target="#exampleModal"  title="Delete" ><i class="fa fa-trash"></i> Delete</a>
    </form>
    </div>
  </div>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        This following action will delete the update and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('blog.destroy',$blog->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection