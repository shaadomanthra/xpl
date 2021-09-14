

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
<div class="py-4">
    <div class="row">
        <div class="col-12 col-md-4 text-center text-md-left">
    <a class="navbar-brand abs text-center float-md-left" href="{{ url('/dashboard') }}" aria-label="Dashboard">
        <img 
        src="{{ request()->session()->get('client')->logo }} " width="80px" class="ml-md-0"  alt="logo " type="image/png">
    </a>  
    </div>
    <div class="col-12 col-md-6 text-center text-md-left">
        <div class="text-center text-md-left float-md-right mt-3"><h1>Registration Page</h1></div>
    </div>

    </div>
</div>


@include('flash::message')

<form class="form-horizontal" method="POST" action="{{ route('register.client') }}">


    {{ csrf_field() }}

    <div class="alert alert-primary alert-important py-4">
    <p class="px-3">Verification of phone number is mandatory. Kindly enter the correct 10 digit phone number to complete the registration.</p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">Student Phone</label>
                <div class="col-md-12">
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Enter your 10 digit phone number">
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
            <button type="button" class="btn btn-outline-primary sendsms" data-url="{{ route('register.sendotp')}}" data-code="{{$code}}" data-token="{{ csrf_token() }}">
                Send OTP
            </button>
            </div>
             
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                <label for="otp" class="col-md-8 control-label">OTP</label>
                <div class="col-md-12">
                    <input id="phone" type="text" class="form-control" name="otp" value="{{ old('otp') }}" required placeholder="Enter otp sent to your phone number">
                </div>
            </div>
            <div class="col-md-12">
            <button type="button" class="btn btn-success verifycode" data-code="{{$code}}" >
                Verify 
            </button>
            </div>

        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-8 control-label">Student Name</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name">

                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('father-name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-8 control-label">College Name</label>

                <div class="col-md-12">
                      <select name="college_id" class="form-control">
                        @foreach($colleges as $college)
                        <option value="{{$college->id}}">{{$college->name}}</option>
                        @endforeach
                    </select>
   
                </div>
            </div>

        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                <label for="branch" class="col-md-8 control-label">Branch</label>

                <div class="col-md-12">
                     <select name="branch_id" class="form-control">
                        @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

    </div>
    
     <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                <label for="video" class="col-md-8 control-label">Year of Passing</label>

                 <div class="col-md-12">
                     <select name="yop" class="form-control">
                        @foreach([2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030] as $yop)
                        <option value="{{$yop}}">{{$yop}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('confidence') ? ' has-error' : '' }}">
                <label for="confidence" class="col-md-8 control-label">Roll Number</label>

                <div class="col-md-12">
                    <input id="confidence" type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}" required autofocus>
                </div>
            </div>

        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                <label for="gender" class="col-md-8 control-label">Gender</label>

                <div class="col-md-12">
                     <select name="gender" class="form-control">
                        @foreach(['male','female','transgender'] as $yop)
                        <option value="{{$yop}}">{{$yop}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

    </div>

    



    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-12 control-label">E-Mail Address </label>

        <div class="col-md-12">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-8 control-label">Password</label>

            <div class="col-md-12">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
           <div class="form-group">
        <label for="password-confirm" class="col-md-8 control-label">Confirm Password</label>

        <div class="col-md-12">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>
    </div>

        </div>

    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">State</label>
                <div class="col-md-12">
                   <select name="personality" class="form-control">
                        @foreach($states as $st=>$state)
                        <option value="{{$st}}">{{$state}}</option>
                        @endforeach
                    </select>
   
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">Current City</label>
                <div class="col-md-12">

                   <select name="current_city" class="form-control">
                        @foreach($cities as $state)
                        <option value="{{$state}}">{{$state}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('hometown') ? ' has-error' : '' }}">
                <label for="hometown" class="col-md-8 control-label">Hometown</label>
                <div class="col-md-12">

                    <input id="hometown" type="text" class="form-control" name="hometown" value="{{ old('hometown') }}" >
                    
                </div>
            </div>

        </div>

    </div>

        <div class="row bg-light mx-3">

        <div class="col-12 alert alert-warning alert-important">The academic percentage has to be between 30 to 100. If your university awards CPGA, then convert it to percentage and then enter. <br><b>Eg:</b> For 7.2 CGPA, you can enter 72.
         </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
            <label for="dob" class="col-md-12 control-label">Class 10th Percentage</label>

                <div class="col-md-12">
                    <input id="tenth" type="text" class="form-control" name="tenth" value="{{ old('tenth') }}" min="30" max="100" required>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
            <label for="dob" class="col-md-12 control-label">Class 12th Percentage</label>

                <div class="col-md-12">
                    <input id="tenth" type="text" class="form-control" name="twelveth" value="{{ old('twelveth') }}" min="30" max="100" required>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
            <label for="dob" class="col-md-12 control-label">Graduation Percentage</label>

                <div class="col-md-12">
                    <input id="tenth" type="text" class="form-control" name="bachelors" value="{{ old('bachelors') }}" min="30" max="100" required>
                </div>
            </div>
        </div>
     


    </div>
    
   

    

    <div class="form-group mt-4">
        <div class="col-md-12 col-md-offset-4">
            <button type="submit" class="btn btn-primary btn-lg">
                Register
            </button>
        </div>
    </div>
</form>
