@extends('layouts.nowrap')

@section('title', 'Login ')

@section('content')
<div class="card">
  <div class="card-header">
    Login
  </div>
  <div class="card-body">
    <p class="card-text">

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
                            <label for="email" class="col-md-12 control-label">E-Mail Address / Username</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="email" placeholder="" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label">Password</label>

                            <div class="col-md-12">
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
                            <div class="col-md-12 col-md-offset-4">
                                
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                @if(subdomain() != 'corporate')
                                <a class="btn btn-success" href="{{ route('register.type') }}">
                                    Sign up
                                </a>
                                <br>
                                @endif
                                
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Reset password via email
                                </a>
                                <!--
                                <a class="btn btn-link" href="{{ route('password.forgot') }}">
                                    Recieve password via sms
                                </a>
                            -->
                            </div>
                        </div>
                    </form>
    </p>
  </div>
</div>

@endsection
