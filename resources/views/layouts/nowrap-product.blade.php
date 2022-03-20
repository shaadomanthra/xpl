@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg">
    <div class="nav-bg p-2 " style="background: #fff;box-shadow: 1px 1px 2px silver;">
        <div class="wrapper ">
            <div id="app" >
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
    <div> 
    @yield('content')
    </div>       
</div>
@endsection


  
