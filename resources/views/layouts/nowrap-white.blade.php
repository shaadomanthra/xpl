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
    @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com')
    <div class="line" style="padding:1px;background:#ebf1fb"></div>  
    @else
    <div class="line" style="padding:1px;background:#eee"></div> 
    @endif
    <div> 
    @yield('content')
    </div>       
</div>
@endsection


  
