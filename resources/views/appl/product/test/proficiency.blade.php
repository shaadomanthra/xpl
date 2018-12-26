@extends('layouts.nowrap-product')
@section('title', 'Proficiency Test - Digital Certificate | PacketPrep')
@section('content')
<div class=" p-4  bg-white mb-4 border-bottom">
  <div class="wrapper ">  
  <div class="container">
  <div class="row">
    <div class="col-12 col-md-8">
      <h1 class="mt-2 mb-4 mb-md-2">
      <i class="fa fa-gg"></i> &nbsp;Proficiency Test
      </h1>
    </div>
    <div class="col-12 col-md-4">

    @if(!$entry)
      <a href="{{ route('checkout') }}?product=proficiency-test">
      <button class="btn btn-outline-primary float-right mt-2">Buy Now</button>
      </a>
      <h2 class="float-right mr-4 mt-3"><i class="fa fa-rupee"></i> 1000</h2>
      @else
        @if(!$exam->attempted())
        <a href="{{ route('assessment.instructions','proficiency-test') }}">
        <button class="btn btn-outline-primary float-right mt-2">Take Test</button>
        </a>
        @else
        <a href="{{ route('assessment.analysis','proficiency-test') }}">
        <button class="btn btn-outline-primary float-right mt-2">Test Analysis</button>
        </a>
        <a href="{{ route('certificate',['proficiency-test',\auth::user()->username]) }}">
        <button class="btn btn-outline-success float-right mt-2 mr-3">View Certificate</button>
        </a>
        @endif
      @endif 
      </div>

  </div>
  </div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >  
    
      <div class="row ">
        <div class="col-12 ">
          <div class=" p-4 rounded mb-4" style="background: rgba(255, 232, 105, 0.68) !important;border:1px solid yellow;">
        <div class="row">
          <div class="col-12 col-md-9">

              <h1> About the test</h1>
              

              <p>Packetprep Proficiency test is a systematic means of testing a candidate's abilities to perform specific tasks and react to a range of different situations. The assessment calibrates various  factors like Numerical reasoning, verbal reasoning, abstract reasoning, speed, accuracy, and other such abilities.</p>
              <p>The use of aptitude and knowledge tests to screen potential job applicants has long been standard practice across many different sectors.  As such they have become an important and integral part of the overall interview process.</p>
          </div>
          <div class="col-12 col-md-3">
            <img src="{{ asset('/img/test.png')}}" class="w-100 p-4"/>
          </div>
        </div>
        </div>
      </div>
      </div>

      <div class="row ">

        <div class="col-12 ">
          <div class="bg-white p-4 border rounded mb-4">
        <h1 class="bg-light p-3 border mb-3"> Syllabus</h1>
        <div class="row">
          <div class="col-12 col-md-6">

            <h3> Quantitative Aptitude</h3>
            <div class="row">
            <div class="col-12 col-md-6">
              <ul>
              <li>Number System</li>
              <li>LCM HCF</li>
              <li>Decimal Fractions</li>
              <li>Simplifications</li>
              <li>Squares and Square Roots</li>
              <li>Average</li>
              <li> Problems on Numbers</li>
              <li>Problems on Ages</li>
              <li>Surds and Indices</li>
              <li>Percentage</li>
              <li>Profit and Loss</li>
              <li>Partnership</li>
              <li>Chain Rule</li>
              <li>Time and Work</li>

            </ul>

            </div>
            <div class="col-12 col-md-6">
              <ul>

              <li>Pipes and Cisterns</li>
              <li>Time and Distance</li>
              <li>Problems on Trains</li>
              <li>Boats and streams</li>
              <li>Alligation or Mixture</li>
              <li>Simple Interest</li>
              <li>Compound Interest</li>
              <li>Logarithms</li>
              <li>Area</li>
              <li>Volume and Surface Area</li>
              <li>Calendar</li>
              <li>Clocks</li>
              <li>Permutation and Combinations</li>
              <li>Probability</li>
              <li>Heights and Distances</li>
            </ul>
            </div>
            </div>
            
          </div>
          <div class="col-12 col-md-3">
            <h3> Mental Ability</h3>
            <ul>
              <li>Series Completion</li>
              <li>Analogy</li>
              <li>Sequential Output Tracing</li>
              <li>Classification</li>
              <li>Logical Venn Diagrams</li>
              <li>Direction Sense Test</li>
              <li>Logical Sequence of Words</li>
              <li>Assertion and Reason</li>
              <li>Situation Reaction Test</li>
              <li>Verification of Truth of the statement</li> 
              

            </ul>
          </div>
          <div class="col-12 col-md-3">
            <h3> Logical Reasoning</h3>
            <ul>
              <li>Logic</li>
              <li>Deriving Conclusions from passages</li>
              <li>Assumptions</li>
              <li>Arguments</li>
              <li>Courses of Action </li>
              <li>Conclusions</li>
              <li>Cause and Effect Reasoning </li>
              

            </ul>
          </div>

        </div>
    </div>
    </div>
      </div>

      <div class="row mb-4">
        <div class="col-12 col-md-12">
          <div class="bg-success text-white p-3 rounded">
            <h1> <i class="fa fa-certificate"></i> Performance Certificate</h1>
            <p>A verified certificate from PacketPrep can provide proof for an employer, company or other institution that you have successfully completed an online course and took the assessment. </p>
            

            @if(!$entry)
      <a href="{{ route('certificate.sample') }}">
      <button class="btn btn-outline-light">View Sample</button>
      </a>
      @else
        @if(!$exam->attempted())
        <a href="{{ route('certificate.sample') }}">
        <button class="btn btn-outline-light">View Sample</button>
        </a>
        @else
        <a href="{{ route('certificate',['proficiency-test',\auth::user()->username]) }}">
        <button class="btn btn-outline-light  ">View Certificate</button>
        </a>
        @endif
      @endif 


          </div>
        </div>
      </div>


      

     </div>   
</div>

@endsection           
