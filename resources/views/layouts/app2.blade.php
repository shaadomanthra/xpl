@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg pt-2 pb-2" style="background: #fff;">
        <div class="wrapper ">
            <div id="app " >
            @include('snippets.topmenu')
            </div>
        </div>
    </div>    
    <div class="">
            @yield('content')
    </div>  
</div>
@endsection


  
