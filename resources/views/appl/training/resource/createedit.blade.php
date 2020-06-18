@extends('layouts.app')
@section('content')

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="p-3 border bg-light mb-3">
        @if($stub=='Create')
          Create Resource
        @else
          Update Resource
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route($app->module.'.store')}}" enctype="multipart/form-data">
      @else
      <form method="post" action="{{route($app->module.'.update',[$app->training->slug,$obj->id])}}" enctype="multipart/form-data">
      @endif  

      <div class='row'>
      <div class="col-12 ">
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the name"  value = "{{ $obj->name }}">
      </div>
      </div>

      

    </div>

     <div class="form-group">
          <label for="exampleFormControlSelect1">Type</label>
          <select class="form-control" id="exampleFormControlSelect1" name="type">
            <option value="youtube_video_link"  @if(isset($obj)) @if($obj->type=='youtube_video_link') selected @endif @endif>Youtube Video Link</option>
            <option value="pdf_link" @if(isset($obj)) @if($obj->type=='pdf_link') selected @endif @endif>PDF Link</option>
            <option value="ppt_link" @if(isset($obj)) @if($obj->type=='ppt_link') selected @endif @endif>PPT Link</option>
            <option value="audio_link" @if(isset($obj)) @if($obj->type=='audio_link') selected @endif @endif>Audio Link</option>
          </select>
        </div>
         <div class="form-group">
          <label for="exampleFormControlInput1">Link</label>
          <input type="text" class="form-control" id="exampleFormControlInput1" name="link" placeholder="Enter the link "value="{{$obj->link}}">
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