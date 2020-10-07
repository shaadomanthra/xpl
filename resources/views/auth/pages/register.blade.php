
<div class="container" >
<div class="bg-white border rounded p-4 p-md-5">

	<form class=" " method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
	<div class="row">
		<div class="col-12">
			@include('flash::message')
			<img 
          src="{{ asset('img/xplore.png') }} " width="100px" class=" float-right"  alt="Xplore logo " type="image/png">
		<h1>Register</h1>
		<!--
		<div class="alert alert-primary alert-important py-4 mt-3">
		    <p class="px-3">Verification of phone number is mandatory. Kindly enter the correct 10 digit phone number to complete the registration.</p>
		    <div class="row">
		        <div class="col-12 col-md-6">
		            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
		                <label for="phone" class="col-md-8 control-label">Phone</label>
		                <div class="col-md-12">
		                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Enter your 10 digit phone number">
		                    @if ($errors->has('phone'))
		                    <span class="help-block text-danger">
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
		                @if ($errors->has('otp'))
		                    <span class="help-block  text-danger">
		                        <strong>{{ $errors->first('otp') }}</strong>
		                    </span>
		            @endif
		            </div>
		            <div class="col-md-12">
		            <button type="button" class="btn btn-success verifycode" data-code="{{$code}}" >
		                Verify 
		            </button>
		            </div>
		            
		        </div>
    		</div>
			</div> -->

			<div class="alert alert-warning alert-important" role="alert">
      
      <p class="mb-0"><b>Note:</b>If you see a message that 'The email has already been taken'. Kindly use the following link to <a href="https://xplore.co.in/password/reset">reset your password</a></p>
</div>
		</div>
	</div>

	<div class="row">
    	<div class="col-12 col-md-6">
    		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    			<label for="name" class="col-md-8 control-label">Name</label>

    			<div class="col-md-12">
    				<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

    				@if ($errors->has('name'))
    				<span class="help-block text-danger">
    					<strong>{{ $errors->first('name') }}</strong>
    				</span>
    				@endif
    			</div>
    		</div>
    	</div>
    	<div class="col-12 col-md-6">
    		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    			<label for="email" class="col-md-12 control-label">E-Mail Address</label>

    			<div class="col-md-12">
    				<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

    				@if ($errors->has('email'))
    				<span class="help-block text-danger">
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
				<label for="password" class="col-md-12 control-label">Password</label>

				<div class="col-md-12">
					<input id="password" type="password" class="form-control" name="password" required>

					@if ($errors->has('password'))
					<span class="help-block text-danger">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
				</div>
			</div>
    	</div>
    	<div class="col-12 col-md-6">
    		<div class="form-group">
    			<label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

    			<div class="col-md-12">
    				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    			</div>
    		</div>
    	</div>

    	<div class="col-12 col-md-6">
			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="phone" class="col-md-12 control-label">Phone</label>

				<div class="col-md-12">
					<input id="phone" type="text" class="form-control" name="phone" required>

					@if ($errors->has('phone'))
					<span class="help-block text-danger">
						<strong>{{ $errors->first('phone') }}</strong>
					</span>
					@endif
				</div>
			</div>
    	</div>

    </div>
    <input id="phone" type="hidden" class="form-control" name="otp" value="{{$code}}" required placeholder="Enter otp sent to your phone number">
                        
    <div class="row">
    	<div class="col-12">
    		<div class="form-group">
    			<div class="col-md-12 col-md-offset-4">
    				<button type="submit" class="btn btn-primary">
    					Register
    				</button>
    			</div>
    		</div>
    	</div>	
    </div>	
               
</form>
    
</div>
</div>

