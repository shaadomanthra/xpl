@extends('layouts.app-border')
@section('content')


@include('flash::message')
  <div class="card">
    <div class="card-body">
      <div class="bg-light border p-3 mb-3">
      <h1 class="">
        @if($stub=='Create')
          Engineering Student Registration - TARGET TCS 
        @else
          Update User
        @endif  
       </h1>
       <p>A 100 day online learning program to help students crack TCS Ninja All india Recruitment Test. <br>  </p>
     </div>
      
      @if($stub=='Create')
      <form method="post" action="{{route('admin.user.studentstore')}}" >
      @else
      <form method="post" action="{{route('admin.user.update',[$user->username])}}" >
      @endif  
     
      

      <div class="row">
        <div class="col-12 col-md-6">
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
        <div class="col-12 col-md-6">
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
      </div>

      


      

      <div class="row">
        <div class="col-12 col-md-6">
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
        </div>
        <div class="col-12 col-md-6">
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
        </div>
      </div>
      

      <div class="row">
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
          @if(isset($branches))
      <div class="form-group ">
        <label for="formGroupExampleInput ">Branch</label><br>
        <select class="form-control" name="branches[]">
          @foreach($branches as $b)
          <option value="{{$b->id}}" @if(isset($user)) @if($user->branches->first()) @if($b->id == $user->branches->first()->id ) selected @endif @endif @endif >{{ $b->name }}</option>
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
          <option value="{{$i}}" @if(isset($user))@if($user->details->year_of_passing== $i) selected @endif @endif> {{ $i }}</option>
          @endfor
        </select>
      </div>
        </div>
      </div>
      

      @if(isset($metrics))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput "><h3>Interested Career Path (You can select multiple options)</h3></label><br>
        
        <div class="row">
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="15"> MS in US  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="5"> MBA  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="6"> MTECH  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="8"> Government JOB  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="9"> Software / IT JOB  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="3"> Business <br>
        </div>
      </div>
       
      </div>
      @endif

      @if(isset($metrics))
      <div class="form-group border p-3">
        <label for="formGroupExampleInput "><h3>Skills to Improve (You can select multiple options)</h3></label><br>
        
        <div class="row">
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="12"> Communication  <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="10"> Computer Programming (C/JAVA/SAP) <br>
        </div>
        <div class="col-12 col-md-4">
        <input  type="checkbox" name="metrics[]" value="11"> Graphic Design  <br>
        </div>
      </div>
      </div>
      @endif

      <div class="form-group border bg-light p-3">
        <div class="form-group">
        <label for="formGroupExampleInput ">Referral Code</label>
        <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter Activation Code"  value="{{ \request()->code}}" disabled
            
          >
       
      </div>
      </div>


        @if($stub=='Update')
        <input type="hidden" name="_method" value="PUT">
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="type" value="direct">
      


      <button type="submit" class="btn btn-success btn-lg">Register Now</button>
    </form>
    </div>
  </div>
@endsection