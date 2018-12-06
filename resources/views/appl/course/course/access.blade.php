@extends('layouts.app')

@section('content')


<div class="bg-white">
<div class="bg-white border p-3">
 
  <div class="p-2">
    <h1 class="display-2"> <div class=""><i class="fa fa-exclamation-triangle"></i> Restricted Access </div></h1>
    <p> The content you want to access is under premium package. Kindly buy the product to access further.<br> </p>
    <p>
    </p>
    <a href="{{ url()->previous() }}"><button class="btn btn-success">Back</button></a>
  </div>



</div>    
</div>
@endsection           