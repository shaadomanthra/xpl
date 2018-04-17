@extends('layouts.app')
@section('content')

  @include('appl.dataentry.snippets.breadcrumbs')
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        @if($stub=='Create')
          Create Category
        @else
          Update Category
        @endif  
      </h1>
      
       @if($stub=='Create')
      <form method="post" action="{{route('category.store',$project->slug)}}" >
      @else
      <form method="post" action="{{route('category.update',['project_slug'=>$project->slug,'category_slug'=>$category->slug])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Category Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Category Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $category->name }}"
            @endif>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Category Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier" 
           @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $category->slug }}"
            @endif
        >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif
        
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