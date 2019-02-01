@extends('layouts.app')
@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb border">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/team')}}">Team</a></li>
      <li class="breadcrumb-item"><a href="{{ route('profile','@'.$user->username)}}">{{ $user->name}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Manage User</li>
    </ol>
  </nav>
  @include('flash::message') 
  <div class="card">
    <div class="card-body">
      <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-gear"></i> Manage User</a>
        </nav>
      <form method="get" action="{{route('profile.manage','@'.$user->username)}}">
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name"  value="{{ $user->name }}" disabled>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Designation</label>
        <input type="text" class="form-control" name="designation"  value="{{ ($user_details)?$user_details->designation:'' }}" >
      </div>
      

      <div class="form-group">
        <label for="formGroupExampleInput ">User Roles</label>
          {!! $roles !!}
      </div>
      

      <div class="form-group">
        <label for="formGroupExampleInput ">User Status</label>
        <select class="form-control" name="status">
          <option value="0" @if($user->status==0) selected @endif>Unactivated</option>
          <option value="1" @if($user->status==1) selected @endif>Activated</option>
          <option value="2" @if($user->status==2) selected @endif>Blocked</option>
          <option value="3" @if($user->status==3) selected @endif>Frozen</option>
        </select>
      </div>

      <div class="form-group">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <button type="submit" class="btn btn-info">Update</button>
    </form>
    </div>
  </div>
@endsection