@extends('layouts.head')
@section('content-main')
    <div class="wrapper-bg ">
    <div class="nav-bg">
        <div class="wrapper">
        <div id="app ">
            @include('snippets.topmenu-product')
        </div>
        </div>
    </div>    
       
    @yield('content')
       
    </div>
@endsection


  
