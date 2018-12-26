@extends('layouts.app')
@section('title', 'Create/Edit Track Page | PacketPrep')
@section('content')

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('docs.index')}}">Tracks</a></li>
      <li class="breadcrumb-item active" aria-current="page"> {{ $stub }} </li>
    </ol>
  </nav>
  @include('flash::message')
  <div class="card border">
    <div class="card-body">

      <nav class="navbar navbar-light bg-light justify-content-between mb-3 border p-3">
          <a class="navbar-brand"><i class="fa fa-file"></i> {{ $stub }} Track </a>
      </nav>    
      
      @if($stub=='Create')
      <form method="post" action="{{route('docs.store')}}">
      @else
      <form method="post" action="{{route('docs.update',$doc->slug)}}">
      @endif  
      <div class="form-group">
        <label >Name</label>
        <input type="text" class="form-control" name="name"  placeholder="Enter the Track Name" 

            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $doc->name }}"
            @endif

            >
      </div>
      <div class="form-group">
        <label >Image</label>
        <input type="text" class="form-control" name="image"  placeholder="Enter the image url" 

            @if($stub=='Create')
            value="{{ (old('image')) ? old('image') : '' }}"
            @else
            value = "{{ $doc->image }}"
            @endif

            >
      </div>
      <div class="form-group">
        <label >Slug</label>
        <input type="text" class="form-control" name="slug" placeholder="Unique Identifier" 
          @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $doc->slug }}"
            @endif
        >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="author_id" value="{{ auth::user()->id }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($doc)) @if($doc->status==0) selected @endif @endif >Draft</option>
          <option value="1" @if(isset($doc)) @if($doc->status==1) selected @endif @endif > Published</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Privacy</label>
        <select class="form-control" name="privacy">
          <option value="0" @if(isset($doc)) @if($doc->privacy==0) selected @endif @endif >Public</option>
          <option value="1" @if(isset($doc)) @if($doc->privacy==1) selected @endif @endif >Site Members Only</option>
        </select>
      </div>
      
      @if($stub=='Update')
      <input type="hidden" name="_method" value="PUT">
      @endif
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection