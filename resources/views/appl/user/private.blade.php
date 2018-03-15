@extends('layouts.app')
@section('content')

<div  class="row ">
  <div class="col">
   <div class="card">
    <div class="card-body">
      <h1> {{'@'.$user->username}}</h1>
      Private Profile 
    </div>
   </div>
 </div>
</div>

@endsection


