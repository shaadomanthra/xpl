@extends('layouts.app')
@section('content')

@include('appl.library.snippets.breadcrumbs')
@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        @if($stub=='Create')
          Create Repository
        @else
          Update Repository
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('library.store')}}" >
      @else
      <form method="post" action="{{route('library.update',$repo->id)}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Repository Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter the Repository Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $repo->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Repository Slug</label>
        <input type="text" class="form-control" name="slug" id="formGroupExampleInput2" placeholder="Unique Identifier"
            @if($stub=='Create')
            value="{{ (old('slug')) ? old('slug') : '' }}"
            @else
            value = "{{ $repo->slug }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id_data_manager" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Data Lead</label>
        <select class="form-control" name="user_id_data_lead">
          <option value=""  >None</option>
          @if(isset($users['data_lead']))
          @foreach($users['data_lead'] as $user)
          <option value="{{ $user->id }}" @if(isset($repo)) @if($repo->user_id_data_lead== $user->id) selected @endif @endif >{{ $user->name }}</option>
          @endforeach
          @endif
        </select>
      </div>
    
      <div class="form-group bg-light p-3 border">
        <label for="formGroupExampleInput ">Content Engineer</label>
        @if(isset($users['content_engineer']))
        <ul class="list">
        @foreach($users['content_engineer'] as $c)
          <li class="item"><input type="checkbox" name="engineers[]" value="{{ $c->id }}" @if($repo->engineers)@if(in_array($c->id,$repo->engineers)) checked @endif @endif> {{ $c->name}}</li>
        @endforeach
      </ul>
        @endif
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Target</label>
      <input type="text" class="form-control" name="target"   value="{{isset($repo->target)? \carbon\carbon::parse($repo->target)->format('Y-m-d'):''}}" id="datepicker">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="0" @if(isset($repo)) @if($repo->status==0) selected @endif @endif >In Progress</option>
          <option value="1" @if(isset($repo)) @if($repo->status==1) selected @endif @endif >Completed</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection