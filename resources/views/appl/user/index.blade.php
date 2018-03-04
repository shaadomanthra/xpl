@extends('layouts.app')
@section('content')

<div  class="row ">

  <div class="col">

    @include('flash::message')  
    <div class="card">
      <div style="height:150px;background: linear-gradient(70deg,#2f82ca, #019875);"></div>
      <div class="card-body ">
        <div class="text-center" style="margin-top: -100px;height:180px">
          <img class="img-thumbnail rounded-circle mb-3"src="{{ Gravatar::src($user->email, 150) }}">
        </div>
      <div class="text-center">
       <h2 class="name text-primary">{{ $user->name }} </h2>
       <h4 class="text-secondary">Founder - Packetprep</h4>
       <div><i class="fa fa-facebook-square"></i> <i class="fa fa-twitter-square"></i> </div>
       <p class="mt-3">- Bio not updated - </p>
      </div>
     </div>
   </div>
 </div>
</div>

@endsection


