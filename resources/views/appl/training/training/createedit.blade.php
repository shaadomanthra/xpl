@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create {{ucfirst($app->module)}}
        @else
          Update {{ucfirst($app->module)}}
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',$obj->slug)}}" enctype="multipart/form-data">
      @endif  

      <div class='row'>
      <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $obj->name }}"
            @endif
          >
      </div>
      </div>

      <div class="col-12 col-md-6">

          <div class="form-group">
        <label for="formGroupExampleInput ">Training Slug (unique identifier)</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput" placeholder="Enter unique identifier" 
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : $slug }}"
            @else
            value = "{{ $obj->slug }}"
            @endif
          >
          <small class="text-secondary">https://{{ $_SERVER['HTTP_HOST'].'/training/{slug}'}}</small>

          
      </div>
    </div>

    </div>

   
    
      

      <div class="form-group ">
        <label for="formGroupExampleInput ">Details</label><textarea class="form-control summernote" name="details"  rows="5">@if($stub=='Create'){{ (old('details')) ? old('details') : '' }}@else {{ $obj->details }} @endif</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Banner image </label>
        <input type="file" class="form-control" name="file2_" id="formGroupExampleInput" placeholder="Enter the image path" 
          >
          <small class="text-secondary">Kindly use only .jpg or .png</small>
      </div>



      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Trainer</label>
            <select class="form-control" name="trainer_id">
              <option value="10" @if(isset($obj)) @if($obj->trainer_id==10) selected @endif @endif >Poojitha</option>
              <option value="8" @if(isset($obj)) @if($obj->trainer_id==8) selected @endif @endif >Ramana</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Status</label>
            <select class="form-control" name="status">
              <option value="0" @if(isset($obj)) @if($obj->status==0) selected @endif @endif >Draft</option>
              <option value="1" @if(isset($obj)) @if($obj->status==1) selected @endif @endif >Active</option>
            </select>
          </div>
        </div>

      </div>
      

     

      

      @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $obj->id }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ \auth::user()->id }}">
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection