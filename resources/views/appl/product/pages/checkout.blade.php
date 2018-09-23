
@extends('layouts.corporate-body')

@section('content')

<form method="post" action="{{ route('payment.order')}}">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="bg-white">
<div class="card-body p-4 ">
<h1><i class="fa fa-cart"></i> Checkout</h1><br>

@if(request()->get('package')=='test')
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
      <td scope="row" rowspan=2>Flex Package (10 credits, Unlimited bandwidth, One year validity)</td>
      <td>Number of Accounts</td>
      <td>10</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 20</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 20</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
  <div class="card-body">
    <div class="form-check mb-2">
    <input class="form-check-input" type="hidden" name="txn_amount" value="20">
    <input class="form-check-input" type="hidden" name="package"  value="test">
    <input class="form-check-input" type="hidden" name="cheque"  value="20">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="paytm" checked> paytm
 
</div>
<div class="form-check ">
  
 
  </label>
</div>
  </div>
</div>

@endif

@if(request()->get('package')=='flex')
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
      <td scope="row" rowspan=2>Flex Package (200 credits, Unlimited bandwidth, One year validity)</td>
      <td>Number of Accounts</td>
      <td>200</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 0</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 0</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
  <div class="card-body">
    <div class="form-check mb-2">
    <input class="form-check-input" type="hidden" name="txn_amount" id="exampleRadios1" value="00">
    <input class="form-check-input" type="hidden" name="package"  value="flex">
    <input class="form-check-input" type="hidden" name="cheque"  value="0">
    
 
</div>
<div class="form-check ">
  
 
  </label>
</div>
  </div>
</div>

@endif

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
      <td scope="row" rowspan=2>Basic Package (250 accounts, Unlimited bandwidth, One year validity)</td>
      <td>Number of Accounts</td>
      <td> 250</td>
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
  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="paytm" checked>
    <input class="form-check-input" type="hidden" name="txn_amount" id="exampleRadios1" value="100000">
    <input class="form-check-input" type="hidden" name="package" id="exampleRadios1" value="basic">
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="cheque">
  <label class="form-check-label" for="exampleRadios2">
    <div class="mb-2">Pay by Cheque</div>
    <input type="text" class="form-control" name="cheque" id="exampleFormControlInput1" placeholder="Cheque Number">
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
      <td>Number of Accounts</td>
      <td>500</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 1,50,000</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 1,50,000</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
	<div class="card-body">
		<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="paytm" checked>
    <input class="form-check-input" type="hidden" name="txn_amount" id="exampleRadios1" value="150000">
    <input class="form-check-input" type="hidden" name="package" id="exampleRadios1" value="pro">
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="cheque">
  <label class="form-check-label" for="exampleRadios2">
    <div class="mb-2">Pay by Cheque</div>
    <input type="text" class="form-control" name="cheque" id="exampleFormControlInput1" placeholder="Cheque Number">
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
      <td>Number of Accounts</td>
      <td><i class="fa fa-rupee"></i> 1000</td>
    </tr>
     <tr>
      <td>Account Fee</td>
      <td><i class="fa fa-rupee"></i> 2,00,000</td>
    </tr>
    <tr>

      <td colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> 2,00,000</span></td>
    </tr>
   
  </tbody>
</table>

<div class="card bg-light mb-3"> 
	<div class="card-body">
		<div class="form-check mb-2">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="paytm" checked>
    <input class="form-check-input" type="hidden" name="txn_amount" id="exampleRadios1" value="200000">
    <input class="form-check-input" type="hidden" name="package" id="exampleRadios1" value="ultimate">
  <label class="form-check-label" for="exampleRadios1">
    Pay with Paytm &nbsp; <img src="{{ asset('/img/paytm_logo.png')}}" width="70px" style="margin-top:-5px;"/>
  </label>
</div>
<div class="form-check ">
  <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="cheque">
  <label class="form-check-label" for="exampleRadios2">
    <div class="mb-2">Pay by Cheque</div>
    <input type="text" class="form-control" name="cheque" id="exampleFormControlInput1" placeholder="Cheque Number">
  </label>
</div>
	</div>
</div>
@endif

<button class="btn btn-lg btn-primary" type="submit">Next</button>


</div>		
</div>
</form>
@endsection           