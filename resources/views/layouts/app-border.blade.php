@extends('layouts.head-noscript')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg p-1 bg1" ></div>    
    <div class="wrapper margintop-20 ">
        <div class="container">    
            @yield('content')
        </div><br>  
    </div>       
</div>
@endsection


  
