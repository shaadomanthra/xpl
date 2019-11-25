
@extends('layouts.app')

@section('content')

<!--
<form method="post" action="{{ route('payment.order')}}">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="bg-white">
<div class="card-body p-4 ">
<h1><i class="fa fa-cart"></i> Checkout</h1><br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Product</th>
      @if($product->price<5000)
      <th scope="col">Validity</th>
      @else
      <th scope="col">Training</th>
      @endif
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row" rowspan=1>{!! $product->description !!}</td>
      @if($product->price<5000)
      <td>{{ $product->validity }} months</td>
      @else
       <td>Classroom</td>
      @endif
      <td>@if($product->price==0) - FREE - @else {{ $product->price}} @endif</td>
    </tr>
     <tr>
    </tr>
    <tr>

      <td scope="row" colspan=2>Total Amount</td>
      <td><span class="badge badge-warning" style="font-size: 20px"><i class="fa fa-rupee"></i> <span class="total">{{ $product->price }} </span></span></td>

      
    </tr>
    @if($product->price!=0)
    <tr style="background: #eee">
      <td scope="row" colspan=2><div class="mb-2">Coupon Code (optional)</div><input type="text" class="form-control mb-2 coupon-input" name="coupon" id="formGroupExampleInput2" placeholder="" style="width:100px"
          >
          <input type="hidden" class="url"  id="" value="{{ url('/') }}" >
          
          <button class="btn btn-sm btn-outline-secondary coupon-button" type="button">Add</button></td>
      <td style="width:40%">
          <span class="status"></span>
      </td>
    </tr>
    @endif
   
  </tbody>
</table>

@if($product->price!=0)
<div class="card bg-light mb-3"> 
  <div class="card-body">
    <div class="form-check mb-2">
    

  <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="instamojo" checked> Pay Online
 
</div>

  </div>

</div>
 @endif
 <input class="form-check-input amount" type="hidden" name="txn_amount" value="{{ $product->price }}">
<input class="form-check-input product" type="hidden" name="product_id"  value="{{ $product->id }}">

<button class="btn btn-lg btn-primary" type="submit">Next</button>

</div>		
</div>
</form>
-->
<div class="p-4 bg-white">
<h4>Reach us out at </h4>
<b>Mr. Prashanth </b> (Cofounder)<br>
email : prashanth@phrpl.com<br>
contact : +91 7287878747<br><br>

<b>Mr. Akhil </b>(Cofounder)<br>
email : akhil@phrpl.com<bR>
contact : 9849485501<br><br>

<b>Mr. Abhinav</b> (Cofounder)<br>
email : abhinav@phrpl.com<br>
contact : 8801358568<br><Br>

<hr>
<p><b>Pathway Human Resource Private Limited</b> </p>
<p>Address:<br>
#6-3-672,Flat No:301,<bR>Khursheed Mansion, Opp Police station,<br>Beside Hyderabad Central, Panjagutta,<br>Hyderabad, Telangana ,India 500082<br><bR>
Email: hr@phrpl.com<br>
Call: +91 7287878747<br>
Phone No: 040-42222253<br>

</div>
</div>
@endsection
        