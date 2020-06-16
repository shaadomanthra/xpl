@extends('layouts.nowrap-product')
@section('title', $user->name.' - Validation')
@section('content')

@include('flash::message')  

<div class="container">
  <h1 class="my-3">Validation</h1>
  <div  class="row ">
    <div class="col-12 col-md-6">
      <div class="card mb-4">
        <div class="card-body">
          Email Verification
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
    </div>
  </div>
</div>
@endsection


