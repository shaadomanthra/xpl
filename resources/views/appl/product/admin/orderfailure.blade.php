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
<h1 class="text-danger"><i class="fa fa-check-circle"></i> Transaction Failure</h1>
<hr>

<p>  This transaction failed . Kindly contact the adminstrator, the contact details are mentioned in this <a href="https://corporate.onlinelibrary.co/contact-corporate">link</a></p>
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

