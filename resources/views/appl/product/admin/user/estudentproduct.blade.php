@extends('layouts.app-border')
@section('title', 'Engineering Student Registration  | Xplore')
@section('description', 'Form for engineering students to register to xplore platform')
@section('keywords', 'xplore registration, xplore register, engineering registration xplore')
@section('content')
@include('flash::message')
<div class="card">
  <div class="card-body">
    <div class="bg-light border p-3 mb-3">
      <h1 class="">Engineering Student Registration  </h1>
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
            <label for="formGroupExampleInput2">Email (Only Gmail ID Accepted)</label>
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
              @for($i=2019;$i < 2029;$i++)
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
        <label for="formGroupExampleInput "><h3>Interested Career Path (You can select multiple options)</h3></label><br>
        <div class="row">
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="15"> MS in US or Aborad  <br>
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


      <div class="form-group border p-3">
        <label for="formGroupExampleInput "><h3>Skills to Improve (You can select multiple options)</h3></label><br>
        <div class="row">
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="12"> Communication  <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="10"> Computer Programming (C/JAVA/OTHER) <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="16"> MATLAB <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="17"> AutoCAD <br>
          </div>
          <div class="col-12 col-md-4">
            <input  type="checkbox" name="metrics[]" value="11"> Animation/Design <br>
          </div>
        </div>
      </div>
  
      <div class="form-group border bg-light p-3">
        <div class="form-group">
          <label for="formGroupExampleInput ">Referral Code (Optional)</label>
          <input type="text" class="form-control" name="code" id="formGroupExampleInput" placeholder="Enter Referral Code"  value="{{ (\request()->code)? \request()->code : ''}}">
        </div>
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