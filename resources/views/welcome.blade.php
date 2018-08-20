@extends('layouts.nowrap-product')

@section('content')


<div class="container">
<div class="bg-light mt-4 p-4">
<h1 class="mt-2 mb-4 mb-md-2">
			<img src="{{asset('img/logo_sample.png')}}" width="100px" >
       &nbsp;  Pragathi Degree College


			</h1>

</div>
<div class="mb-4  bg-white ">

	<div class="row">
		<div class="col-md-7 ">
			@if(auth::user())
			<div class="row mt-2 ">
				<div class="col-12 col-md-3">
					<img class="img-thumbnail rounded-circle mb-3" src="{{ Gravatar::src(auth::user()->email, 140) }}">
				</div>
				<div class="col-12 col-md-9">

					<h2>Hi, {{ auth::user()->name}}</h2>
			<p> Welcome aboard</p>

			<p class="lead">We are here to make the learning simple, interesting and effective.</p>

			
			<a class="btn border border-success text-success mt-2" href="{{ route('logout') }}" onclick="event.preventDefault();
			document.getElementById('logout-form').submit();" role="button">Logout</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>

				</div>
			</div>
            
             
			
			@else

			
			

			<div class="p-4 mt-4">
				
				 @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-6 control-label">E-Mail Address / Username</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="email" placeholder="" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>

			
		</div>
			@endif

		</div>
		<div class="col-md-5 d-none d-md-block">
			<div class="text-center mt-0 mt-mb-0">
				<img src="{{ asset('/img/678.jpg')}}" width="380px"/>
			</div>
		</div>
	</div>
</div>

@if(auth::user())
<div class="row ">
	
	<div class="col-12 col-md-6 ">
		<div class="card mb-4 mr-md-1" style="min-height:220px;">
			<div class="card-body bg-light">
				<div class="row no-gutter">
					<div class="col-6">
						<h2>Vision</h2> 
						<p class="mb-0">
							To create a world-class learning platform for self study
						</p>
					</div>
					<div class="col-6">
						<h2>Mission</h2> 
						<p class="mb-0">
							To develop comprehensive content that makes learning simple, interesting and effective. 
						</p>

					</div>
				</div>
			</div>
		</div> 
	</div>
	<div class="col-12 col-md-6">
		<div class="card mb-md-3" style="min-height:220px;">
			<div class="card-body bg-success text-white">
				<h2><b>Prime Goals</b></h2>
				<p class="mb-0 pb-0">
					<ol class="mb-0 pb-0">
						@if(isset($goals))
						@foreach($goals as $goal)
						<li>{{ $goal->title }} <span class="s15 " style="color:rgb(37, 128, 102)">by {{\carbon\carbon::parse($goal->end_at)->format('M d Y')}}</span></li>
						@endforeach
						@endif
					</ol>
				</p>
			</div>
		</div>
	</div>
</div>

@endif

</div>

</div>
@endsection           