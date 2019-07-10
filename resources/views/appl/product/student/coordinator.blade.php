@extends('layouts.nowrap-product')
@section('title', 'Campus Coordinator | Internship | PacketPrep')
@section('description', 'Do you have the leadership qualities to take our services to your college? if yes then join us.')
@section('keywords', 'internship, campus coordinator, packetprep')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-trophy"></i> &nbsp;Campus Coordinator
			
			</h1>
      <p>A great opportunity for students to showcase their leadership abilities </p>
      <p> <b>Eligibility :</b> Btech 2nd & 3rd year <br>
        <b> Stream :</b> All Branches<br>
        <b> Duration :</b> 60 days<br>
        <b> Location:</b> Hyderabad<br>
        <b> Prerequisite :</b> <ul>
            <li>Excellent Communication Skills</li>
            <li> Strong Network among students</li>
            <li>Commitment to work till the end of program</li>
          </ul>
      <p> <a href="{{ route('form.create',['job'=>'campus-coordinator'])}}">
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
          <li>To create brand awareness for PacketPrep </li>
          <li>Promote <b>Placement Foundation</b> program</li>
          <li>Explain about PacketPrep Products & Services
              <ul>
                  <li>GigaCode Prorgam</li>
                  <li>Coding Bootcamp Prorgam</li>
                  <li>Online Courses for Placements</li>
              </ul>
          </li>
          <li>Explain about PacketPrep programs for Abroad
              <ul>
                  <li>Coaching for GRE, IELTS, TOEFL </li>
                  <li>Consulting for MS in US/Canada/UK/Australia </li>
              </ul>
          </li>
          </ul>
        </div>

        <div class="col-12 col-md-6">
          <h1 class="mb-4"> Benefits</h1>
          <ul>
            <li>Rs. 5000 stipend </li>
            <li>Internship Certificate </li>
            <li> Top performers profile will be added to the official PacketPrep website under Student Interns page</li>
          </ul>
          <h1 class="mb-4"> Interview Process</h1>
          <ul>
            <li>Apply online <a href="{{ route('form.create',['job'=>'campus-coordinator'])}}">Link</a> </li>
            <li>Shortlisted students have to send 1 min audio message on 'Why its important to learn coding?' or 'Why to do MS in Abroad?' </li>
            <li> Selected candidates will be called for  personal interview at <br>
              <b>PacketPrep Office</b>, Tarnaka, Hyderabad.</li>
           

          </ul>

        </div>

     </div>

   </div>

 

   

   
      
 
      
   </div>


     </div>   
</div>

@endsection           