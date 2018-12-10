@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">User Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.view',$user->username) }}"> {{ $user->name }}</a> </li>
    <li class="breadcrumb-item"> Add Product </li>
  </ol>
</nav>

@include('flash::message')
  <div class="card">
    <div class="card-body">
      <h1 class="bg-light border p-3 mb-3">
        Add Product
       </h1>
      
      <form method="post" action="{{route('admin.user.product',$user->username)}}" >
      
      <div class="form-group">
        <label for="formGroupExampleInput ">Product</label>
        <select class="form-control course_data" name="product_id">
          <option value="-1" >All</option>
          @foreach($products as $product)
          <option value="{{$product->id}}" >{{$product->name}}</option>
          
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Status</label>
        <select class="form-control course_data" name="status">
          <option value="1" >Enable</option>
          <option value="0" >Disable</option>
        </select>
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Validity</label>
        <select class="form-control validity_data" name="validity">
          <option value="1" >1 month</option>
          @for($i=2;$i < 24;$i++)
          <option value="{{$i}}">{{$i}} months</option>
          @endfor
           <option value="24" selected>24 months</option>
        </select>
        
    
      </div>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" value="{{ $user->id }}">

      <button type="submit" class="btn btn-primary">Confirm Addition</button>
      
    </form>
    </div>
  </div>

@endsection