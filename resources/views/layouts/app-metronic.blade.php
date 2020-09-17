@extends('layouts.metronic')
@section('content-main')
<div class="@if(!isset($active)) container @else px-5 @endif">
    @yield('content') 
</div>
@endsection


  
