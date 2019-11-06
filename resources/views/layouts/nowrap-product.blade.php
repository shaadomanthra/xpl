@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg p-2 " style="background: #d8d9da;">
        <div class="wrapper ">
            <div id="app" >
            @include('snippets.topmenu')
            </div>
        </div>
    </div>    
    <div> 
    @yield('content')
    </div>       
</div>
@endsection


  
