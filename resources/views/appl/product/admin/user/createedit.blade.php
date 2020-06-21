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

      <div class="row">
        <div class="col-12 col-md-4">
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
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group ">
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

      </div>

        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Phone </label>
        <input type="text" class="form-control" name="phone" id="formGroupExampleInput" placeholder="Enter your Phone Number" 
            @if($stub=='Create')
            value="{{ (old('phone')) ? old('phone') : '' }}"
            @else
            value = "{{ ($user)?$user->phone:'' }}"
            @endif
          >
      </div>

        </div>

      </div>
      <div class="row">
        <div class="col-12 col-md-4">
         
      <div class="form-group">
        <label for="formGroupExampleInput ">Client</label>
          
        <select class="form-control" name="client_slug">
          <option value=""> Xplore </option>
          @foreach($clients as $c)
          <option value="{{$c->slug}}" @if(isset($user)) @if($user->client_slug) @if($c->slug == $user->client_slug ) selected @endif @endif @endif >{{ $c->name }}</option>
          @endforeach         
        </select>
      </div>
      
        </div>
        <div class="col-12 col-md-4">
           @if(isset($colleges))
      <div class="form-group">
        <label for="formGroupExampleInput ">College</label>
        <select class="form-control" name="college_id">
          @foreach($colleges as $c)
          <option value="{{$c->id}}" @if(isset($user)) @if($user->colleges->first()) @if($c->id == $user->colleges->first()->id ) selected @endif @endif @endif >{{ $c->name }}</option>
          @endforeach         
        </select>
      </div>
      @endif

        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Year of Passing</label>
        <select class="form-control" name="year_of_passing">
          @for($i=2019;$i < 2029;$i++)
          <option value="{{$i}}" @if(isset($user_details))@if($user_details->year_of_passing== $i) selected @endif @endif> {{ $i }}</option>
          @endfor
        </select>
      </div>

        </div>


      </div>
      


      @if(isset($branches))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Branches</label><br>
        <div class="row">
        @foreach($branches as $branch)
        <div class="col-12 col-md-2">
        <input  type="checkbox" name="branches[]" value="{{$branch->id}}" 
              @if($stub!='Create')
                  @if(in_array($branch->id, $user->branches()->pluck('id')->toArray()))
                  checked
                  @endif
              @endif
            > {{ $branch->name }} 
          </div>
        @endforeach
      </div>

      </div>
      @endif

      

      <!--

      @if(isset($metrics))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Metrics</label><br>
        <div class="row">
        @foreach($metrics as $metric)
        <div class="col-12 col-md-2">
        <input  type="checkbox" name="metrics[]" value="{{$metric->id}}" 
              @if($stub!='Create')
                  @if(in_array($metric->id, $user->metrics()->pluck('id')->toArray()))
                  checked
                  @endif
              @endif
            > {{ $metric->name }} </div>
        @endforeach
      </div>
      </div>
      @endif -->


        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      
     
     <div class="row">
        

        <div class="col-12 col-md-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Site Manager</label>
        <select class="form-control" name="hrmanager">
           <option value="1"  @if(isset($user))@if($user->roles()->first()) @if(!$user->roles()->find(28)) selected @endif @endif @endif>No</option>
          <option value="10" @if(isset($user))@if($user->roles()->first()) @if($user->roles()->find(28) && $user->role==10) selected @endif @endif @endif>Basic</option>
          <option value="11" @if(isset($user))@if($user->roles()->first()) @if($user->roles()->find(28) && $user->role==11) selected @endif @endif @endif>Pro</option>
          <option value="12" @if(isset($user) )@if($user->roles()->first()) @if($user->roles()->find(28) && $user->role==12) selected @endif @endif @endif>Advanced</option>
        </select>
      </div>

        </div>

        <div class="col-12 col-md-4">
          <div class="form-group">
        <label for="formGroupExampleInput ">Training and Placement Officer</label>
        <select class="form-control" name="tpo">
           <option value="2"  @if(isset($user))@if($user->roles()->first()) @if($user->roles()->find(41)) selected @endif @endif @endif>No</option>
          <option value="1" @if(isset($user))@if($user->roles()->first()) @if($user->roles()->find(41)) selected @endif @endif @endif>Yes</option>
         
        </select>
      </div>

        </div>
        <div class="col-12 col-md-4">

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control" name="status">
          <option value="1" @if(isset($user))@if($user->status==1) selected @endif @endif>Active</option>
          <option value="2" @if(isset($user))@if($user->status==2) selected @endif @endif>Blocked</option>
        </select>
      </div>

        </div>
        <div class="col-12 col-md-4">

        </div>

      </div>
<!--
<div class="bg-light border p-3 mb-3">
      <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group">
        <label for="formGroupExampleInput ">Language </label>
        <input type="text" class="form-control" name="language" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="{{ (old('language')) ? old('language') : '' }}"
            @else
            value = "{{ ($user)?$user->language :''}}"
            @endif
          >
      </div>
        </div>
        <div class="col-12 col-md-4">
           <div class="form-group">
        <label for="formGroupExampleInput ">Confidence </label>
        <input type="text" class="form-control" name="confidence" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="{{ (old('confidence')) ? old('confidence') : '' }}"
            @else
            value = "{{ ($user)?$user->confidence :''}}"
            @endif
          >
      </div>

        </div>
        <div class="col-12 col-md-4">
           <div class="form-group">
        <label for="formGroupExampleInput ">Fluency </label>
        <input type="text" class="form-control" name="fluency" id="formGroupExampleInput" placeholder="" 
            @if($stub=='Create')
            value="{{ (old('fluency')) ? old('fluency') : '' }}"
            @else
            value = "{{ ($user)?$user->fluency :''}}"
            @endif
          >
      </div>

        </div>

      </div>
</div> 
-->
        



      <button type="submit" class="btn btn-info">Save</button>
    </form>
    </div>
  </div>
@endsection