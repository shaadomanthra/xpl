@extends('layouts.nowrap-product')
@section('title', 'First Academy - Discount Coupon for GRE & IELTS  | PacketPrep')
@section('description', 'Build your first commercial web application with us. A great opportunity to utilize your summer time to build a great realtime project')
@section('keywords', 'summer internship, coding, bootcamp, engineering students, ')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white" >
	<div class="wrapper ">  
	<div class="container">

	<div class="row">
		<div class="col-12 col-md-6">
			<h1 class="mt-2 mb-4 mb-md-2">
      <img src="{{ asset('/img/fa_logo.png')}}" style="width:25px"/>   &nbsp;FirstAcademy </h1>
      
      <p>Platinum Partner - British Council. The most awarded training institute in South India. The most awesome classes on this side of the solar system. </p>
      <h3 class="mb-3">PacketPrep - Exclusive discount coupon for GRE & IELTS Classroom Training</h2>
     
      <div class="p-3 rounded mb-3" style="background: #f2f2f2">  
      <div class="">Discount </div>    
        <h2 > <i class="fa fa-rupee"></i>  1000 </h2>
        
      </div>
      <a href="{{ url('couponreferral') }}?company=firstacademy">
      <button class="btn btn-lg btn-success mb-3"> Download Coupon</button>
      </a>


		</div>
		<div class="col-12 col-md-6">

		   <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/ejGEJ86fv5c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>

  		</div>
	</div>
	</div>

</div>

</div>

<div class="wrapper " >
    <div class="container pb-5" >  
   


   

   
      <div class="row">
        
         <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/M765gB_IUL0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Coding & Career</h1>
          <p > Cracking job in a top Multi National Company is a tough task, but  consitent preparation and commitment can make you land in your dream job. This video answers the common questions students have regarding the career, learning apsects, growth.</p>
        </div>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/AKuu0IanGKU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Coding & Money</h1>
          <p > Everybody dreams of an independent life, pocket full cash and happy going. If have good programming skill, you can easliy make money. This video explains different websites to look for parttime jobs, how to make good commercial projects and details on freelancing.</p>
        </div>
          </div>
        </div>

      </div>

      <div class="row">
        
        

         <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/4nBO1yj8RAo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Coding & Startup</h1>
          <p > Startup is the new big thing. Startup is the way forward for Digital India. If you have a great idea and dont know how to build your project, then coding bootcamp is the right place to learn the basics of building commercial application. </p>
        </div>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/HIYbB17wNmo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Coding & Abroad Studies</h1>
          <p > If you have plans for abroad study, you can watch this video to understand the importance of coding, impact of mini and major project for MS application, how coding bootcamp can help you crack Research assitantship.</p>
        </div>
          </div>
        </div>
      </div>
      
 

   <div class="bg-light p-4 border ">
      In case of any query, you can whatsapp us at <i class="text-secondary">+91 95151 25110</i> or mail us at <i class="text-secondary">founder@packetprep.com</i>
      </div>
      
   </div>


     </div>   
</div>

@endsection           