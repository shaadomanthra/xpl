@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg" style="background: white">
    <div class="nav-bg p-2 " style="background: #fff;">
        <div class="wrapper ">
            <div id="app" >
            @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com')
                @include('snippets.topmenu-pp')
            @else
                @include('snippets.topmenu')
            @endif
            </div>
        </div>
    </div>    
    <div> 
    @yield('content')
    </div>       
</div>
@endsection


  
