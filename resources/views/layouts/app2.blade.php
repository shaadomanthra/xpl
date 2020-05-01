@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg pt-2 pb-2" style="background: #fff;">
        <div class="wrapper ">
            <div id="app " >
            @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
                @include('snippets.topmenu-pp')

            @elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' )
                @include('snippets.topmenu')
            @else
                @include('snippets.topmenu_client')
            @endif
            </div>
        </div>
    </div>    
    <div class="">
            @yield('content')
    </div>  
</div>
@endsection


  
