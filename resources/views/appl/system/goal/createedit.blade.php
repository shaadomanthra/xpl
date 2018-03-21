@extends('layouts.app')
@section('content')

@include('appl.system.snippets.breadcrumb')
  @include('flash::message')
  <div class="card">
    <div class="card-body">

      <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bullhorn"></i> {{ $stub }} Goal </a>
      </nav>    
      
      @if($stub=='Create')
      <form method="post" action="{{route('goal.store')}}">
      @else
      <form method="post" action="{{route('goal.update',$goal->id)}}">
      @endif  
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title of the Goal" 
          @if($stub=='Create')
            value="{{ (old('title')) ? old('title') : '' }}"
            @else
            value = "{{ $goal->title }}"
            @endif
        >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="5">
            @if($stub=='Create')
            {{ (old('content')) ? old('content') : '' }}
            @else
            {{ $goal->content }}
            @endif
        </textarea>
      </div>

      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="@if(isset($goal->user_id)) {{$goal->user_id}} @else {{auth::user()->id }} @endif">
      </div>

      
      <div class="form-group">
        <label for="formGroupExampleInput ">Prime</label>
        <select class="form-control" name="prime">
          <option value="0" @if(isset($goal)) @if($goal->prime==0) selected @endif @endif >NO</option>
          <option value="1" @if(isset($goal)) @if($goal->prime==1) selected @endif @endif >YES</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($goal)) @if($goal->status==0) selected @endif @endif > Open</option>
          <option value="1" @if(isset($goal)) @if($goal->status==1) selected @endif @endif > Completed</option>
          <option value="2" @if(isset($goal)) @if($goal->status==2) selected @endif @endif > Incomplete</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">End Date</label>
      <input type="text" class="form-control" name="end_at" placeholder="Pick the end date"  value="{{isset($goal->end_at)? \carbon\carbon::parse($goal->end_at)->format('Y-m-d'):''}}" id="datepicker">
    </div>

    <div class="form-group">
        <label for="formGroupExampleInput2">End Note</label>
         <textarea class="form-control summernote" name="endnote"  rows="5">{{isset($goal->endnote)?$goal->endnote:''}}</textarea>
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
        
        <form method="post" action="{{route('goal.destroy',$goal->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection