@extends('layouts.nowrap')

@section('title', 'Forgot Password | PacketPrep')
@section('description', 'Forgot password reset via sms for packetprep')
@section('content')
@include('flash::message') 
<div class="card">
  <div class="card-header">
    <h1>Forgot Password </h1>
  </div>
  <div class="card-body">
    <form class="form-horizontal" method="POST" action="{{ route('password.forgot.send') }}">
    	 {{ csrf_field() }}
    	 <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">Phone number</label>

                            <div class="col-md-12">
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>

    	<div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password via SMS
                                </button>
                            </div>
                        </div>
    </form>
  </div>
</div>

@endsection
