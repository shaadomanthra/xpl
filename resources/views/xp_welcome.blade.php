@extends('layouts.app2')
@section('title', 'Assessments to hire the best candidates')
@section('description', 'The best repository for placement papers and aptitude questions for infosys, tcs nqt,tcs ninja, tcs digital, amcat, cocubes, accenture, cognizant, wipro and many more ')
@section('keywords', 'campus placement preparation, wipro placement papers, infosys placement papers, aptitude questions, amcat previous papers, amcat preparation,tcs nqt, tcs ninja, tcs digital')
@section('content')
@include('appl.exam.exam.xp_css')

<div class="p-3 bg-p text-center" style="background-color:#fffafb;background-image: url({{asset('img/colors/star2.png')}});">
<div class="container" style="">
<div class="p-3 p-md-5"></div>
    <div class="heading_one  text-center" >
    Now is the time to <br>hire the best
    </div>
    <div class="heading_two  mb-4 mt-3 text-center" >
   Choose from <span class="element" ></span> 
    </div>
    <div>
      <a href="{{ route('login')}}" class="btn btn-lg btn-success">Try for free</a>
    </div>

   
   <div class="p-2 p-md-5"></div>
</div>


</div>
<div class="text-center text-md-left" style="background:#fff">
  <div class="container">
        <div class="p-2 p-md-4"></div>
    
    <div class="p-0 p-md-2"></div>

    <div class="row">
            <div class="col-12 col-md-4">
              <h5 class="heading_two mt-5" style='color:#3255b8;font-size:15px; '>Secure Platfrom</h5>
              <div class="heading_one mb-3 " style="font-weight: 900;font-size:50px;color:#525252;line-height: 1.5">
                <p class=''>AI tools to detect fraudsters</p>
                </div>
                <p class="heading_two" style="font-size:20px;">Select only the one who are genuine performers.</p>
            </div>
            <div class="col-12 col-md-8">
              <img src='{{ asset("img/front/img_a.png")}}' class="w-100"/>
            </div>
        </div>
        <div class="p-5 p-md-5"></div>
  </div>
</div>

<div class="text-center text-md-left" style="background:#519d54;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0 mt-5 mt-md-0'>
                <div class="icon mb-3"><i class="fa fa-shield fa-3x"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'><b>Data Security</b></div>
                <p>All the content is secured via unique data security protocol which is impossible to break.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-envelope-open-o fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>OTP Login</div>
                <p>Enabling the OTP based login will restrict the access to the platform for authentic users.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-expeditedssl fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>SSL encripted</div>
                <p>SSL level secruity provides data encription across network, and limits the access to secure resources. </p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>Candidate Authorization</div>
                <p>Only the assigned users can take the premium test in <br>secure environment.</p>
              </div>
            </div>
      </div>
  </div>

    <div class="p-2 p-md-4"></div>
</div>

<div class="text-center text-md-left" style="background:#fff">
  <div class="container">
        <div class="p-3 p-md-4"></div>
    
    <div class="p-0 p-md-2"></div>

    <div class="row">
      <div class="col-12 col-md-8">
              <img src='{{ asset("img/front/img_b.png")}}' class="w-100"/>
            </div>
            <div class="col-12 col-md-4">
              <h5 class="heading_two mt-5" style='color:#3255b8;font-size:15px; '>Made for Coding</h5>
              <div class="heading_one mb-4 " style="font-weight: 900;font-size:50px;line-height: 1.5;color:#525252;">
                <p class=''>Evaluating programmers is now easy!</p>
                </div>
                <p class="heading_two" style="font-size:20px;"> Test your candidates in c, c#, java, python, swift and many more</p>
            </div>
            
        </div>
        <div class="p-4 p-md-5"></div>
  </div>
</div>

<div class="text-center text-md-left" style="background:#c25054;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0 mt-5 mt-md-0'>
                <div class="icon mb-3"><i class="fa fa-gg fa-3x"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'><b>Custom Tests</b></div>
                <p>Create your own tests from scratch or choose from our database of 10,000 questions.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-yoast fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>Your Branding</div>
                <p>Upload your logo and candidates will be able to see your logo on test window.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-area-chart fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>Advanced Analytics</div>
                <p>Our detailed candidate analytics will make your selection process a cake walk.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-table fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>Excel Reports</div>
                <p>We all love Excel, export the test reports to excel which can be easily shareable.</p>
              </div>
            </div>
      </div>
  </div>

    <div class="p-2 p-md-4"></div>
</div>

<div class="" style="background:#fff">
  <div class="container">
        <div class="p-3 p-md-5"></div>
    <div class="display-3 mb-5 text-center">We hire for</div>
    <div class="p-0 p-md-2"></div>

    <div class="row">
            @for($i=1;$i<19;$i++)
            <div class="col-6 col-md-2">
              <img class="example-image p-1 mb-3" src="img/companies/{{$i}}.jpg"  width="100%" alt="Companies{{$i}}" />
            </div>
            @endfor
        </div>
        <div class="p-4 p-md-5"></div>
  </div>
</div>

<div class="text-center text-md-left" style="background:#c25054;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-10">
              <div class='item heading_two' style='color: white;font-size:25px'>
               Try Xplore and get the right candidates onboard
              </div>
            </div>
            <div class="col-12 col-md-2">
              <div class='item '>
                <div class="icon mb-3 mt-4 mt-md-0">
                  <a href="{{ route('contact-corporate')}}" class="btn btn-light w-100"> Contact Us</a>
              </div>
            </div>
           
      </div>
  </div>

    <div class="p-2 p-md-3"></div>
</div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <div class="video_body">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <?php
          session()->put( 'redirect.url',request()->url().'/dashboard');
      ?>
@endsection    