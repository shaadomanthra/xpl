@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">User Accounts</a></li>
    <li class="breadcrumb-item">@if($stub=='Create')
          Create User
        @else
          Update User
        @endif  </li>
  </ol>
</nav>

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        @if($stub=='Create')
          Create User
        @else
          Update User
        @endif  
       </h1>
      
      @if($stub=='Create')
      <form method="post" action="{{route('admin.user.store')}}" >
      @else
      <form method="post" action="{{route('admin.user.update',[$user->username])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter your Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $user->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Email</label>
       
       @if($stub!='Update')
        <input type="text" class="form-control" name="email" id="formGroupExampleInput2" placeholder="Email address"
            @if($stub=='Create')
            value="{{ (old('email')) ? old('email') : '' }}"
            @else
            value = "{{ $user->email }}"
            @endif
          >
          @else
           <input type="text" class="form-control" name="email" id="formGroupExampleInput2" placeholder="Email address"
            value = "{{ $user->email }}" disabled
          >
          @endif

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id_creator" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
        <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="1" @if(isset($user))@if($user->status==1) selected @endif @endif>Active</option>
          <option value="2" @if(isset($user))@if($user->status==2) selected @endif @endif>Blocked</option>
        </select>
      </div>


      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection