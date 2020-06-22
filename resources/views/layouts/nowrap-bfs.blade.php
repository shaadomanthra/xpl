@extends('layouts.head')
@section('content-main')
<div class="wrapper-bg" style="">
   
    @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
    <div class="line" style="padding:1px;background:#ebf1fb"></div>  
    @elseif($_SERVER['HTTP_HOST'] == 'bfs.piofx.com' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test')

    @else
    <div class="line" style="padding:1px;background:#f8f8f8"></div> 
    @endif
    <div> 
    @yield('content')
    </div>       
</div>
@endsection


  
