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
        <label for="formGroupExampleInput2">Description</label>
         <textarea class="form-control " name="description"  rows="5">{{isset($chapter)?$chapter->description:''}}</textarea>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput2">Keywords</label>
         <textarea class="form-control " name="keywords"  rows="3">{{isset($chapter)?$chapter->keywords:''}}</textarea>
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
      <a href="">
      <button type="button" class="btn btn-danger">Delete</button>
      </a>
    </form>
    </div>
  </div>
@endsection