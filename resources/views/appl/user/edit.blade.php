@extends('layouts.app')
@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('profile','@'.$user->username)}}">User</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
    </ol>
  </nav>
  @include('flash::message') 
  <div class="card">
    <div class="card-body">
      <h1>Edit Profile </h1>
      @include('flash::message')
      <form method="post" action="{{route('profile.update','@'.$user->username)}}">
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name"  value="{{ $user->name }}">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Designation</label>
        <input type="text" class="form-control" name="designation"  value="{{ ($user->designation)?$user->designation:'Not Assigned' }}" disabled>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Username</label>
        <input type="text" class="form-control" name="username"  value="{{ $user->username }}" disabled>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Email</label>
        <input type="text" class="form-control" name="email"  value="{{ $user->email }}" disabled>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Password</label>
        <input type="password" class="form-control" name="password"  value="nochange" >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput ">Re-Password</label>
        <input type="password" class="form-control" name="repassword"  value="nochange" >
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Biodata</label>
         <textarea class="form-control summernote" name="bio"  rows="10">{{isset($user_details)?$user_details->bio:''}}</textarea>
      </div>

       <div class="form-group">
        <label for="formGroupExampleInput ">Country</label>
        <select class="form-control" name="country">
          @foreach($user_details->countries as $code =>$country)
          @if($code==$user_details->country)
            <option value="{{$code}}" selected>{{$country}}</option>
            @else
            <option value="{{$code}}">{{$country}}</option>
          @endif
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">City (optional)</label>
        <input type="text" class="form-control" name="city"  placeholder="Enter your city name" value="{{ $user_details->city }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Facebook URL (optional)</label>
        <input type="text" class="form-control" name="facebook_link"  placeholder="Enter your Facebook profile url" value="{{ $user_details->facebook_link }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Twitter URL (optional)</label>
        <input type="text" class="form-control" name="twitter_link"  placeholder="Enter your Twitter profile url" value="{{ $user_details->twitter_link }}">
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Profile Visibility</label>
        <select class="form-control" name="privacy">
          <option value="0" @if($user_details->privacy==0) selected @endif>Public</option>
          <option value="1" @if($user_details->privacy==1) selected @endif>Site Members Only</option>
          <option value="2" @if($user_details->privacy==2) selected @endif>Private (Only Me)</option>
        </select>
      </div>

      <div class="form-group">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
      <button type="submit" class="btn btn-info">Update</button>
    </form>
    </div>
  </div>
@endsection