@extends('layouts.corporate-body')
@section('content')

   <nav aria-label="breadcrumb">
    <ol class="breadcrumb border">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('team')}}">Team</a></li>
      <li class="breadcrumb-item "><a href="{{ route('role.index')}}">Roles</a></li>
      <li class="breadcrumb-item active" aria-current="page"> {{ $stub }} </li>
    </ol>
  </nav>
  @include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1>{{ $stub }} Role </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('role.store')}}">
      @else
      <form method="post" action="{{route('role.update',$role->slug)}}">
      @endif  
      <div class="form-group">
        <label >Role Name</label>
        <input type="text" class="form-control" name="name"  placeholder="Enter the Role Name" 

            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $role->name }}"
            @endif

            >
      </div>
      <div class="form-group">
        <label >Role Slug</label>
        <input type="text" class="form-control" name="slug" placeholder="Unique Identifier" 
          @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $role->slug }}"
            @endif
        >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <div class="form-group">
        <label >Parent Category</label>
        <select class="custom-select" name="parent_id">
          {!! $select_options !!}
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