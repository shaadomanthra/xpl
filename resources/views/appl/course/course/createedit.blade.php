@extends('layouts.app')
@section('title', 'Create/Edit Course | PacketPrep')
@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('material')}}">Material</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('course.index')}}">Courses</a></li>
    <li class="breadcrumb-item active" aria-current="page">@if($stub=='Create') Create @else Update @endif</li>
  </ol>
</nav>

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border rounded p-3 mb-3">
        @if($stub=='Create')
          Create Course
        @else
          Update Course
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('course.store')}}" >
      @else
      <form method="post" action="{{route('course.update',$course->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Course Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Course Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $course->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Course Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $course->slug }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Intro Youtube</label>
        <input type="text" class="form-control" name="intro_youtube" id="formGroupExampleInput2" placeholder="Youtube Video Url"
            @if($stub=='Create')
            value="{{ (old('intro_youtube')) ? old('intro_youtube') : '' }}"
            @else
            value = "{{ $course->intro_youtube }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Intro Vimeo</label>
        <input type="text" class="form-control" name="intro_vimeo" id="formGroupExampleInput2" placeholder="Vimeo Video Url"
            @if($stub=='Create')
            value="{{ (old('intro_vimeo')) ? old('intro_vimeo') : '' }}"
            @else
            value = "{{ $course->intro_vimeo }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Image</label>
        <input type="text" class="form-control" name="image" id="formGroupExampleInput2" placeholder="Image to display"
            @if($stub=='Create')
            value="{{ (old('image')) ? old('image') : '' }}"
            @else
            value = "{{ $course->image }}"
            @endif
          >
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput2">Description</label>
         <textarea class="form-control summernote" name="description"  rows="5">{{isset($course->description)?$course->description:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Weightage Minimum</label>
        <input type="number" class="form-control" name="weightage_min" placeholder="Minimum Weightage of marks" 
          @if($stub=='Create')
            value="{{ (old('weightage_min')) ? old('weightage_min') : '' }}"
            @else
            value = "{{ $course->weightage_min }}"
            @endif
        >
      </div>
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Weightage Average</label>
        <input type="number" class="form-control" name="weightage_avg" placeholder="Average Weightage of marks" 
          @if($stub=='Create')
            value="{{ (old('weightage_avg')) ? old('weightage_avg') : '' }}"
            @else
            value = "{{ $course->weightage_avg }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Weightage Maximum</label>
        <input type="number" class="form-control" name="weightage_max" placeholder="Maximum Weightage of marks" 
          @if($stub=='Create')
            value="{{ (old('weightage_max')) ? old('weightage_max') : '' }}"
            @else
            value = "{{ $course->weightage_max }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Price</label>
        <input type="number" class="form-control" name="price" placeholder="Course Price" 
          @if($stub=='Create')
            value="{{ (old('price')) ? old('price') : '' }}"
            @else
            value = "{{ $course->price }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Important Topics</label>
         <textarea class="form-control summernote" name="important_topics"  rows="5">{{isset($course->important_topics)?$course->important_topics:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Reference Books</label>
         <textarea class="form-control summernote" name="reference_books"  rows="5">{{isset($course->reference_books)?$course->reference_books:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($course)) @if($course->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($course)) @if($course->status==1) selected @endif @endif >Published</option>
        </select>
      </div>

      <div class="form-group">
        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif
        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <button type="submit" class="btn btn-info">Save</button>
      <a href="#"  data-toggle="modal" data-target="#exampleModal" ><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
            </span>
    </form>

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
        This following action will delete the node and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('course.destroy',['course_id'=>$course->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
@endsection