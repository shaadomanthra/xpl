@extends('layouts.nowrap-white')
@section('title', 'Pricing ')
@section('content')

<div class="p-5 text-center">
	<div class="heading_one" style="font-size:40px">Start screening candidates in less than 5 minutes</div>
  <div class="heading_two mt-3" style="font-size:30px;color:silver">with simple and competitive pricing</div>
</div>

<div class="container mb-md-5">
  
<div class=" ">
<div class="row">
  <div class="col-12 col-md-6">
    <div class="mb-5">
  <div class="heading_one display-1 text-center"><i class="fa fa-rupee"></i>300</div>
  <div class="text-center">per candidate</div>
</div>
    </div>
  <div class="col-12 col-md-6">
    <div class="mb-3"><i class="fa fa-check-circle"></i> Fixed pricing no subscription</div>
    <div class="mb-3"><i class="fa fa-check-circle"></i> Pay as you go</div>

    <div class="mb-3"><i class="fa fa-check-circle"></i> All features included in the package</div>
     <div class="mb-3"><i class="fa fa-check-circle"></i> Dedicated resource manager</div>

  </div>

</div>

</div>		
</div>

<div class="" style="background:#3a5294;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-10">
              <div class='item heading_two' style='color: white;font-size:25px'>
               Screen candidates with easy,
fixed <br>and transparent pricing
              </div>
            </div>
            <div class="col-12 col-md-2">
              <div class='item '>
                <div class="icon mb-3">
                  <a href="{{ route('contact')}}" class="btn btn-light w-100"> Contact Us</a>
              </div>
            </div>
           
      </div>
  </div>

    <div class="p-2 p-md-4"></div>
</div>
</div>

@endsection           