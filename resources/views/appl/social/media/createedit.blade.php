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
          <a class="navbar-brand"><i class="fa fa-bullhorn"></i> {{ $stub }} Media Post </a>
      </nav>    
      


      <div class="card bg-light mb-3">
        <div class="card-body">
        <form method="post" id="uploadimage"  action="{{route('imageupload')}}"  enctype="multipart/form-data">
        <div class="form-group">
          <label for="formGroupExampleInput " class="root" data-rooturl="{{URL::to('/')}}">Header Image</label>
          <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" >
          <br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="username" value="{{ auth::user()->username }}">
          <div class="image_container">
          @if(isset($social->image ))
            @if($social->image!=' ' && $social->image !='&nbsp;')
            <img src="{{ URL::to('/').'/'.$social->image }}" class="image"  width="25%"/>
            @endif
          @endif
          </div>  
        </div>
        <button type="button" class="btn btn-danger btn-remove ">Remove</button>
        <button type="submit" class="btn btn-info btn-image ">upload</button>
       </form>

      </div>
    </div>

      @if($stub=='Create')
      <form method="post" action="{{route('media.store')}}" >
      @else
      <form method="post" action="{{route('media.update',$social->id)}}" >
      @endif  
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Network</label>
        <select class="form-control" name="network">
          <option value="1" @if(isset($social)) @if($social->network==1) selected @endif @endif >Facebook</option>
          <option value="2" @if(isset($social)) @if($social->network==2) selected @endif @endif >Instagram</option>
          <option value="3" @if(isset($social)) @if($social->network==3) selected @endif @endif >Twitter</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="5">
            @if($stub=='Create')
            {{ (old('content')) ? old('content') : '' }}
            @else
            {{ $social->content }}
            @endif
        </textarea>
      </div>


      <div class="form-group">
        <label for="formGroupExampleInput ">Schedule</label>
      <input type="text" class="form-control" name="schedule"   value="{{isset($social->schedule)? \carbon\carbon::parse($social->schedule)->format('Y-m-d'):''}}" id="datepicker">
      </div>


      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($social)) @if($social->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($social)) @if($social->status==1) selected @endif @endif >Preview</option>
          <option value="2" @if(isset($social)) @if($social->status==2) selected @endif @endif >Final</option>
        </select>
      </div>

      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="image" class="formimage" value="@if(isset($social->image)) {{$social->image}} @else &nbsp; @endif">
        <input type="hidden" name="user_id_writer" value="@if(isset($social->user_id_writer)) {{$social->user_id_writer}} @else {{auth::user()->id }} @endif">
        <input type="hidden" name="user_id_moderator" value="@if(isset($social->user_id_moderator)) {{$social->user_id_moderator}} @else {{auth::user()->id }} @endif">
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
        
        <form method="post" action="{{route('media.destroy',$social->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection