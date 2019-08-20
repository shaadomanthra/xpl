@extends('layouts.nowrap-product')
@section('title', 'Coupon Referral  | PacketPrep')
@section('description', 'Enter the referral code for coupon')
@section('keywords', 'coupon code, referral, packetprep')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-10">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-user"></i> &nbsp;Coupon Code - Referral
			
			</h1>

      <form method="get" action="{{route('coupon.code')}}" >

        <div class="form-group">
        <label for="formGroupExampleInput2">Referral Code (Optional)</label>
        <input type="text" class="form-control" name="referral" id="formGroupExampleInput2" placeholder="Enter the refferal code"
            
          >
      </div>
      <input type="hidden" name="company" value="{{ (\request()->get('company'))? (\request()->get('company')) : 'firstacademy' }}">


      <button type="submit" class="btn btn-info">Get Discount Coupon</button>
      </form>
      


		</div>
		<div class="col-12 col-md-2">

       <div class="float-right ">
          <img src="{{ asset('/img/discount.png')}}" class="w-100 p-3 pt-0"/>    
      </div>
    

  		</div>
	</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container pb-4" >  
   
	   <div class="bg-white p-4 border ">
      <div class="row">

        <div class="col-12 ">
          <h1 class="mb-4"> FAQ</h1>
      
        <h3> Where can i get the referral code?</h3>
        <p> You can collect the referral code from you college campus ambassador</p>
        <h3> I dont know who is my campus ambassador. Where can i find it?</h3>
        <p> We can help you in this. You can whatsapp us at +91 95151 25110</p>
        </div>

        

     </div>

   </div>

 

   

   
 
      
   </div>


     </div>   
</div>

@endsection           