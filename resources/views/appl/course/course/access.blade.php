@extends('layouts.app')

@section('title', 'Restricted Access to Content | Xplore')
@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
    <h1 class="display-2"> <div class=""><i class="fa fa-exclamation-triangle"></i> Restricted Access </div></h1>
    <p>  Kindly buy the product to access further. If the product is FREE, kindly click the button 'ACCESS' on the homepage of the course/test to continue further.</p>
    <p>
    </p>
    <a href="{{ url()->previous() }}"><button class="btn btn-success">Back</button></a>
  </div>



</div>    
</div>
@endsection           