@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create {{ $app->module }}
        @else
          Update {{ $app->module }}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data" >
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->slug)}}" enctype="multipart/form-data" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">{{ ucfirst($app->module)}} Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
      </div>
      

      <div class="form-group">
        <label for="formGroupExampleInput2">slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Enter the slug"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $obj->slug }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Description</label>
         <textarea class="form-control summernote" name="description"  rows="10">{{isset($obj)?$obj->description:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Details</label>
         <textarea class="form-control summernote" name="details"  rows="10">{{isset($obj)?$obj->details:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Keywords</label>
         <textarea class="form-control " name="keywords"  rows="4">{{isset($obj)?$obj->keywords:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Related</label>
         <textarea class="form-control " name="related"  rows="4">{{isset($obj)?$obj->related:''}}</textarea>
      </div>
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Image</label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" 
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Math Equations</label>
        <select class="form-control" name="math">
          <option value="0" @if(isset($obj)) @if($obj->math==0) selected @endif @endif >No</option>
          <option value="1" @if(isset($obj)) @if($obj->math==1) selected @endif @endif >Yes</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Inactive</option>
          <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
        </select>
      </div>

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection