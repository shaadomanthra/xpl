@extends('layouts.app')

@section('content')


<div class="bg-white">
<div class="bg-light border p-3">
 
  <div class="p-2">
    <h1 class="display-2"> <div class=""><i class="fa fa-exclamation-triangle"></i> No Access </div></h1>
    <p> Kindly contact your administrative team for the content access</p>
    <p>
  {!! subdomain_contact() !!}
    </p>
    <a href="{{ url()->previous() }}"><button class="btn btn-primary">Back</button></a>
  </div>



</div>    
</div>
@endsection           