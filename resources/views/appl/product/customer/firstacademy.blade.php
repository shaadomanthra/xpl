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
      <img src="{{ asset('/img/fa_logo.png')}}" style="width:25px"/>   &nbsp;First Academy </h1>
      
      <p>Platinum Partner - British Council. The most awarded training institute in South India. The most awesome classes on this side of the solar system. </p>
      <hr>
      <p>Now all packetprep users can attend a demo class, take a mock test and get expert counselling, all for Free.
      </p>
      <p class="mb-3"> We have reviewed their work, and we found them awesome. Specially their 320+ premium batch is best in industry. If you think they are the right mentors for you, then before you join the course download the discount coupon.</p>
     
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
          <iframe src="//player.vimeo.com/video/327440260" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
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
          <iframe src="//player.vimeo.com/video/327447675" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Study Abroad</h1>
          <p > Should you go abroad? Can one not have a successful career here? This video looks at addressing the most basic question of them all while giving you a few pointers on where to begin.</p>
        </div>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
         <iframe src="//player.vimeo.com/video/327448242" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >Application Process</h1>
          <p > The Whole application process is confusiing, difficult, and fraught with possibilities of missteps. This video serves as the primer to the entire process. Call this international Applications One-Oh-One!</p>
        </div>
         
          </div>
        </div>
       

      </div>

      <div class="row">
        
        

         <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/327448096" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >GRE Myths</h1>
          <p > Taking the GRE and confused about all the words you need to learn? Is M1 a nightmare? Do you even need the GRE? This video might come as a pleasant surprise, and as a surprise relief. Give it a watch! </p>
        </div>
          
          </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
         <iframe src="//player.vimeo.com/video/327448474" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >IELTS Myths</h1>
          <p > Why am I not getting a score I want? Where did I go wrong? Let us help you put an end all the misinformation that is floating around. Take the first step the right way!</p>
        </div>
         
          </div>
        </div>

        
        <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/335684539" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >What Students Say</h1>
          <p > Saying we are the best is easy. Learn why we can say it with confidence. From training to authoring books. From having international certifications to providing examiner grade evaluations, learn what makes us the best!</p>
        </div>
          </div>
        </div>

         
         <div class="col-12 col-md-6">
          <div class="bg-white border mb-4">
            
          <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/327448452" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <div class="p-3">
          <h1 >First Academy Team</h1>
          <p > Saying we are the best is easy. Learn why we can say it with confidence. From training to authoring books. From having international certifications to providing examiner grade evaluations, learn what makes us the best!</p>
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