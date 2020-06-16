

@extends('layouts.app')
@section('title','User Verification - First Academy' )
@section('keywords', '')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1 class=""><i class="fa fa-code"></i> Notification</h1>
<hr>

<p>  {{$message}}</p>

@if(\auth::user())
<a href="{{ route('home') }}">
<button class="btn btn-primary btn-lg">Dashboard</button>
</a>
@else
<a href="{{ route('login') }}">
<button class="btn btn-primary btn-lg">Login</button>
</a>
@endif

</div>
</div>
@endsection