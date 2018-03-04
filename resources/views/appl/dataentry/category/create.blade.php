@extends('layouts.app')
@section('content')

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('data.dataentry.index')}}">Data Entry</a></li>
      <li class="breadcrumb-item " ><a href="{{ route('data.dataentry.show',$project->slug)}}"> {{$project->project_name}}</a> </li>
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('project.category.index',$project->slug)}}"> Categories</a> </li>
      <li class="breadcrumb-item active" aria-current="page"> Create </li>
    </ol>
  </nav>
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1>Create Category </h1>
      
      <form method="post" action="{{route('project.category.store',$project->slug)}}">
      <div class="form-group">
        <label for="formGroupExampleInput ">Category Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Category Name" value="{{ (old('name')) ? old('name') : '' }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Category Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" value="{{ (old('slug')) ? old('slug') : '' }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="project_slug" value="{{ $project->slug }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Parent Category</label>

        <select class="custom-select" name="parent_id">
          {!! $select_options !!}
        </select>
      </div>
      
      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection