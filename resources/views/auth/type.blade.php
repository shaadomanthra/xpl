@extends('layouts.nowrap')

@section('title', 'Register Type ')
@section('description', 'Different registration types for the xplore users.')
@section('content')

<div class="card">
  <div class="card-header">
    <h1>Registration Type</h1>
  </div>
  <div class="card-body">
    <a href="{{ route('student.eregister')}}"><button class="btn btn-lg btn-primary">Engineering Student Registration</button></a><br><br>
    <a href="{{ route('register')}}"><button class="btn btn-lg btn-secondary">General Registration</button></a>
  </div>
</div>

@endsection
