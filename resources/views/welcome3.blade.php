@extends('layouts.app2')

@section('title', 'PacketPrep - The best platform to prepare for Campus Placements')

@section('description', 'Get the best material for campus placement preparation, our courses include aptitude, reasoning, programming and coding.')

@section('keywords', 'campus placement preparation, prepare for campus placements,learn quantitative aptitude,learn reasoning, learn verbal,learn programming concepts,learn coding for interview')

@section('content')
<div class="bg-white p-3 p-md-5">
<div class="container" style="">
  <div class="row ">
    <div class="col-12 col-md-8 ">
      <div class="display-4 mt-4 mb-4">The best platform to prepare for</div>
      <div class="display-1 mb-4" style="font-family: 'Anton', sans-serif;color:#236fb1">CAMPUS PLACEMENTS</div>
      <div class="">
        <a href="{{ route('course.show','quantitative-aptitude')}}">
        <span class="btn btn-outline-success  mr-3 mb-3">Quantitative Aptitude</span></a>
        <a href="{{ route('course.show','logical-reasoning')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Logical Reasoning</span></a> 
        <a href="{{ route('course.show','mental-ability')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Mental Ability</span></a>    
        <a href="{{ route('course.show','verbal-ability-1')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Verbal Ability</span></a>    
        <a href="{{ route('course.show','interview-skills')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Interview Skills</span></a>  
        <a href="{{ route('course.show','programming-concepts-interviews')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Programming Concepts</span></a>   
        <a href="{{ route('course.show','coding-for-interviews')}}">
        <span class="btn btn-outline-success mr-3 mb-3">Coding</span></a> 

  
      </div>
    </div>
    <div class="col-12 col-md-4">
      <img src="{{ asset('img/banner-sm.png') }}" class="w-100 d-none d-md-block" alt="packetprep banner">
    </div>
  </div>
</div>
</div>

<main role="main" style="z-index:-100;" >

<div class=" " style="background: #e5f3ff;">
  <div class="container">

          <div class="pt-4 pb-4 pt-md-5 pb-md-5">
          <div class="row">
              <div class="col-12 col-md-6">
<div class=" p-4 rounded  mb-4 mb-md-0" style="background:white;border:1px solid #b7d0e6;">
<div class="row">
  <div class="col-12 col-md-4 ">
    <div class="col-6 col-md-12">
    <img src="{{ asset('img/coding.png')}}" class="w-100 mt-3 mb-3" alt="coding bootcamp" />
  </div>
  </div>
  <div class="col-12 col-md-8">
     <b><i class="fa fa-code"></i> Coding Bootcamp -  Realtime Project</b><hr>
<p>Build your first web application with PacketPrep's 10-day classroom training. Complement your skills with a real-time project and a completion certificate. </p>
<a href="{{ url('bootcamp') }}">
<button class="btn btn-outline-secondary">Reserve your seat</button>
</a>
  </div>

</div> 
</div>
              </div>

              <div class="col-12 col-md-6">
<div class=" p-4 rounded " style="background:white;border:1px solid #b7d0e6;">
<div class="row">
  <div class="col-12 col-md-4">
    <div class="col-6 col-md-12">
    <img src="{{ asset('img/world.png')}}" class="w-100 mt-3 mb-3" alt="want to pursue masters abroad?"/>
  </div>
  </div>
  <div class="col-12 col-md-8">
      <b><i class="fa fa-ravelry"></i> Want to pursue Masters abroad? </b><hr>
<p>Attend a free session of GRE or IELTS, or take a mock test, or talk to industry experts who can answer your questions in person! Did we tell you this is free?</p>
<a href="{{ url('firstacademy')}}">
<button class="btn btn-outline-primary">More details</button>
</a>
  </div>

</div> 
</div>
              </div>
          </div>
          
        </div>


  </div>
</div>
<div class="" style="background: #fff;">
  <div class="container marketing  " >

    <div class="p-4 p-md-5"></div>
    <div class="display-3 mb-5 text-center">Why PacketPrep?</div>
    <div class="p-0 p-md-2"></div>
    <div class="row ">
      <div class="col-lg-4 mb-5 mb-md-0">
       <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516688" title="Learning made Simple, Interesting and Effective" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4 "><div class="mb-2">Learning made </div> Simple, Interesting and Effective</h2>
        <p>Learning is no longer boring! Amusing introductions, crisp lectures, and effective strategies all make solving the toughest of questions a breeze!  </p>
        
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 mb-5 mb-md-0">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516712" title="Industry leading Question bank for campus placements" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4"><div class="mb-2">Industry leading Question bank </div>for campus placements</h2>
        <p>Why solve a million questions when you can get away with solving only a few that matter? Each of our concept lectures is followed by a small set of questions that will make you ace your placement tests.</p>
        
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 ">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516729" title="Get Proficienct at grabbing opportunities" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4"><div class="mb-2">Get Proficienct at</div> grabbing opportunities</h2>
        <p>PacketPrep's Certificate of Verification provides prospective employers (company or institutions) an iron-clad assurance that you have successfully completed an online course. <a href="{{ url('proficiency-test')}}" class="btn btn-sm btn-outline-secondary">Try now</a></p>
        
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->

    <div class="p-4 p-md-5"></div>
    


  </div><!-- /.container -->
</div>
<div class=" " style="">
  <div class="container">
        <div class="p-4 p-md-5"></div>
    <div class="display-3 mb-5 text-center">Students Feedback</div>
    <div class="p-0 p-md-2"></div>

    <div class="row">
            @for($i=1;$i<13;$i++)
            <div class="col-12 col-md-6">
              <img class="example-image p-1" src="img/youtube/{{$i}}.png"  width="100%" alt="student feedback {{$i}}" />
            </div>
            @endfor
        </div>
        <div class="p-4 p-md-5"></div>
  </div>
</div>

</main>




@endsection    


