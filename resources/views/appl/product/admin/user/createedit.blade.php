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

      <div class="form-group">
        <label for="formGroupExampleInput ">Phone </label>
        <input type="text" class="form-control" name="phone" id="formGroupExampleInput" placeholder="Enter your Phone Number" 
            @if($stub=='Create')
            value="{{ (old('phone')) ? old('phone') : '' }}"
            @else
            value = "{{ ($user_details)?$user_details->phone:'' }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Phone 2</label>
        <input type="text" class="form-control" name="phone_2" id="formGroupExampleInput" placeholder="Enter your Second Phone Number" 
            @if($stub=='Create')
            value="{{ (old('phone_2')) ? old('phone_2') : '' }}"
            @else
            value = "{{ ($user_details)?$user_details->phone_2:'' }}"
            @endif
          >
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Roll Number </label>
        <input type="text" class="form-control" name="roll_number" id="formGroupExampleInput" placeholder="Enter your Roll Number" 
            @if($stub=='Create')
            value="{{ (old('roll_number')) ? old('roll_number') : '' }}"
            @else
            value = "{{ ($user_details)?$user_details->roll_number :''}}"
            @endif
          >
      </div>

      

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

      @if(isset($branches))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Branches</label><br>
        @foreach($branches as $branch)
        <input  type="checkbox" name="branches[]" value="{{$branch->id}}" 
              @if($stub!='Create')
                  @if(in_array($branch->id, $user->branches()->pluck('id')->toArray()))
                  checked
                  @endif
              @endif
            > {{ $branch->name }} <br>
        @endforeach

      </div>
      @endif

      <div class="form-group">
        <label for="formGroupExampleInput ">Year of Passing</label>
        <select class="form-control" name="year_of_passing">
          @for($i=2019;$i < 2029;$i++)
          <option value="{{$i}}" @if(isset($user_details))@if($user_details->year_of_passing== $i) selected @endif @endif> {{ $i }}</option>
          @endfor
        </select>
      </div>

      @if(isset($services))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Services</label><br>
        @foreach($services as $service)
        <input  type="checkbox" name="services[]" value="{{$service->id}}" 
              @if($stub!='Create')
                  @if(in_array($service->id, $user->services()->pluck('id')->toArray()))
                  checked
                  @endif
              @endif
            > {{ $service->name }} <br>
        @endforeach
      </div>
      @endif

      @if(isset($metrics))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput ">Metrics</label><br>
        @foreach($metrics as $metric)
        <input  type="checkbox" name="metrics[]" value="{{$metric->id}}" 
              @if($stub!='Create')
                  @if(in_array($metric->id, $user->metrics()->pluck('id')->toArray()))
                  checked
                  @endif
              @endif
            > {{ $metric->name }} <br>
        @endforeach
      </div>
      @endif


        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      


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