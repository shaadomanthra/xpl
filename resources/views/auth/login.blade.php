@extends('layouts.client_login')

@section('title', 'Login ')

@section('content')

@include('flash::message')
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

                    @if (session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
@endif
                    
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">Email Address</label>

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
                                <input id="client_slug" type="hidden" class="form-control" name="client_slug" value="{{subdomain()}}">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                @if($_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'gradable.in' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
                  <a class="btn btn-success" href="{{ route('register') }}">
                                    Register
                                </a>
                                <br>
                                @elseif($_SERVER['HTTP_HOST'] == 'fks.xplore.co.in' || $_SERVER['HTTP_HOST'] == 'rguktn.xplore.co.in' || $_SERVER['HTTP_HOST'] == 'rguktrkv.xplore.co.in')
              @else
                                @if(request()->session()->get('settings'))
                                @if(request()->session()->get('settings')->register)
                                 <a class="btn btn-success" href="{{ route('register') }}">
                                                    Register
                                </a>
                                @endif
                                @endif
                                <br>
              @endif
                                
                                 <div class="mt-4">
                                @if(request()->session()->get('settings'))
                                @if(request()->session()->get('settings')->change_password)
                                <a class="" href="{{ route('password.request') }}">
                                     Reset password via email
                                </a>
                                @endif
                                @endif

                                @if($_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'gradable.in' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
                                <a class="" href="{{ route('password.request') }}">
                                     Reset password via email
                                </a>
                                @endif
                                </div>
                             
                                <!--
                                <a class="btn btn-link" href="{{ route('password.forgot') }}">
                                    Recieve password via sms
                                </a>
                            -->
                            </div>
                        </div>
                    </form>
    </p>
  

@endsection
