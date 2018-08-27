@extends('layouts.head')
@section('content-main')
    <div class="wrapper-bg wrapper-bg-3">
    <div class="nav-bg-silver">
        <div class="wrapper ">
        <div id="app " class="p-2">
            @include('snippets.topmenu-product')
        </div>
        </div>
    </div>    
      
      <div > 
    @yield('content')
</div>
       
    </div>
@endsection


  
