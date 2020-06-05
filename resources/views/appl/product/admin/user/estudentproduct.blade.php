@extends('layouts.app-border')
@section('title', 'Student Registration  | Xplore')
@section('description', 'Form for engineering students to register to xplore platform')
@section('keywords', 'xplore registration, xplore register, engineering registration xplore')
@section('content')
@include('flash::message')
<div class="card">
  <div class="card-body">
    <div class="bg-light border p-3 mb-3">
      <h1 class="">Student Registration  </h1>
    </div>

    <div class="alert alert-warning alert-important" role="alert">
      <h4>Note:</h4>
      <ul>
        <li>You will recieve your password on email. Kindly ensure that you enter the correct email address.</li>
        <li>If you see a message that 'User account exists'. Kindly use the following link to <a href="https://xplore.co.in/password/reset">reset your password</a>.</li>
      </ul>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
    <form method="post" action="{{route('admin.user.studentstore')}}" >
        <div class="row">
          <div class="col-12 col-md-6">
           <div class="form-group">
            <label for="formGroupExampleInput ">Name</label>
            <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter your Name" 
            @if($stub=='Create')
            value="{{ (old('name')) ? old('name') : '' }}"
            @endif>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group ">
            <label for="formGroupExampleInput2">Email</label>
            <input type="text" class="form-control" name="email" id="formGroupExampleInput2" placeholder="Email address"
            @if($stub=='Create')
            value="{{ (old('email')) ? old('email') : '' }}"
            @endif>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">College Roll Number (FULL) </label>
            <input type="text" class="form-control" name="roll_number" id="formGroupExampleInput" placeholder="Enter your Roll Number" 
            @if($stub=='Create')
            value="{{ (old('roll_number')) ? old('roll_number') : '' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Phone </label>
            <input type="number" minlength="1" class="form-control" name="phone" id="formGroupExampleInput" placeholder="Enter your Phone Number" 
            @if($stub=='Create')
            value="{{ (old('phone')) ? old('phone') : '' }}"
            @endif>
          </div>
        </div>
      </div>

       <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Gender </label>
             <select class="form-control" name="gender">
              <option value="male" >Male</option>
              <option value="female" >Female</option>
              <option value="transgender" >Transgender</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Date of Birth(DD-MM-YYYY) </label>
            <input type="text" minlength="1" class="form-control" name="dob" id="formGroupExampleInput" placeholder="Example : 24-06-1999" 
            @if($stub=='Create')
            value="{{ (old('dob')) ? old('dob') : '' }}"
            @endif>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Hometown </label>
            <input type="text" class="form-control" name="hometown" id="formGroupExampleInput" placeholder="Enter your Hometown" 
            @if($stub=='Create')
            value="{{ (old('hometown')) ? old('hometown') : '' }}"
            @endif
            >
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="formGroupExampleInput ">Current City </label>
            <input type="text" minlength="1" class="form-control" name="current_city" id="formGroupExampleInput" placeholder="Enter your Current City" 
            @if($stub=='Create')
            value="{{ (old('current_city')) ? old('current_city') : '' }}"
            @endif>
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
              @if($c->type=='btech')
              <option value="{{$c->id}}"  >{{ $c->name }}</option>
              @endif
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
              @if(in_array($b->name,['CSE','IT','EEE','ECE','MECH','CIVIL','CHEMICAL','OTHER']))
              <option value="{{$b->id}}" >{{ $b->name }}</option>
              @endif
              @endforeach         
            </select>
          </div>
          @endif
        </div>
        <div class="col-12 col-md-4">
          <div class="form-group">
            <label for="formGroupExampleInput ">Year of Passing</label>
            <select class="form-control" name="year_of_passing">
              @for($i=2016;$i < 2029;$i++)
              <option value="{{$i}}" @if($i==2020)  selected @endif > {{ $i }}</option>
              @endfor
            </select>
          </div>
        </div>
      </div>

      <div class="form-group border bg-light p-3">
        <div class="form-group">
          <label for="formGroupExampleInput ">College name, if it is not listed  (Optional)</label>
          <input type="text" class="form-control" name="bio" id="formGroupExampleInput" placeholder="Enter Full College Name"  value="{{ (\request()->bio)? \request()->bio : ''}}">
        </div>
      </div>
      
      


      <div class="form-group border p-3">
            <label for="formGroupExampleInput "><h3>Academics (CGPA or Percentage)</h3></label><br>
          <div class="row">
          <div class="col-12 col-md-6">
            <div class="form-group">
            <label for="formGroupExampleInput ">Class 10th </label>
            <input type="text" minlength="1" class="form-control" name="tenth" id="formGroupExampleInput" placeholder="Enter CGPA or Percentage" 
            @if($stub=='Create')
            value="{{ (old('tenth')) ? old('tenth') : '' }}"
            @endif>
          </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
            <label for="formGroupExampleInput ">Class 12th </label>
            <input type="text" minlength="1" class="form-control" name="twelveth" id="formGroupExampleInput" placeholder="Enter CGPA or Percentage" 
            @if($stub=='Create')
            value="{{ (old('twelveth')) ? old('twelveth') : '' }}"
            @endif>
          </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
            <label for="formGroupExampleInput ">Btech/Degree </label>
            <input type="text" minlength="1" class="form-control" name="bachelors" id="formGroupExampleInput" placeholder="Enter CGPA or Percentage" 
            @if($stub=='Create')
            value="{{ (old('bachelors')) ? old('bachelors') : '' }}"
            @endif>
          </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
            <label for="formGroupExampleInput ">Masters(Optional) </label>
            <input type="text" minlength="1" class="form-control" name="masters" id="formGroupExampleInput" placeholder="Enter CGPA or Percentage" 
            @if($stub=='Create')
            value="{{ (old('masters')) ? old('masters') : '' }}"
            @endif>
          </div>
          </div>
          
        </div>

      </div>

      <div class="form-group border p-3">
        <label for="formGroupExampleInput "><h3>Trained in</h3></label><br>
        <div class="row">
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="18"> C   <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="19"> C++  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="20"> JAVA  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="21"> DotNET  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="22"> Python  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="23"> SQL <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="24"> PHP <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="25"> Networking <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="26"> AutoCAD <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="27"> Catia <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="28"> Ansys <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="29"> Solidworks <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="30"> Matlab <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="31"> Arduino <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="32"> Raspberry Pi <br>
          </div>
        </div>
      </div>

      <div class="pt-3 pb-3">
      <div class="g-recaptcha mb-3" data-sitekey="6Lc9yFAUAAAAALZlJ3hsqVZQKjOGNIrXezGmawtf"></div>
      </div>
  
      @if($stub=='Update')
      <input type="hidden" name="_method" value="PUT">
      @endif
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" value="{{ $user->id }}">
      <input type="hidden" name="type" value="direct">
      <input type="hidden" name="coll" value="engg">
      <button type="submit" class="btn btn-success btn-lg">Register Now</button>
    </form>
  </div>
</div>
@endsection