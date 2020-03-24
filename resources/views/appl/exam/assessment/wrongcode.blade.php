@extends('layouts.app-border')

@section('title', 'Restricted Access to Content | Xplore')
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
    <h1 class="display-2"> <div class=""><i class="fa fa-exclamation-triangle"></i> Invalid Code <span class="badge badge-info">{{ $code}}</span> </div></h1>
    <p>  The given code is not valid. Kindly contact the administrator for queries.</p>
    <p>
    </p>
    <a href="{{ url()->previous() }}"><button class="btn btn-success">Back</button></a>
  </div>



</div>    
</div>
@endsection           