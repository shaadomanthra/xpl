@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item">Transactions </li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-12">
 
        <nav class="navbar bg-white justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-shopping-cart"></i> Transactions </a>

          <form class="form-inline" method="GET" action="{{ route('order.transactions') }}">

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
         @include('appl.product.order.newlist')
       </div>

 </div>
</div>

@endsection


