@extends('layouts.app2')
@section('title', 'Assessments to hire the best candidates')
@section('description', 'The best repository for placement papers and aptitude questions for infosys, tcs nqt,tcs ninja, tcs digital, amcat, cocubes, accenture, cognizant, wipro and many more ')
@section('keywords', 'campus placement preparation, wipro placement papers, infosys placement papers, aptitude questions, amcat previous papers, amcat preparation,tcs nqt, tcs ninja, tcs digital')
@section('content')
<div class=" p-3 p-md-5" style="background:#f8f8f8">
<div class="container" style="">
  <div class="row ">
    <div class="col-12 col-md-7 ">
      <div class="display-4 mt-4 mb-4">Online assessments platform</div>
      <div class="display-1 mb-4" style="font-family: 'Anton', sans-serif;color:#56a">{{ request()->session()->get('client')->name}} </div>
      <div class="">
        <a href="{{ route('login')}}">
        <span class="btn btn-success  mr-3 mb-3">Login Now</span></a>
        <a href="{{ route('register')}}">
        <span class="btn btn-outline-primary  mr-3 mb-3">Regsiter</span></a>
  
      </div>
    </div>
    <div class="col-12 col-md-5">
      
  <img srcset="{{ asset('img/header.png') }}" class="w-100 d-none d-md-block" alt="xplore banner">
    </div>
  </div>
</div>
</div>


<div class="text-center text-md-left" style="background:#617cc5;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0 mt-5 mt-md-0'>
                <div class="icon mb-3"><i class="fa fa-trophy fa-3x"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'><b>Curated Tests</b></div>
                <p>Why solve a million questions when you can get away with solving only a few that matter? </p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-gg fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>AI Tools</div>
                <p>Advanced Artificial Intelligence tools will track user actions and filters the fraudsters.</p>
              </div>
            </div>
            <div class="col-12 col-md-3">
              <div class='item mb-5 mb-md-0'>
                <div class="icon mb-3"><i class="fa fa-expeditedssl fa-3x" aria-hidden="true"></i></div>
                <div class="icon heading_two mb-2" style='font-size: 20px;color:white'>Data encription</div>
                <p>Data encription provides deep security across network, and limits the access to secure resources. </p>
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





<div class="text-center text-md-left" style="background:#3a5294;color:white">
  <div class="p-2 p-md-4"></div>
  <div class="container">
    <div class="row">
            <div class="col-12 col-md-10">
              <div class='item heading_two' style='color: white;font-size:25px'>
               Incase of query reach out to us
              </div>
            </div>
            <div class="col-12 col-md-2">
              <div class='item '>
                <div class="icon mb-3 mt-4 mt-md-0">
                  <a href="{{ route('contact')}}" class="btn btn-light w-100"> Contact Us</a>
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