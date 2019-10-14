
@extends('layouts.app')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class="text-primary"><i class="fa fa-check-circle"></i> Registration Successful !</h1>
<hr>

<p>  You will recieve your login details through email. If you dont recieve login details on email then kindly check SPAM FOLDER, also you can use the following link to recieve the password on sms <a href="https://packetprep.com/user/password/forgot"> https://packetprep.com/user/password/forgot</a> <br><hr>In case of any error, kindly contact the adminstrator, the contact details are mentioned in this <a href="{{ route('contact-corporate')}}">link</a></p>

<a href="{{ route('login')}}">
	<button class="btn btn-lg btn-success"> Login Now</button>
</a>
</div>
</div>
@endsection