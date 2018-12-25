@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg p-2 bg1">
        <div class="wrapper ">
            <div id="app " >
            @include('snippets.topmenu')
            </div>
        </div>
    </div>    
      
    <div> 
    @yield('content')
    </div>   
</div>
@endsection


  
