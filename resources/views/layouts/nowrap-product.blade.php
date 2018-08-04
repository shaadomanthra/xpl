@extends('layouts.head')
@section('content-main')
    <div class="wrapper-bg ">
    <div class="nav-bg-dark">
        <div class="wrapper ">
        <div id="app ">
            @include('snippets.topmenu-product')
        </div>
        </div>
    </div>    
      
      <div style="background:#ECF0F1"> 
    @yield('content')
</div>
       
    </div>
@endsection


  
