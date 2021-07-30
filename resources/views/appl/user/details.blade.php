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

  

<form class="form-horizontal" method="POST" action="{{ route('profile.details') }}">


    {{ csrf_field() }}



    <div class="row no-gutters mt-4">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-10 control-label">Student Name</label>

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
                <label for="name" class="col-md-10 control-label">Student Phone Number</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="phone" value="{{$user->phone}}" >
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('father-name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-8 control-label">Parent Name</label>

                <div class="col-md-12">
                    <input id="fathername" type="text" class="form-control" name="roll_number" value="{{$user->roll_number}}" required>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                <label for="gender" class="col-md-8 control-label">Parent Profession</label>

                <div class="col-md-12">
                    <input id="gender" type="text" class="form-control" name="fluency" value="{{$user->fluency}}" required autofocus>

                </div>
            </div>

        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                <label for="gender" class="col-md-8 control-label">Parent Phone Number</label>

                <div class="col-md-12">
                    <input id="gender" type="text" class="form-control" name="gender" value="{{$user->gender}}" required autofocus>

                </div>
            </div>

        </div>
         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                <label for="video" class="col-md-8 control-label">Inter College Name</label>

                <div class="col-md-12">
                    <input id="video" type="text" class="form-control" name="video" value="{{ $user->video }}" required autofocus placeholder="">
                </div>
            </div>
        </div>
         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('personality') ? ' has-error' : '' }}">
                <label for="personality" class="col-md-8 control-label">Inter Course</label>

                <div class="col-md-12">
                    <select class="form-control" name="personality">
                      <option value="MPC"  @if($user->personality=='MPC') selected @endif >M.P.C</option>
                      <option value="BiPC"  @if($user->personality=='BiPC') selected @endif > Bi.P.C</option>
                      <option value="OTHER"  @if($user->personality=='OTHER') selected @endif > OTHER</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('confidence') ? ' has-error' : '' }}">
                <label for="confidence" class="col-md-8 control-label">Total Inter marks/GPA</label>

                <div class="col-md-12">
                    <input id="confidence" type="text" class="form-control" name="confidence" value="{{ $user->confidence }}" >
                </div>
            </div>

        </div>

        <div class="col-12 col-md-4">
             <div class="form-group">
              <label for="dob" class="col-md-12 control-label">Date of Birth (eg: 25-08-2005) </label>

              <div class="col-md-12">
                  <input id="dob" type="text" class="form-control" name="dob" value="{{ $user->dob }}" required>
              </div>
          </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">District</label>
                <div class="col-md-12">
                    <select name="hometown" class="form-control">
                        <option value="Adilabad" @if($user->hometown=='Adilabad') selected @endif>Adilabad</option>
                        <option value="Komaram Bheem Asifabad" @if($user->hometown=='Komaram Bheem Asifabad') selected @endif>Komaram Bheem Asifabad</option>
                        <option value="Bhadradri Kothagudem" @if($user->hometown=='Bhadradri Kothagudem') selected @endif>Bhadradri Kothagudem</option>
                        <option value="Jayashankar Bhupalpally" @if($user->hometown=='Jayashankar Bhupalpally') selected @endif>Jayashankar Bhupalpally</option>
                        <option value="Jogulamba Gadwal" @if($user->hometown=='Jogulamba Gadwal') selected @endif>Jogulamba Gadwal</option>
                        <option value="Hyderabad"  @if($user->hometown=='Hyderabad') selected @endif>Hyderabad</option>
                        <option value="Jagtial" @if($user->hometown=='Jagtial') selected @endif>Jagtial</option>
                        <option value="Jangaon" @if($user->hometown=='Jangaon') selected @endif>Jangaon</option>
                        <option value="Kamareddy" @if($user->hometown=='Kamareddy') selected @endif>Kamareddy</option>
                        <option value="Karimnagar" @if($user->hometown=='Karimnagar') selected @endif>Karimnagar</option>
                        <option value="Khammam" @if($user->hometown=='Khammam') selected @endif>Khammam</option>
                        <option value="Mahabubabad" @if($user->hometown=='Mancherial') selected @endif>Mahabubabad</option>
                        <option value="Mancherial" @if($user->hometown=='Adilabad') selected @endif>Mancherial</option>
                        <option value="Medak" @if($user->hometown=='Medak') selected @endif>Medak</option>
                        <option value="Medchal" @if($user->hometown=='Medchal') selected @endif>Medchal</option>
                        <option value="Nalgonda" @if($user->hometown=='Nalgonda') selected @endif>Nalgonda</option>
                        <option value="Nagarkurnool" @if($user->hometown=='Nagarkurnool') selected @endif>Nagarkurnool</option>
                        <option value="Nirmal" @if($user->hometown=='Nirmal') selected @endif>Nirmal</option>
                        <option value="Nizamabad" @if($user->hometown=='Nizamabad') selected @endif>Nizamabad</option>
                        <option value="Peddapalli" @if($user->hometown=='Peddapalli') selected @endif>Peddapalli</option>
                        <option value="Ranga Reddy" @if($user->hometown=='Ranga Reddy') selected @endif>Ranga Reddy</option>
                        <option value="Rajanna Sircilla" @if($user->hometown=='Rajanna Sircilla') selected @endif>Rajanna Sircilla</option>
                        <option value="Sangareddy" @if($user->hometown=='Sangareddy') selected @endif>Sangareddy</option>
                        <option value="Siddipet" @if($user->hometown=='Siddipet') selected @endif>Siddipet</option>
                        <option value="Suryapet" @if($user->hometown=='Suryapet') selected @endif>Suryapet</option>
                        <option value="Siddipet" @if($user->hometown=='Siddipet') selected @endif>Siddipet</option>
                        <option value="Vikarabad" @if($user->hometown=='Vikarabad') selected @endif>Vikarabad</option>
                        <option value="Wanaparthy" @if($user->hometown=='Wanaparthy') selected @endif>Wanaparthy</option>
                        <option value="Warangal (urban)" @if($user->hometown=='Warangal (urban)') selected @endif>Warangal (urban)</option>
                        <option value="Warangal (rural)" @if($user->hometown=='Warangal (rural)') selected @endif>Warangal (rural)</option>
                        <option value="Yadadri Bhuvanagiri" @if($user->hometown=='Yadadri Bhuvanagiri') selected @endif>Yadadri Bhuvanagiri</option>
                        <option value="OTHER" @if($user->hometown=='OTHER') selected @endif>Other</option>
                    </select>
   
                    
                </div>
            </div>
        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">Mandal</label>
                <div class="col-md-12">

                    <input id="address" type="text" class="form-control" name="current_city" value="{{$user->current_city }}" >
                    
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