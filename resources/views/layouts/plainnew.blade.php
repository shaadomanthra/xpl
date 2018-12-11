@extends('layouts.headnew')
@section('content-main')
<div class="wrapper-bg" style="background: linear-gradient(to top, rgba(39, 174, 96,0.7), rgb(35, 111, 177)), url({{asset('img/bg/22.jpg')}}); height: stretch;background-repeat: no-repeat;background-size: auto;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
  <div class="pt-0">   
       <div class="nav-bg p-2" style="background: rgb(35, 111, 177);">
        <div class="wrapper">
        <div id="app ">
            @include('snippets.topmenu')
        </div>
        </div>
        </div> 

    <div style="background:linear-gradient(to top, rgba(22, 160, 133,0.0), rgb(35, 111, 177)); height:100%">
    @yield('content')
</div>
</div>
    </div>
  
</div>
</div>
@endsection

