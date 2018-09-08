@extends('layouts.head')
@section('content-main')
    <div class="wrapper-bg wrapper-bg-3">
    <div class="nav-bg-black">
        <div class="wrapper ">
        <div id="app " class="p-2">
            @include('snippets.topmenu-product')
        </div>
        </div>
    </div>    
      
    
    <div class="container"> 
    <div class="m-0 mt-3 m-md-4 mt-md-0 ">
    @yield('content')
    </div>
    </div>
       
    </div>
@endsection


  
