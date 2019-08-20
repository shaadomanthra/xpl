@extends('layouts.plain')
@section('content')


<div class="p-3  bg-light border "> Carry the print out of the following page to FIRST ACADEMY Office to avail the discount</div>
<div  class="row p-5">

  <div class="col-md-12">
    <div class="row mb-5">
      <div class="col-12 col-md-5">
           <h2 class="display-3">Hi, {{ $user->name}}</h2>
      <p> Greetings from PacketPrep!</p>

      <p class="lead">"Develop a passion for learning.<br> If you do, you will never cease to grow "<br>- 
            Anthony J Dangelo</p>

                     <div class=" mb-3">
      <div class="">
        
        <dl class="row">
  @if($user->colleges()->first())        
  <dt class="col-sm-4">College Name</dt>
  <dd class="col-sm-8">{{ $user->colleges()->first()->name}}</dd>
  @endif

  @if($user->branches())
  <dt class="col-sm-4">Branch</dt>
  <dd class="col-sm-8">
  @foreach($user->branches()->get() as $branch)
    {{ $branch->name}} &nbsp;
  @endforeach
  </dd>
  @endif

  <dt class="col-sm-4">Roll Number</dt>
  <dd class="col-sm-8">
    {{ ($user->details)?$user->details->roll_number:'' }}
  </dd>

  <dt class="col-sm-4">Year of Passing</dt>
  <dd class="col-sm-8">
    {{ ($user->details)?$user->details->year_of_passing:'' }}
  </dd>
  <dt class="col-sm-4">Referral Code</dt>
  <dd class="col-sm-8">
    {{ (\request()->get('referral'))?  \request()->get('referral'):'' }}
  </dd>
  
</dl>  
  
  
    
        </div>
      </div>
      </div>
      <div class="col-12 col-md-7">
        
        <div class=""> 
          <h1> Company</h1> 
          <div class=""><img src="{{ asset('/img/fa_full_logo.png')}}" class="w-50 p-3 pt-0"/>    </div>
          <p>Platinum Partner - British Council. The most awarded training institute in South India. The most awesome classes on this side of the solar system.</p>
          <div class="">
            <b>Ameerpet Branch</b>
            <p>707 - 708, Pavani Prestige, Ameerpet,
Hyderabad, Telengana, 500016<br>
<b>Phone: </b>+91 98666 88666</p><br>
<b>Madhapur Branch</b>
            <p>2nd Floor, Pulla Reddy Sweets Building,
Opposite Metro Pillar MAD43, Hitech City Road<br>
<b>Phone: </b>+91 99666 66633</p>
          </div>
         

          
        </div>


      </div>

    </div>

    <hr>
    <div>

      <div class="row">
          <div class="col-12 col-md-6">
            <h1> Coupon Value</h1>
           
          <div class="display-3 mb-3 bg-light border p-3 rounded"><i class="fa fa-rupee"></i> 1000</div>
          

          <h1> Coupon Code</h1>
           
          <div class="display-1 mb-3">{{ strtoupper(substr(md5(mt_rand()), 0, 7)) }}</div>
          <br><br>
          </div>

        <div class="col-12 col-md-6">
          <h4>Instructions </h4>
          <ul>
            <li><b>Valid Till</b>: 31st July 2019</li>
            <li>This coupon is applicable only on the combo pack 
              <ul>
                <li>GRE + IELTS -  Rs. 24,000</li>
                <li>Premium GRE + IELTS  - Rs. 29,000</li>
              </ul>
            </li>
          </ul>
          </div>
      </div>

    </div>

             
    

      <hr>
      <img src="{{ asset('/img/packetprep-logo-small.png')}}" class="mb-4 float-right"/>
      <h3> About PacketPrep</h3>
      <p>
         PacketPrep, one stop learning platform for Bank exams, Government Exams and Campus Recruitment. With more than 200 video lectures, 5000+ practice questions and 100+ online tests, makes students learning simple interesting and effective. 
      </p>

      <h3> For Queries Contact</h3>
      <dl class="row">
  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9"> founder@packetprep.com</dd>
  <dt class="col-sm-3">Phone</dt>
  <dd class="col-sm-9"> +91 95151 25110</dd>
  <dt class="col-sm-3">website</dt>
  <dd class="col-sm-9"> packetprep.com</dd>
</dl>


    


        

     </div>
   </div>
 </div>

</div>


@endsection

