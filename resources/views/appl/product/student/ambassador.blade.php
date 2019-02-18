@extends('layouts.nowrap-product')
@section('title', 'Campus Ambassador | Internship | PacketPrep')
@section('description', 'Do you have the leadership qualities to take our services to your college? if yes then join us.')
@section('keywords', 'internship, campus ambassador, packetprep')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-trophy"></i> &nbsp;Campus Ambassador
			
			</h1>
      <p>A great opportunity for students to showcase their leadership abilities </p>
      <p> <b>Eligibility :</b> Btech 3rd year ( 2020 passout batch)<br>
        <b> Stream :</b> All Branches<br>
        <b> Prerequisite :</b> <ul>
            <li>Excellent Communication Skills</li>
            <li> Strong Network among students</li>
            <li>Commitment to work till the end of program</li>
          </ul>
      <p> <a href="{{ route('job.show','campus-ambassador')}}">
          <button class="btn btn-lg btn-success">Apply Now</button>
          </a></p>


		</div>
		<div class="col-12 col-md-4">

       <div class="float-right ">
          <img src="{{ asset('/img/ambassador.jpg')}}" class="w-100 p-3 pt-0"/>    
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

        <div class="col-12 col-md-6">
          <h1 class="mb-4"> Job Description</h1>
      <ul>
            <li>You are responsible to onboard students onto PacketPrep platform for TARGET TCS Program </li>
            <li> Create authorized PacketPrep Learners Group in WhatsApp</li>
            <li>Share the daily video lecture in the WhatsApp group </li>
            <li>Inspire friends to take part in daily practice tests</li>
            <li>At the end of program, collect feedback from the top participants</li>

          </ul>
        </div>

        <div class="col-12 col-md-6">
          <h1 class="mb-4"> Benefits</h1>
          <ul>
            <li>Internship Certificate </li>
            <li> Top performers profile will be added to the official PacketPrep website under Student Interns page</li>
            <li> Complimentary discount coupons from featured partners (if all works good)</li>

          </ul>

        </div>

     </div>

   </div>

 

   

   
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="bg-white p-4 border mb-4 mb-md-0">
          <h1> Apply Now</h1>
          <p>Take your first step of leading the club </p>
          <a href="{{ route('job.show','campus-ambassador')}}">
          <button class="btn btn-lg btn-success">Apply Now</button>
          </a>
        </div>

        </div>
        <div class="col-12 col-md-8">
          <div class="bg-white p-4 border ">
          <h1> Interview Process</h1>
          <ul>
          	<li>Only the deserved candidates will be shortlisted based on the given credentials</li>
            <li>Shortlisted Candidates will have a telephonic interview </li>
            <li>Followed by JAM session at our corporate office</li>
            <li>Followed by Personal Interview</li>

          </ul>
        </div>

        </div>
        
      </div>
 
      
   </div>


     </div>   
</div>

@endsection           