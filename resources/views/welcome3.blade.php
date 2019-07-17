@extends('layouts.app2')

@section('title', 'PacketPrep - The best platform to prepare for Campus Placements')

@section('description', 'Get the best material for campus placement preparation, our courses include aptitude, reasoning, programming and coding.')

@section('keywords', 'campus placement preparation', 'prepare for campus placements','learn quantitative aptitude','learn reasoning', 'learn verbal','learn programming concepts','learn coding for interview')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">
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
      <img src="{{ asset('img/banner.png') }}" class="w-100 d-none d-md-block" >
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
    <img src="{{ asset('img/coding.png')}}" class="w-100 mt-3 mb-3" />
  </div>
  </div>
  <div class="col-12 col-md-8">
     <b><i class="fa fa-code"></i> Coding Bootcamp -  Realtime Project</b><hr>
<p>Build your first commercial web application with us at PacketPrep. It's a 10-day intensive classroom training on web development with a real-time project and certificate. </p>
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
    <img src="{{ asset('img/world.png')}}" class="w-100 mt-3 mb-3" />
  </div>
  </div>
  <div class="col-12 col-md-8">
      <b><i class="fa fa-ravelry"></i> Are you planning for MS in Abroad? </b><hr>
<p>PacketPrep offers all its users an opportunity to attend a GRE or IELTS session, take a test, and get industry acclaimed expert counselling <br>- all for free! </p>
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

  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

<div class="" style="background: #fff;">
  <div class="container marketing  " >

    <div class="p-4 p-md-5"></div>
    <div class="display-3 mb-5 text-center">Why PacketPrep?</div>
    <div class="p-0 p-md-2"></div>
    <!-- Three columns of text below the carousel -->
    <div class="row ">
      <div class="col-lg-4 mb-5 mb-md-0">
       <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516688" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4 "><div class="mb-2">We made learning </div> Simple, Interesting and Effective</h2>
        <p>So far learning has been a boring experience, now we have made it simple, interesting and effective using funny introductions, crisp concept lectures and effective strategies to solve tough questions.  </p>
        
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 mb-5 mb-md-0">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516712" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4"><div class="mb-2">Best Question bank </div>for campus placements</h2>
        <p>There is no point in soving a million questions, instead solve 1000 questions that matter. Each concept lecture is followed by the important practice questions, sufficient to clear campus placements.</p>
        
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4 ">
        <div class="embed-responsive embed-responsive-16by9 border" style="background: #eee;">
          <iframe src="//player.vimeo.com/video/348516729" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        <h2 class="mb-3 mt-4"><div class="mb-2">Proficiency Test</div> for better opportunities</h2>
        <p>A verified certificate from PacketPrep can provide proof for an employer, company or other institution that you have successfully completed an online course and took the assessment. <a href="{{ url('proficiency-test')}}" class="btn btn-sm btn-outline-secondary">Try now</a></p>
        
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
              <img class="example-image p-1" src="img/youtube/{{$i}}.png"  width="100%"  />
            </div>
            @endfor
        </div>
        <div class="p-4 p-md-5"></div>
  </div>
</div>

</main>




@endsection    


