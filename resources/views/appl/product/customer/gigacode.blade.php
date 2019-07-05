@extends('layouts.nowrap-product')
@section('title', 'GigaCode - Training Workshop for Coding Interviews | PacketPrep')
@section('description', 'GigaCode - It is a One day/8 hour Intensive classroom program to help students crack coding interviews. In the training, students a taught with basics of c programming, then 10 most important coding logics and a live implementation of 20 programming tasks. ')
@section('keywords', 'coding workshop,coding training, coding interviews, btech students,')

@section('content')
<link href="css/lightbox.css" type="text/css" rel="stylesheet">
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white" >
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-6">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-code"></i> &nbsp;GigaCode - Training Workshop
			
			</h1>
      <div class="badge badge-info mb-3">To Crack Coding Interviews</div>
      <p>GigaCode - It is a One day/8 hour Intensive classroom program to help students crack coding interviews. In the training, students are taught with basics of c programming, then 10 most important coding logics and a live implementation of 20 programming tasks. </p>
      <p> <b>Eligibility : </b> Btech All Branches, Final year.<br>
       <b> Batches :</b> 
       <ul>
        <li>Batch 1 - July 13th  2019 - 10:00am to 6:00pm <span class="badge badge-success">Open</span>
        </li> 
       <li>Batch 2 - July 14th  2019 - 10:00am to 6:00pm 
        </li> 
        </ul>  
       
       <b> Location:</b> PacketPrep Office, Tarnaka, Hyderabad.<br>  

      
    </p>
     
      <div class="p-3 rounded mb-3" style="background: #f2f2f2">      
         <h3 > <strike><i class="fa fa-rupee"></i>  2,000</strike> &nbsp;<span class="badge badge-warning">15% OFF</span></h2>
        <h1 > <i class="fa fa-rupee"></i>  1700 </h1><hr>
        Get an additional discount of 10% for a group of 3 students
      </div>
      
      <div class="bg-light p-3 border rounded mb-3">
        <h3> Reserve your seat now by paying Rs.500</h3>
      <a href="{{ url('productpage/gigacode-workshop') }}">
      <button class="btn btn-lg btn-primary mb-3"> Pay Online</button>
      </a>
    </div>



		</div>
		<div class="col-12 col-md-6">

		   <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe  src="https://www.youtube.com/embed/4wXO8Bj3c6s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

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
          <h1 class="mb-4"> What's Included in GigaCode Workshop?</h1>
      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-rocket"></i></div>
        <div class="col-8 col-md-10">
          <h2> 1 day - 8 hour Classroom Training</h2>
          <p> It is an intensive classroom training for cracking coding interviews.</p>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-globe"></i></div>
        <div class="col-8 col-md-10">
          <h2> Code Logics</h2>
          <p> You will be taught 10 most important code logics for coding interviews.</p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-trophy"></i></div>
        <div class="col-8 col-md-10">
          <h2> 20 Programming Tasks</h2>
          <p> You will write 20 programming tasks under the guidance of the trainer. </p>
        </div>
      </div>
        </div>

        <div class="col-12 col-md-4">
          <h1 class="mb-4"> Training Highlights</h1>
          <ul>
            <li>In the GigaCode Workshop, You will learn basics of c programming which includes data types, control flow, functions, loops, arrays, pointers. </li>
            <li> Handson experience to remove syntax errors from code.</li>
            <li> Live coding on frequently asked programming questions.</li>
            <li> Small batch size and Personal Guidance. </li>

          </ul>

        </div>

     </div>

   </div>



      
     
 

  
      
   </div>


     </div>   
</div>
<script src="js/lightbox-plus-jquery.min.js"></script>

@endsection           