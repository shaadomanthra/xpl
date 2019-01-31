@extends('layouts.nowrap-product')
@section('title', 'Referral Program | PacketPrep')
@section('description', 'Refer 3 students and get 3 months access to pracketprep premium services')
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
      <p>Refer 3 students and get 3 month pro-access to premium aptitude content. It includes 200+ video lectures, 5000+ practice questions and numerous online assessments on various topics of qunatitative aptitude, logical reasoning, mental ability and interview skills.</p>
      <div class="mt-4 p-4 border rounded mb-4">
        <h2> Referral Link</h2>
        @guest
        Login to get the referral link
        @else
        <a href="{{ route('student.eregister') }}?code={{\auth::user()->username}}">{{ route('student.eregister') }}?code={{\auth::user()->username}}</a>
        @endguest
      </div>

      <div class="mt-4 p-4 border rounded mb-4">
        <h2> Referrals</h2>
        @guest
        @else
          <div class="row mb-4">
            <div class="col-12 col-md-4">
              <div class="border p-4">
                <div class=""><b>First</b></div>
                {{ ($user->referrals->get(0))?$user->referrals->get(0)->name : ' - NA -'}}
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
                {{ ($user->referrals->get(2))?$user->referrals->get(2)->name : ' -  '}}
              </div>
            </div>
          </div>

          @if(count($user->referrals)>=3)
            @if(!$product)
            <a href="{{ route('proaccess')}}"><button class="btn btn-lg btn-outline-primary"> Pro Access</button></a>
            @else
              <h2 class="badge badge-warning">PRO ACCESS Granted</h2>
            @endif
          @else
          <h2 class="badge badge-danger">Status : 3 Refferals not reached</h2>
            
          @endif

        @endguest
      </div>
		</div>
	</div>
</div>
</div>
</div>




@endsection           