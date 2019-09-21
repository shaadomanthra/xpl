@extends('layouts.nowrap-product')
@section('title', 'Referral Program | PacketPrep')
@section('description', 'Refer 3 students and get 12 month pro access to GRAND MASTER PACKAGE')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interesting, logical reasoning, general english, interview skills, packetprep referral')

@section('content')
<div class="line" style="padding:1px;background:#eee"></div>
<div class=" p-4  mb-3 mb-md-4 border-bottom bg-white">
	<div class="wrapper ">  
	<div class="container">
	<div class="row">
    <div class="col-12 col-md-4">
       <div class="float-right ">
          <img src="{{ asset('/img/referral.jpg')}}" class="w-100 p-3 pt-0"/>    
      </div>
    </div>
		<div class="col-12 col-md-8">
			<h1 class="mt-2 mb-4 mb-md-2">
			<i class="fa fa-handshake-o"></i> &nbsp;Referral Benefits
			
			</h1>
      <p>Help us reach more people ! </p>
      <p>Refer 3 students and get 12 month pro access to 'GRAND MASTER PACKAGE'. It includes 300+ video lectures, 10000+ practice questions and numerous online assessments on various topics of quantitative aptitude, logical reasoning, mental ability, programming concepts, coding and interview skills.</p>
      <div class="mt-4 p-4 border rounded mb-4">
        <h2> Referral Link</h2>
        @guest
        Login to get the referral link
        @else
        <a href="{{ route('student.'.$type.'register') }}?code={{$user->username}}">{{ route('student.'.$type.'register') }}?code={{$user->username}}</a>
        @endguest
      </div>

      @guest
      
        

      @else
      <div class="mt-4 p-4 border rounded mb-4">
        <h2> Message to share on whatsup/facebook</h2>
        <p> Hi Guys, <br><br>A great opportunity!<br><br>PacketPrep - an ed-tech company specialized in training students to crack recruitment exams of MNCs like TCS, Infosys, Wipro, Capgemini, Delloite and many more.</p>
        <p> Their premium service includes 300+ video lectures, 10000 practice questions and numerous online assessments on various topics of quantitative aptitude, logical reasoning, mental ability, programming concepts, coding and interview skills.</p>
       
        <p>Use the following registration link to get access to Rs.7000 worth of material for FREE.
         <br><a href="{{ route('student.'.$type.'register') }}?code={{$user->username}}">{{ route('student.'.$type.'register') }}?code={{$user->username}}</a></p>
        <p> regards, <br>
          {{\auth::user()->name}}
        </p>
      </div>
      <div class="mt-4 p-4 border rounded mb-4">


        <h2 class="mb-3"> Referrals({{ count($user->referrals)}}) <a href="{{route('referral')}}" class="btn btn-sm btn-success float-right">view all</a></h2>
          <div class="row mb-4">
            <div class="col-12 col-md-4">
              <div class="border p-4">
                <div class=""><b>First</b></div>
                {{ ($user->referrals->get(0))?$user->referrals->get(0)->name : ' - '}}
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="border p-4">
                <div class=""><b>Second</b></div>
                {{ ($user->referrals->get(1))?$user->referrals->get(1)->name : ' - '}}
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="border p-4">
                <div class=""><b>Third</b></div>
                {{ ($user->referrals->get(2))?$user->referrals->get(2)->name : ' - '}}
              </div>
            </div>
          </div>


          @if(count($user->referrals)>=3)
            @if(!$product)
            <a href="{{ route('grandmaster')}}"><button class="btn btn-lg btn-outline-primary"> Grand Master Program</button></a>
            @else
              <h2 class="badge badge-warning">ACCESS Granted - Grand Master Pack</h2>
            @endif
          @else
          <h2 class="badge badge-danger">Status : 3 Refferals not reached</h2>
          @endif

        
      </div>
      @endguest

      <div class="mt-4 p-4 border rounded mb-4">
        <h3><i class="fa fa-certificate"></i> Brand Promoter Certificate</h3>
        <p>Reaching <span class="text-info"><i>50 referrals</i></span> can get you a valuable certificate from packetprep</p>
        <p> A verified certificate from PacketPrep can provide proof for an employer, company or other institution that you have leadership ability to execute tasks with agility.</p>
         @guest
           <p><a href="{{ route('certificate.brandpromoter','sample')}}"><button class="btn btn-outline-primary">Sample Certificate</button></a></p>
         @else
          @if(count($user->referrals)>=50)
            <a href="{{ route('certificate.brandpromoter',\auth::user()->username)}}"><button class="btn btn-outline-primary">My Certificate</button></a>
          @else
          <h2 class="badge badge-danger">Status : 50 Refferals not reached</h2>
          <p><a href="{{ route('certificate.brandpromoter','sample')}}"><button class="btn btn-outline-primary">Sample Certificate</button></a></p>
          @endif
         @endguest
        
      </div>
		</div>
	</div>
</div>
</div>
</div>




@endsection           