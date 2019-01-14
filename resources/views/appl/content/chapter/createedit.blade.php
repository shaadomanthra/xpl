@extends('layouts.app')
@section('title', 'Create/Edit Chapter | PacketPrep')
@section('content')

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('docs.index')}}">Docs</a></li>
      <li class="breadcrumb-item "><a href="{{ route('docs.show',$doc->slug)}}">{{ $doc->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page"> {{ $stub }} Chapter</li>
    </ol>
  </nav>
  @include('flash::message')
  <div class="card">
    <div class="card-body">

      <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-bars"></i> {{ $stub }} Chapter </a>
      </nav>  
      
      @if($stub=='Create')
      <form method="post" action="{{route('chapter.store',$doc->slug)}}">
      @else
      <form method="post" action="{{route('chapter.update',['doc'=>$doc->slug,'chapter'=>$chapter->slug])}}">
      @endif  
      <div class="form-group">
        <label >Chapter Title</label>
        <input type="text" class="form-control" name="title"  placeholder="Enter the Chapter Title" 

            @if($stub=='Create')
            value="{{ (old('title')) ? old('title') : '' }}"
            @else
            value = "{{ $chapter->title }}"
            @endif

            >
      </div>
      <div class="form-group">
        <label >Chapter Slug</label>
        <input type="text" class="form-control" name="slug" placeholder="Unique Identifier" 
          @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $chapter->slug }}"
            @endif
        >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Content</label>
         <textarea class="form-control summernote" name="content"  rows="10">{{isset($chapter)?$chapter->content:''}}</textarea>
      </div>

      

      <div class="form-group">
        <label >Parent Chapter</label>
        <select class="custom-select" name="parent_id">
          {!! $select_options !!}
        </select>
      </div>
      
      @if($stub=='Update')
      <input type="hidden" name="_method" value="PUT">
      @endif
      <button type="submit" class="btn btn-info">Save</button>

        <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" >Delete</a>
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
        
        This following action will delete the node as well as all the child nodes to it and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('chapter.destroy',['doc'=>$doc->slug, 'chapter'=> $chapter->slug])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection