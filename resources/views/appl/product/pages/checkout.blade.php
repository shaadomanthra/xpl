
@extends('layouts.app')

@section('content')

<form method="post" action="{{ route('payment.order')}}">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="bg-white">
<div class="card-body p-4 ">
<h1><i class="fa fa-cart"></i> Checkout</h1><br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row" rowspan=2>{!! $product->description !!}</td>
      <td>{{ $product->price }}</td>
    </tr>
     <tr>
    </tr>
    <tr>

      <td >Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> {{ $product->price }} </span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
  <div class="card-body">
    <div class="form-check mb-2">
    <input class="form-check-input" type="hidden" name="txn_amount" value="{{ $product->price }}">
    <input class="form-check-input" type="hidden" name="product_id"  value="{{ $product->id }}">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="paytm" checked> paytm
 
</div>
<div class="form-check ">
  
 
  </label>
</div>
  </div>
</div>




<button class="btn btn-lg btn-primary" type="submit">Next</button>


</div>		
</div>
</form>
@endsection           