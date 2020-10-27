

<div class="py-4">
    <div class="row">
        <div class="col-12 col-md-4 text-center text-md-left">
    <a class="navbar-brand abs text-center float-md-left" href="{{ url('/dashboard') }}" aria-label="Dashboard">
        <img 
        src="{{ request()->session()->get('client')->logo }} " width="300px" class="ml-md-0"  alt="logo " type="image/png">
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
                <label for="phone" class="col-md-8 control-label">Phone</label>
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

        <div class="col-12 col-md-6">
             <div class="form-group">
        <label for="dob" class="col-md-12 control-label">Date of birth (eg: 25-08-2005) </label>

        <div class="col-md-12">
            <input id="dob" type="text" class="form-control" name="dob" value="{{ old('dob') }}" required>
        </div>
    </div>
        </div>
        <div class="col-12 col-md-6">
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


    


    

    <div class="form-group">
        <div class="col-md-12 col-md-offset-4">
            <button type="submit" class="btn btn-primary btn-lg">
                Register
            </button>
        </div>
    </div>
</form>
