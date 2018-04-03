@extends('layouts.app')

@section('content')


@include('flash::message')  
<div class="card">

	<div class="card-body">
		<div class="card border mb-4 bg-light">
			  	<div class="card-body">
			  		<h2 class="mb-0"><i class="fa fa-envelope-o"></i> Contact Us</h2>
			  	</div>
			  </div>
		<div class="row">
			<div class="col-md-8">

				
			<form class="mb-5 mb-md-2" method="post" action="{{route('contactform')}}">
			  
			 
			  <div class="form-group row">
			    <label  class="col-sm-3 col-form-label">Name</label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="" name="name" value="{{ (old('name')) ? old('name') : '' }}" placeholder="Enter your name">
			    </div>
			  </div>
			   <div class="form-group row">
			    <label  class="col-sm-3 col-form-label">Email</label>
			    <div class="col-sm-8">
			      <input type="email" class="form-control" id="" name="email" value="{{ (old('email')) ? old('email') : '' }}"placeholder="Enter your email">
			    </div>
			  </div>

			  <div class="form-group row">
			    <label  class="col-sm-3 col-form-label">Subject</label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="" name="subject" value="{{ (old('subject')) ? old('subject') : '' }}" placeholder="Short Description">
			      <input type="hidden" name="_token" value="{{ csrf_token() }}">
			    </div>
			  </div>


			  <div class="form-group row">
			    <label class="col-sm-3 col-form-label">Message</label>
			    <div class="col-sm-8">
			      <textarea class="form-control" name="message" rows="6">{{ (old('message')) ? old('message') : '' }}</textarea>
			    </div>
			  </div>


			  <div class="form-group row">
			    <label  class="col-sm-3 col-form-label"></label>
			    <div class="col-sm-9">
			    	<div class="g-recaptcha mb-3" data-sitekey="6Lc9yFAUAAAAALZlJ3hsqVZQKjOGNIrXezGmawtf"></div>
			      <button class="btn btn-lg btn-outline-info" type="submit" >Send</button>
			    </div>
			  </div>
			  
			</form>

			</div>

			<div class="col-md-4">
				<h3 class="text-secondary mb-3"><i class="fa fa-map-marker"></i> Address</h3>
				<address>
			    <strong>Quedb Edtech Pvt Ltd.</strong><br>
			    12-5-29/1, first floor<br>
			    Tarnaka - Moula Ali Road<br>
			    South Lalaguda, 
			    Hyderabad <br>
			    Telangana - 500017<br>
			    <abbr title="Phone">P:</abbr> +91 86880 79590
			  </address>


			</div>
		</div>
	</div>
	@endsection           