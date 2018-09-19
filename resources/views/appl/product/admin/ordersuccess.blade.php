@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item">Buy Credits</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        

        <div class="card mb-3">
      <div class="card-body">
        <h1 class="text-success"><i class="fa fa-check-circle"></i> Success</h1>
<hr>

<p> Your transaction with Order Number <b>{{ $order->order_id }}</b> was successful. <br>Your Account has been credited with <b>{{ $order->credit_count }}</b> credit points.<hr>
In case of any query contact the adminstrator, the contact details are mentioned in this <a href="https://corporate.onlinelibrary.co/contact-corporate">link</a></p>
        </div>
      </div>

        

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>

@endsection

