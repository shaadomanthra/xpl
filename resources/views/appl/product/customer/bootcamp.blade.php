@extends('layouts.nowrap-product')
@section('title', 'Coding Bootcamp - Summer Internship for Engineering Students  | PacketPrep')
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
			<i class="fa fa-code"></i> &nbsp;Coding Bootcamp
			
			</h1>
      <p>Build your first commercial web application with us at packetprep.  A great opportunity to utilize your summer time to build a great realtime project, where you will write the code from scratch to the end. </p>
      <p> <b>Eligibility :</b> CSE & IT<br>
      <b>Date :</b> 15th May  to 4th June 2019<br>
       <b> Batch :</b> 9:00 am to 1:00 pm (open) & 2:00 pm to 6:00 pm<br>  
       
       <b> Location:</b> PacketPrep Office, Tarnaka, Hyderabad.<br>  

    </p>
     
      <div class="p-3 rounded mb-3" style="background: #f2f2f2">      
        <h2 > <i class="fa fa-rupee"></i>  10,000 </h2>
        <div> Collect your discount coupon from campus ambassador</div>
      </div>
      <a href="{{ url('productpage/cb') }}">
      <button class="btn btn-lg btn-success mb-3"> Reserve your seat now</button>
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
   
	   <div class="bg-white p-4 border mb-3">
      <div class="row">

        <div class="col-12 col-md-8">
          <h1 class="mb-4"> What's Included?</h1>
      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-rocket"></i></div>
        <div class="col-8 col-md-10">
          <h2> 60 hour Classroom Training</h2>
          <p> It is 4hour/day intensive training for 15 days </p>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-globe"></i></div>
        <div class="col-8 col-md-10">
          <h2> Live Application</h2>
          <p> By the end of the course, your application will be live for public use</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-trophy"></i></div>
        <div class="col-8 col-md-10">
          <h2> Internship Certificate</h2>
          <p> On completion of training, you will recieve the summer internship certificate </p>
        </div>
      </div>
        </div>

        <div class="col-12 col-md-4">
          <h1 class="mb-4"> Training Highlights</h1>
          <ul>
            <li>You will learn the basics of PHP, MySql, HTML, CSS and JQuery. </li>
            <li> You will learn how to book domain name, hosting and deploying the code on global server</li>
            <li>The most critical aspect, how to integrate payment gateway for online transactions where money is directly sent to the bank account</li>
            <li> Small batch size and Personal Guidance </li>

          </ul>

        </div>

     </div>

   </div>


   
<!--
   
      <div class="row">
        
        <div class="col-12 col-md-6">
          <div class="bg-white p-4 border mb-4">
          <h1> Career Prospects</h1>
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/ejGEJ86fv5c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>

        </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="bg-white p-4 border mb-4">
          <h1>Making Money</h1>
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/ejGEJ86fv5c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          </div>
        </div>
      </div>

      <div class="row">
        
        <div class="col-12 col-md-6">
          <div class="bg-white p-4 border mb-4">
          <h1> Startup Idea</h1>
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/ejGEJ86fv5c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>

        </div>

        </div>
        <div class="col-12 col-md-6">
          <div class="bg-white p-4 border mb-4">
          <h1>Abroad Studies</h1>
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/ejGEJ86fv5c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          </div>
        </div>
      </div>
      
   -->

   <div class="bg-light p-4 border ">
      Note : <br>
      In case of any query, you can whatsapp us at +91 95151 25110 or mail us at founder@packetprep.com
      </div>
      
   </div>


     </div>   
</div>

@endsection           