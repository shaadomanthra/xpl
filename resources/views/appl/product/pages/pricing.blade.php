@extends('layouts.nowrap-corporate')

@section('content')

<div class="p-5 text-center">
	<div class="titlea">Pricing</div>
</div>

<div class="container mb-md-5">
<div class=" ">
<div class="row">

  <div class="col-12 col-md-3">
        <div class="card text-white  mb-3"  style="background: #ee5253">
  <div class="card-header"><span class="subtitleb">Flex</span></div>
  
  <div class="card-body">
      <h5 class="card-title">Number of Accounts</h5>
    <h2 style="opacity: 0.6;font-weight: 800"> - Custom -</h2><br>
    <h5 class="card-title">Account Charges </h5>
    <h2 style="opacity: 0.6;font-weight: 300" >You will be charged at Rs.500 per account</h2>
    <hr>
    <h3> Service Offered</h3>
    <hr>
    <p ><b class="text-white">250 Accounts</b> <span style="opacity: 0.5">: Create upto 250 student accounts</span></p>
    
    <p> <b>Unlimited Bandwidth </b><span style="opacity: 0.6">: Watch the videos any number of times without restrictions</span></p>
    <p> <b>Validity  </b><span style="opacity: 0.6">: 1 year </span></p>
    <p> <b>Free Maintenance </b><span style="opacity: 0.6">: We take the responsibility to maintain your website with zero downtime</span></p>
    <a href="{{ route('checkout')}}?package=flex"><button class="btn btn-outline-light">Add </button></a>

  </div>
</div>
</div>

  <div class="col-12 col-md-3">
        <div class="card text-white  mb-3"  style="background: #01a3a4">
  <div class="card-header"><span class="subtitleb">Basic</span> <span class="subtitleb float-right"><i class="fa fa-rupee"></i> 1,00,000 </span></div>
  
  <div class="card-body">
      <h5 class="card-title">Number of Accounts</h5>
    <h2 style="opacity: 0.6;font-weight: 800">250</h2><br>
    <h5 class="card-title">Account Charges </h5>
    <h2 style="opacity: 0.6;font-weight: 300" >Rs.400 per account</h2>
    <hr>
    <h3> Service Offered</h3>
    <hr>
    <p ><b class="text-white">250 Accounts</b> <span style="opacity: 0.5">: Create upto 250 student accounts </span></p>
    <p> <b>Unlimited Bandwidth </b><span style="opacity: 0.6">- Watch the videos any number of times without restrictions</span></p>
    <p> <b>Validity  </b><span style="opacity: 0.6">: 1 year </span></p>
    <p> <b>Free Maintenance </b><span style="opacity: 0.6">- We take the responsibility to maintain your website with zero downtime</span></p>
    <a href="{{ route('checkout')}}?package=basic"><button class="btn btn-outline-light">Buy Now</button></a>

  </div>
</div>
</div>



    <div class="col-12 col-md-3">
    <div class="card text-white  mb-3" style="background: #2e86de">
  <div class="card-header"><span class="subtitleb">Pro</span> <span class="subtitleb float-right"><i class="fa fa-rupee"></i> 1,50,000 </span></div>
  <div class="card-body">
    <h5 class="card-title">Number of Accounts</h5>
    <h2 style="opacity: 0.6;font-weight: 800">500</h2><br>
    <h5 class="card-title">Account Charges </h5>
    <h2 style="opacity: 0.6;font-weight: 300" >Rs.300 per account</h2>
    <hr>
    <h3> Service Offered</h3>
    <hr>
    <p ><b class="text-white">500 Accounts</b> <span style="opacity: 0.5">: Create upto 500 student accounts </span></p>
    <p> <b>Unlimited Bandwidth </b><span style="opacity: 0.6">- Watch the videos any number of times without restrictions</span></p>
    <p> <b>Validity  </b><span style="opacity: 0.6">: 1 year </span></p>
    <p> <b>Free Maintenance </b><span style="opacity: 0.6">- We take the responsibility to maintain your website with zero downtime</span></p>
    <a href="{{ route('checkout')}}?package=pro"><button class="btn btn-outline-light">Buy Now</button></a>

  </div>
</div>
  </div>



	<div class="col-12 col-md-3">
				<div class="card text-white  mb-3" style="background: #3c6382">
  <div class="card-header"><span class="subtitleb">Ultimate</span> <span class="subtitleb float-right"><i class="fa fa-rupee"></i> 2,00,000 </span></div>
  
  <div class="card-body">
    <h5 class="card-title">Number of Accounts</h5>
    <h2 style="opacity: 0.6;font-weight: 800">1000</h2><br>
    <h5 class="card-title">Account Charges </h5>
    <h2 style="opacity: 0.6;font-weight: 300" >Rs.200 per account</h2>
    <hr>
    <h3> Service Offered</h3>
    <hr>
    <p ><b class="text-white">1000 Accounts</b> <span style="opacity: 0.5">: Create upto 1000 student accounts</span></p>
    <p> <b>Unlimited Bandwidth </b><span style="opacity: 0.6">- Watch the videos any number of times without restrictions</span></p>
    <p> <b>Validity  </b><span style="opacity: 0.6">: 1 year </span></p>
    <p> <b>Free Maintenance </b><span style="opacity: 0.6">- We take the responsibility to maintain your website with zero downtime</span></p>
    <a href="{{ route('checkout')}}?package=ultimate"><button class="btn btn-outline-light">Buy Now</button></a>

  </div>
</div>
</div>
	</div>
</div>

</div>		
</div>

@endsection           