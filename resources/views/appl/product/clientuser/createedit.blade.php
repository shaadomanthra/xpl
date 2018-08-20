@extends('layouts.corporate-body')
@section('content')


  <nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
    <li class="breadcrumb-item"><a href="{{ route('client.show',$client->slug) }}">{{ $client->name}}</a></li>
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
      <form method="post" action="{{route('clientuser.store',$client->slug)}}" >
      @else
      <form method="post" action="{{route('clientuser.update',[$client->slug,$clientuser->username])}}" >
      @endif  
      <div class="form-group">
        <label for="formGroupExampleInput ">Name</label>
        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter your Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @else
            value = "{{ $clientuser->name }}"
            @endif
          >
       
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Email</label>
       
        <input type="text" class="form-control" name="email" id="formGroupExampleInput2" placeholder="Email address"
            @if($stub=='Create')
            value="{{ (old('email')) ? old('email') : '' }}"
            @else
            value = "{{ $clientuser->email }}"
            @endif
          >

        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id_creator" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>



      <div class="form-group">
        <label for="formGroupExampleInput ">Role</label>
        <select class="form-control" name="role">
          
          <option value="33" @if(isset($clientuser)) @if($clientuser->role==33) selected @endif @endif >Manager</option>
          <option value="32" @if(isset($clientuser)) @if($clientuser->role==32) selected @endif @endif >Owner</option>
        </select>
      </div>

      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection