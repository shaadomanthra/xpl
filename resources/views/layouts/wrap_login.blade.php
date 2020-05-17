@extends('layouts.login')
@section('content-main')

    <div class="wrapper ">
      <div class="container" style="padding-top:50px;padding-bottom: 50px;">
        <div class="card">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
        @yield('content')
        </div>
      </div>
      </div>
    </div>
@endsection


  
