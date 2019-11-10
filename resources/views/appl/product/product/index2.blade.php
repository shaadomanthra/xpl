@extends('layouts.app')
@section('content')

@section('title', 'Products | Xplore')

@section('description', 'This page lists the products and services sold by packetprep')

@section('keywords', 'packetprep products')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Products</li>
  </ol>
</nav>

@include('flash::message')
<div  class="row ">

  <div class="col-12 ">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0  ">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3 rounded">
          <a class="navbar-brand"><i class="fa fa-inbox"></i> Products </a>

          
          <form class="form-inline" method="GET" action="{{ route('products') }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

        <div id="search-items">
         @include('appl.product.product.list2')
       </div>

     </div>
   </div>
 </div>
 
</div>

@endsection


