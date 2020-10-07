@extends('layouts.nowrap')

@section('title', 'Change Password ')
@section('description', 'Change password for xplore')
@section('content')
@include('flash::message') 
<div class="card">
  <div class="card-header">
    <h1>Change Password </h1>
  </div>
  <div class="card-body">
    <form class="form-horizontal" method="POST" action="{{ route('password.change') }}">
    	 {{ csrf_field() }}
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

            <div class="form-group">
                <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

    	<div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
    </form>
  </div>
</div>

@endsection
