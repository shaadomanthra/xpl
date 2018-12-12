@extends('layouts.nowrap-product')
@section('content')
<div class=" p-4   text-white mb-4 border-bottom" style="background: linear-gradient(to top, rgba(39, 174, 96,0.7), rgb(35, 113, 178)), url({{asset('img/bg/13.jpg')}}); height: stretch;background-repeat: no-repeat;background-size: auto;
-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
  <div class="wrapper mb-3">  
  <div class="container ">
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-12 col-md-8">
          <h1 class="mt-2 mb-4 mb-md-2"> Be a <span class="badge badge-warning">PRIME USER</span> and get<br>

      </h1>
      <div class="display-3 mb-3">  Complete Access to</div>
              <div class="display-1 text-bold mb-3" style="font-weight: 900">  PacketPrep Services </div>
              <div class="display-3 pb-5">  for 2 years at just <span class="text-warning" style="font-weight: 800"><i class="fa fa-rupee "></i> 2000</span></div>
               @if(!$entry)
              
              <a href="{{ route('checkout')}}?product=premium-access">
                <button class="btn btn-outline-light btn-lg">Buy Now</button>
              </a>
              @else
              <div class=" border p-3 rounded">You have Premium Access to content valid till &nbsp;
                 <span class="badge badge-primary">{{ date('d M Y', strtotime(\auth::user()->products->find('9')->pivot->valid_till)) }}</span>
                 
               </div>
              @endif
        </div>
       
        

      </div>
      

              
    </div>
    <div class="col-12 col-md-4">

   
      </div>

  </div>
  </div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >  
    
      <div class="row ">
        <div class="col-12 col-md-8 ">
          <div class=" p-4  rounded mb-4" style="background: rgba(75, 192, 192, 0.2); border:1px solid rgba(75, 192, 192, 1);">
          <div class="">
            <h1 class="pb-2 mb-3" style="border-bottom:1px solid rgba(75, 192, 192, 1);"> Description</h1>
            <div class="h5">Quantitiative Aptitude | 120 Lessons | 1000+ Questions | 5 Online Tests</div>
            <p>Quantitative Aptitude is the most important requisite for clearing any competitive exam. We have designed this course to help you master the core concepts of quant with ease.</p>
            <div class="h5">Mental Ability | 12 Lessons | 2000+ Questions | 5 Online Tests</div>
            <p>General mental ability is one of the prime topics of most of the entrance examinations. The mental ability problems, test the reasoning & interpretation skills of candidates.</p>
            <div class="h5">Logical Reasoning | 8 Lessons | 500+ Questions | 5 Online Tests</div>
            <p>This course dramatically improves your chances of passing logical reasoning with top scores. The course includes detailed explanation of important concepts, practice questions, tips and tricks.</p>
            <div class="h5">Interview Skills | 20 Lessons </div>
            <p>So you’ve got an interview lined up? are you ready for it? check out our video resource which highlights important techniques that will help you nail your next interview</p>
            
          </div>
          </div>
      </div>
      <div class="col-12 col-md-4 ">
          <div class=" p-4  rounded mb-4" style="background: #fff6d4; border:1px solid #e4ce6b">
          <div class="">
            <h1> Access to <br>Proficiency Test</h1>
            <p class="">Packetprep Proficiency test is a systematic means of testing a candidate's abilities to perform specific tasks and react to a range of different situations. The assessment calibrates various factors like Numerical reasoning, verbal reasoning, abstract reasoning, speed, accuracy, and other such abilities.</p>
            <p> All the participants will be provided with a Digital Performance Certificate.A verified certificate from PacketPrep can provide proof for an employer, company or other institution that you have successfully completed an online course and took the assessment.</p>
          </div>
          </div>
      </div>



      

     </div>   
</div>

@endsection           
