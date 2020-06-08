

<div class="py-4">
    <div class="row">
        <div class="col-12 col-md-4 text-center text-md-left">
    <a class="navbar-brand abs text-center float-md-left" href="{{ url('/dashboard') }}" aria-label="Dashboard">
        <img 
        src="{{ request()->session()->get('client')->logo }} " width="300px" class="ml-md-0"  alt="logo " type="image/png">
    </a>  
    </div>
    <div class="col-12 col-md-4 text-center text-md-center">
        <div class="text-center text-md-center float-md-center mt-3"><h1 class="mb-3">Registration Page</h1></div>
    </div>
    <div class="col-12 col-md-4 text-right text-md-right">
        <div class="text-right text-md-right float-md-right ">
            <img 
        src="{{ asset('img/alphores.jpg') }} " width="100px" class="ml-md-0"  alt="logo " type="image/png" style="margin-top: -10px;">
        </div>
    </div>

    </div>
</div>

@include('flash::message')

<form class="form-horizontal" method="POST" action="{{ route('register.client') }}">


    {{ csrf_field() }}

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-8 control-label">Name</label>

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
                <label for="name" class="col-md-8 control-label">Fathers Name</label>

                <div class="col-md-12">
                    <input id="fathername" type="text" class="form-control" name="fathername" value="{{ old('fathername') }}" required autofocus>

                    @if ($errors->has('fathername'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fathername') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                <label for="gender" class="col-md-8 control-label">Fathers Phone Number</label>

                <div class="col-md-12">
                    <input id="gender" type="text" class="form-control" name="gender" value="{{ old('gender') }}" required autofocus>



                    @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

        </div>

    </div>
    
     <div class="row">
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                <label for="video" class="col-md-8 control-label">Inter/Diploma College Name</label>

                <div class="col-md-12">
                    <input id="video" type="text" class="form-control" name="video" value="{{ old('video') }}" required autofocus placeholder="">

                    @if ($errors->has('video'))
                    <span class="help-block">
                        <strong>{{ $errors->first('video') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('personality') ? ' has-error' : '' }}">
                <label for="personality" class="col-md-8 control-label">Course</label>

                <div class="col-md-12">
                    <select class="form-control" name="personality">
                      <option value="MPC"  >M.P.C</option>
                      <option value="BiPC"  > Bi.P.C</option>
                      <option value="CSE"  > CSE</option>
                      <option value="ECE"  > ECE</option>
                      <option value="EEE"  > EEE</option>
                      <option value="IT"  > IT</option>
                      <option value="MECH"  > MECH</option>
                      <option value="CIVIL"  > CIVIL</option>
                      <option value="OTHER"  > OTHER</option>
                    </select>
                </div>
            </div>

        </div>

         <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('confidence') ? ' has-error' : '' }}">
                <label for="confidence" class="col-md-8 control-label">Secured Marks in First Year</label>

                <div class="col-md-12">
                    <input id="confidence" type="text" class="form-control" name="confidence" value="{{ old('confidence') }}" required autofocus>

                    @if ($errors->has('confidence'))
                    <span class="help-block">
                        <strong>{{ $errors->first('confidence') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

        </div>

    </div>

    

    <div class="row">

        <div class="col-12 col-md-4">
             <div class="form-group">
        <label for="dob" class="col-md-12 control-label">Date of birth (eg: 25-08-2005) </label>

        <div class="col-md-12">
            <input id="dob" type="text" class="form-control" name="dob" value="{{ old('dob') }}" required>
        </div>
    </div>
        </div>
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
             <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        <label for="email" class="col-md-12 control-label">Student Phone Number </label>

        <div class="col-md-12">
            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
            <input id="otp" type="hidden" class="form-control" name="otp" value="{{$code}}" >

            @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
            @endif
        </div>
    </div>

        </div>

    </div>

    <div class="row">
        <div class="col-12 col-md-6">
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
        <div class="col-12 col-md-6">
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
                <label for="phone" class="col-md-8 control-label">Admission Number</label>
                <div class="col-md-12">
                    <input id="address" type="text" class="form-control" name="confidence" value="{{ old('confidence') }}" required>
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">District</label>
                <div class="col-md-12">
                    <input id="address" type="text" class="form-control" name="hometown" value="{{ old('hometown') }}" required>
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-8 control-label">Address</label>
                <div class="col-md-12">
                    <input id="address" type="text" class="form-control" name="current_city" value="{{ old('current_city') }}" required>
                    
                </div>
            </div>

        </div>

    </div>
    


    

    <div class="form-group">
        <div class="col-md-12 col-md-offset-4">
            <button type="submit" class="btn btn-primary btn-lg">
                Register
            </button>
        </div>
    </div>
</form>
