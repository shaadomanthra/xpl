@extends('layouts.headnew')
@section('content-main')
<div class="wrapper-bg" style="background: white">
    <div class="nav-bg p-1 bg1" ></div>    
    <div class="wrapper margintop-20 ">
        <div class="container">    
            @yield('content')
        </div><br>  
    </div>       
</div>
@endsection


  
