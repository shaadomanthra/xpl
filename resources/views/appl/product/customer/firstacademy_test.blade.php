@extends('layouts.nowrap-product')
@section('title', 'First Academy - Discount Coupon for GRE & IELTS  | PacketPrep')
@section('description', '')
@section('keywords', 'summer internship, coding, bootcamp, engineering students, ')

@section('content')

<div class=" p-0 pt-3  pt-md-4 pb-md-0 border-bottom " style="background: #e7f4ff;" >
  <div class="wrapper ">  
  <div class="container">
    <div class="row mb-3 mb-md-4">
      <div class="col-12 col-md-8">
        <div class=" p-3  mb-3 rounded" style="border:1px solid #bfddf7; background: #fff;">
            <div class="col-3 mb-3 mt-3 ">
              <img src="{{ asset('img/education.png')}}" class="w-100 " />
            </div>
            <div class="p-3">
            <h1>Dear Student,</h1>
            <p> Greetings from PacketPrep !
            <p class="" >Your mock test has been scheduled for <b><span class="text-primary">21st July (Sunday) at 10:00AM</span></b> at First Academy (Ameerpet Branch). </p>
            

            <p>Did you know the mock test comes with a Free counselling session for visas and applications to universities? </p>
            <a href="https://forms.gle/KwaPFX1hdRo5vgtb8">
            <button class="btn btn-success mb-4">I will attend</button>
            </a>
            <p class="text-secondary"><i>Note: The offer is valid only for this session.</i></p>

            <p>regards,<br>PacketPrep Team
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class=" p-3  rounded" style="border:1px solid #bfddf7;background: #ecf6ff;">
            <div class="col-3 mb-3 mt-3 ">
              <img src="{{ asset('img/map.png')}}" class="w-100 " />
            </div>
            <div class="p-3">
            <h1>Location</h1>
            <p class="text-secondary" ><h4>First Academy</h4> 707 - 708, Pavani Prestige,<br>R S Brothers Building,<br> near Metro Station, Ameerpet, Hyderabad.</p>
            <p>040 4003 3825<br> +91 98666 88666</p>
            Google Map : <a href="https://goo.gl/maps/6ZFh2VrcwV5j5Xyx5" >https://goo.gl/maps/6ZFh2VrcwV5j5Xyx5</a>
          </div>
        </div>
      </div>
     

    </div>

    </div>
  </div>
</div>


</div>

@endsection           