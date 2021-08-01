@extends('layouts.app')
@section('title', 'My Details')
@section('content')

<div class="card mb-3">
  <div class="card-body bg-light ">
    <h1> Update My Details </h1>
  </div>
  </div>
<div class="bg-white p-3 border rounded">
  
@include('flash::message')

  

<form class="form-horizontal" method="POST" action="{{ route('profile.mydetails') }}">


    {{ csrf_field() }}



    <div class="row no-gutters mt-4">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-10 control-label">Name</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}" required autofocus placeholder="Enter your full name">
                </div>
            </div>
        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-10 control-label">Email Address</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="email" value="{{$user->email}}" disabled="">
                      <input id="name" type="hidden" class="form-control" name="email" value="{{$user->email}}" >
                        <input id="name" type="hidden" class="form-control" name="update" value="1" >
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-10 control-label">Info</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="info" value="{{$user->info}}" disabled="">
                        <input id="name" type="hidden" class="form-control" name="info" value="{{$user->info}}" disabled="">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-10 control-label">Phone Number</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="phone" value="{{$user->phone}}" >
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('father-name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-8 control-label">Roll Number</label>

                <div class="col-md-12">
                    <input id="fathername" type="text" class="form-control" name="roll_number" value="{{$user->roll_number}}" required>
                </div>
            </div>

        </div>
       
         

        

    </div>
    
    

    


    

    <div class="form-group mt-3">
        <div class="col-md-12 col-md-offset-4">
            <button type="submit" class="btn btn-primary btn-lg">
                Update
            </button>
            <a href="{{route('dashboard')}}" class="btn btn-outline-primary btn-lg ml-2"> back to Dashboard</a>
        </div>
    </div>
</form>


</div>
@endsection