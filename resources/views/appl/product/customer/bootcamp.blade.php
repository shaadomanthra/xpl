@extends('layouts.nowrap-product')
@section('title', 'Coding Bootcamp - Realtime Project | PacketPrep')
@section('description', 'Build your first commercial web application with us. A great opportunity to utilize your leisure time to build a great realtime project')
@section('keywords', 'summer internship, coding, bootcamp, engineering students, ')

@section('content')
<link href="css/lightbox.css" type="text/css" rel="stylesheet">
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white" >
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
		<div class="col-12 col-md-6">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-code"></i> &nbsp;Coding Bootcamp - Realtime Project
			
			</h1>
      <p>Build your first commercial web application with us at packetprep.  A great opportunity to utilize your leisure time to build a great realtime project, where you will learn to write code from scratch to the end. </p>
      <p> <b>Eligibility : </b> Btech All Branches, 1st year to 4th year<br>
       <b> Batches :</b> 
       <ul>
        <li>Batch 1 - Aug 5th to Aug 16th  2019 </li> 
        <li>Batch 2 - Aug 19th to Aug 30th  2019</li> 
        </ul>  
       
       <b> Timing :</b> 6:00pm to 8:00pm <br>  
       <b> Location :</b> PacketPrep Office, Tarnaka, Hyderabad.<br>  
       <b> Contact :</b> Mr.Syamson, +91 95026 97428<br>  

      
    </p>
     
      <div class="p-3 rounded mb-3" style="background: #f2f2f2">      
        <h2 > <i class="fa fa-rupee"></i>  3,500 </h2>
        
      </div>
      
      <div class="bg-light p-3 border rounded mb-3">
        <h3> Reserve your seat now</h3>
      <a href="{{ url('productpage/cbp') }}">
      <button class="btn btn-lg btn-primary mb-3"> Part Payment</button>
      </a><br>
      You can pay Rs.500 to reserve the seat, remaining amount to be paid on the first day of training
    </div>



		</div>
		<div class="col-12 col-md-6">

		   <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348328050" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>

  		</div>
	</div>

	</div>

</div>

</div>



<div class="wrapper " >
    <div class="container pb-5" >  

      <div class="bg-light border rounded p-3 mb-3">
        <h1>First Cycle of Coding Bootcamp</h1>
        <p>We have successfully trained the 60+ students through Coding Bootcamp 2019(Summer Camp). Through this program students have learnt the basics of web development which includes html, css, bootstrap, php and mysql.

Together we have built three project namely Resume, Calculator App and Simple Blog.</p>
<p class="mb-3">Here is the link to one of our student's projects<br>
<a href="http://isha.packetprep.net">http://isha.packetprep.net</a>
</p>
<hr>
        <div class="row ">
          <div class="col-12 col-md-6">
            <h3 class="mb-4"> Listen to our Students Review</h3>
            <div class="embed-responsive embed-responsive-16by9 border mb-4" style="background: #eee;">
            <iframe  src="https://www.youtube.com/embed/IUUBwieD6hw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <h3 class="mb-4">Internship Certificates </h3>
            @for($i=1;$i<9;$i++)
              <a class="example-image-link" href="img/bootcamp/{{$i}}.jpeg" data-lightbox="example-1"><img class="example-image p-1" src="img/bootcamp/{{$i}}.jpeg" alt="image-1" width="120px" /></a>
            @endfor
            <div class="p-3"></div>
          </div>
        </div>
        <hr>
        <div class="row ">
          <div class="col-12 col-md-6">
            <h3 class="mb-4"> Testimonial by Sree Charan</h3>
            <p>College : MVSR College(Matrusri)<br>Branch: MECH<br>Year : 3rd year</p>
            <div class="embed-responsive embed-responsive-16by9 border mb-4" style="background: #eee;">
            <iframe  src="https://www.youtube.com/embed/0E2Tvg7Ji34" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <h3 class="mb-4"> Feedback from Tanya Sri</h3>
            <p>College : Mallareddy Engineering College<br>Branch: ECE<br>Year : 2nd year</p>
            <div class="embed-responsive embed-responsive-16by9 border mb-4" style="background: #eee;">

            <iframe  src="https://www.youtube.com/embed/OXlGioKAASk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        
  <div>
      
      
    </div>
  </div>
   
	   <div class="bg-white p-4 border mb-3">
      <div class="row">

        <div class="col-12 col-md-8">
          <h1 class="mb-4"> What's Included?</h1>
      <div class="row mb-4">
        <div class="col-4 col-md-2"><i class="fa fa-4x fa-rocket"></i></div>
        <div class="col-8 col-md-10">
          <h2> 10 days Program </h2>
          <p> Its 5 days training and 5 days project work </p>
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
          <p> On completion of project, you will recieve the internship certificate </p>
        </div>
      </div>
        </div>

        <div class="col-12 col-md-4">
          <h1 class="mb-4"> Training Highlights</h1>
          <ul>
            <li>You will learn PHP, HTML, CSS and Bootstrap. </li>
            <li> You will learn how to book domain name, hosting and deploying the code on global server</li>
            
            <li> Small batch size and Personal Guidance </li>

          </ul>

        </div>

     </div>

   </div>

      <div class="bg-white p-4 border mb-4">
    <h2 class="mb-4">Training Schedule </h2>

        <div class="table-responsive ">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">Day</th>
                <th scope="col">Module</th>
                <th scope="col">What you will Learn?</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td> How websites work? and basics of html</td>
                <td> You will learn how webpages are created, how to store them in server and how they load over the browser</td>
              </tr>  

              <tr>
                <th scope="row">2</th>
                <td> Core HTML tags and using CSS</td>
                <td>We will build a sample resume page using core html and basic css </td>
              </tr>  

              <tr>
                <th scope="row">3</th>
                <td> Usage of CSS and Bootstrap </td>
                <td> Making the design adaptive for desktop, mobile and tablet devices. Bootstrap techonology baiscs and usage, foundation api basics and usage. </td>
              </tr>  

              <tr>
                <th scope="row">4</th>
                <td> PHP Basics</td>
                <td>Writing clean code using PHP, procedural and object oriented code design, inserting php tags in html, core logic implementation</td>
              </tr>  

              <tr>
                <th scope="row">5 </th>
                <td> Calculator Application </td>
                <td> Real time implementation of php basics in designing a simple caluclator application </td>
              </tr>  

              <tr>
                <th scope="row">6</th>
                <td> Project Work</td>
                <td> Drafting the requirements for a college website</td>
              </tr>  

              <tr>
                <th scope="row">7</th>
                <td> Project Work </td>
                <td> Building the basics pages of the college website using html and css</td>
              </tr>   
              <tr>
                <th scope="row">8</th>
                <td> Project Work </td>
                <td> Integrating Bootstrap css and making website responsive</td>
              </tr> 
              <tr>
                <th scope="row">9</th>
                <td>  Doubt Clarifications </td>
                <td> Student can attend personal session and get the doubts clarified </td>
              </tr> 
              <tr>
                <th scope="row">10</th>
                <td> Project Submission</td>
                <td>The final project to be submitted </td>
              </tr> 
            </tbody>
          </table>
        </div>
       


   </div>

<!--

     <div id="mini-project" class="bg-white p-4 border mb-3">
      <h1 class="bg-light border p-3 rounded mb-3"> Mini Projects (Optional) </h1>
      <p> Students who undergo training in coding bootcamp will also be given an opportunity to do a FREE mini project for academic purpose. Interested students can select one of the following projects, we will give training/implementation support for extra 2 or 3 weeks (10 to 15 days). <br><p class="bg-warning p-3 rounded">The best team's code will be integrated to packetprep's platfrom with their names as credits at the bottom. This will be of great value to students who are applying for abroad universities or  core companies interview.</p></p>
      <div class="row">
        
        <div class="col-12 col-md-4">
          <h2 class="mb-4"> Social Wall</h2>
          <p>The Social Wall project is a client-server Web application built over an RDBMS. It is an application that runs on a portal site, in which different users (and user groups) can publish and revise daily journal entries, and these entries will be made public for others to view.  In essence, it gives everyone his or her own personal editorial column to publish to the world. </p>
          <a href="https://drive.google.com/file/d/1Ug0fCPyVAsSU2waxirNUZixRkfzeZHo8/view?usp=sharing">
          <button class="btn btn-success mb-3"> Download Abstract</button>
        </a>
        </div>

        <div class="col-12 col-md-4">
          <h2 class="mb-4"> Q/A Forum</h2>
          <p>Everyone has questions to be answered. Our Question Answer Forum is the place where anyone can post a question and seek answers from the community. The best questions/answers can up voted and liked. This will the one stop platform for people to interact and answer users doubts. </p>
          <a href="https://drive.google.com/file/d/13VlC-wSG652h7jC6cALFsyUAIfk09RKt/view?usp=sharing">
          <button class="btn btn-success mb-3"> Download Abstract</button>
        </a>
        </div>
        
        <div class="col-12 col-md-4">
          <h2 class="mb-4"> Job Aggregator</h2>
          <p>Sometimes it’s hard to find the right jobs for the right category. This project solves this problem by listing out the jobs/openings based on various parameters. And User can search through the listing based on salary, location, role, experience etc. including government jobs, and bank jobs listing. </p>
          <a href="https://drive.google.com/file/d/1wkpTTc5F1pWyDyUvUUfYV7l9VPevpij_/view?usp=sharing">
          <button class="btn btn-success mb-3"> Download Abstract</button>
        </a>
        </div>

     </div>

   </div>
   
-->


   
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
<script src="js/lightbox-plus-jquery.min.js"></script>

@endsection           