@extends('layouts.app2')
@section('title', 'Sample Tests | PacketPrep')
@section('description', 'Here the sample tests ')
@section('keywords', 'sample assessments')
@section('content')

@include('flash::message')
<div class="container">
	<img src="{{ asset('img/about_cover.jpg')}}" class="w-100"/>
      <div class="p-3 p-md-4 p-lg-5 bg-white company">

        <h1 class="mb-2"> Sample Assessments 
        </h1>
        <p class="mb-5">A right recruitment assessment tool makes the mundane tasks of recruitment easier by assessing job specific skills of candidates before interview. It helps you to gauge job applicant's knowledge, technical skills, cognitive ability, behavioral traits and language proficiency required for a particular job role.</p>
        
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4">
  <div class="card mb-4" >
    <div class="card-body">
      @if(file_exists('img/test.png'))
      <img 
      src="{{ asset('img/test.png') }} " class=" pt-3 pb-3 pr-4"  height="120px">
      @endif
      <h4 class="card-title article">Mini Aptitude Test</h4>
      <p>The following test has 20 questions from quantitative aptitude, reasoning and programming.</p>
      @if(file_exists('img/companies/wipro.jpg'))
      <small><a href="https://packetprep.com/test/targettcs-mid1/details" class="btn btn-lg btn-primary"> Try Now <i class="fa fa-angle-right"></i></a></small>
      @endif
    </div>
  </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
  <div class="card mb-4" >
    <div class="card-body">
      @if(file_exists('img/quantitative-aptitude.png'))
      <img 
      src="{{ asset('img/quantitative-aptitude.png') }} " class=" pt-3 pb-3 pr-4"  height="120px">
      @endif
      <h4 class="card-title article">Quantitative Aptitude Test</h4>
      <p>The following test has 15 questions from arithmetic, algebra, geometry and data interpretation.</p>
      @if(file_exists('img/companies/tcs.jpg'))
      <small><a href="https://packetprep.com/test/quant1/details" class="btn btn-lg btn-primary"> Try Now <i class="fa fa-angle-right"></i></a></small>
      @endif
    </div>
  </div>
</div>

<div class="col-12 col-md-6 col-lg-4">
  <div class="card mb-4" >
    <div class="card-body">
      @if(file_exists('img/solar-system.png'))
      <img 
      src="{{ asset('img/solar-system.png') }} " class=" pt-3 pb-3 pr-4"  height="120px">
      @endif
      <h4 class="card-title article">Mental Ability Test</h4>
      <p>The following test has 15 questions from deductive logic, word sequence, conclusions and more.</p>
      @if(file_exists('img/companies/tcs.jpg'))
      <small><a href="https://packetprep.com/test/mental-ability-1/details" class="btn btn-lg btn-primary"> Try Now <i class="fa fa-angle-right"></i></a></small>
      @endif
    </div>
  </div>
</div>

<div class="col-12 col-md-6 col-lg-4">
  <div class="card mb-4" >
    <div class="card-body">
      @if(file_exists('img/crown.png'))
      <img 
      src="{{ asset('img/crown.png') }} " class=" pt-3 pb-3 pr-4"  height="120px">
      @endif
      <h4 class="card-title article">Logical Reasoning Test</h4>
      <p>The following test has 12 questions from assumptions, arguments and syllogisms.</p>
      @if(file_exists('img/companies/tcs.jpg'))
      <small><a href="https://packetprep.com/test/logical-reasoning-1/details" class="btn btn-lg btn-primary"> Try Now <i class="fa fa-angle-right"></i></a></small>
      @endif
    </div>
  </div>
</div>

<div class="col-12 col-md-6 col-lg-4">
  <div class="card mb-4" >
    <div class="card-body">
      @if(file_exists('img/crown.png'))
      <img 
      src="{{ asset('img/metrics.png') }} " class=" pt-3 pb-3 pr-4"  height="120px">
      @endif
      <h4 class="card-title article">Verbal Ability Test</h4>
      <p>The following test has 20 questions from Vocabulary, Grammar and Comprehension.</p>
      @if(file_exists('img/companies/tcs.jpg'))
      <small><a href="https://packetprep.com/test/amcat-sectiontest-s2.1/details" class="btn btn-lg btn-primary"> Try Now <i class="fa fa-angle-right"></i></a></small>
      @endif
    </div>
  </div>
</div>

        </div>
      </div>
    </div>
</div>
@endsection