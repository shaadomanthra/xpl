
@extends('layouts.corporate-body')

@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1><i class="fa fa-cart"></i> Checkout</h1><br>

@if(request()->get('package')=='basic')
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Detail</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row" rowspan=2>Basic Package (200 accounts, Unlimited bandwidth, One year validity)</td>
      <td>Installation Fee</td>
      <td><i class="fa fa-rupee"></i> 15,000</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 40,000</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 55,000</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
	<div class="card-body">
		<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
  <label class="form-check-label" for="exampleRadios2">
    Pay by Cheque
  </label>
</div>
	</div>
</div>
@endif

@if(request()->get('package')=='pro')
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Detail</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row" rowspan=2>Pro Package (500 accounts, Unlimited bandwidth, One year validity)</td>
      <td>Installation Fee</td>
      <td><i class="fa fa-rupee"></i> 10,000</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 75,000</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 85,000</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
	<div class="card-body">
		<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
  <label class="form-check-label" for="exampleRadios2">
    Pay by Cheque
  </label>
</div>
	</div>
</div>
@endif

@if(request()->get('package')=='ultimate')
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Detail</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row" rowspan=2>Ultimate Package (1000 accounts, Unlimited bandwidth, One year validity)</td>
      <td>Installation Fee</td>
      <td><i class="fa fa-rupee"></i> 0</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 1,00,000</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 1,00,000</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
	<div class="card-body">
		<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
  <label class="form-check-label" for="exampleRadios2">
    Pay by Cheque
  </label>
</div>
	</div>
</div>
@endif

<a href="{{route('checkout-success')}}"><button class="btn btn-lg btn-primary">Next</button></a>


</div>		
</div>
@endsection           