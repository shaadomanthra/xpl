@extends('layouts.app')
@section('content')

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('data.dataentry.index')}}">Data Entry</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Project</li>
    </ol>
  </nav>
  @include('flash::message') 
  <div class="card">
    <div class="card-body">
      <h1>Edit Project </h1>
      @include('flash::message')
      <form method="post" action="{{route('data.dataentry.update',$project->slug)}}">
      <div class="form-group">
        <label for="formGroupExampleInput ">Project Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Project Name" value="{{ $project->name }}">
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Project Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" value="{{ $project->slug }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <button type="submit" class="btn btn-info">Update</button>
    </form>
    </div>
  </div>
@endsection