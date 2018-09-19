@extends('layouts.nowrap-corporate')

@section('content')


@if(!auth::user())
<div class="pr-5 pt-5 pl-5 pb-4" style="max-width:500px;margin:0px auto;">
			<div class="text-center mt-0 mt-mb-0" >
				<img src="{{ asset('/img/243.png')}}"  width="100%"/>
			</div>
		</div>

<div class="text-center mb-5 p-3">
		<div class="titlea" >Online Library</div>
		<div class="subtitlea" >A white labelled digital learning product for colleges</div>
</div>

<div class=" pt-5 pb-3 p-md-5 pb-md-5" style="background:#3f9c77">

    <div class="container text-center text-white">
                    <h1 class="titlea mb-5"> The Product</h1>
               
                     <div class="embed-responsive embed-responsive-16by9">
        <iframe src="//player.vimeo.com/video/212122806"></iframe>
    </div>
                
        
    </div>
    </div>

  <div class=" p-5" style="background:#4dbdd0">

    <div class="container  text-white">
        <div class="text-center pb-5"><h1 class="titlea"> Product Features </h1></div>
        <div class="row">
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-youtube-play"></i> High Quality Videos</h2>
                <p class="pb-5" style="color:#99e4f1">Professionally shot, high quality video lectures with focus on content relavent to competitive exams.</p>
                <h2><i class="fa fa-list-alt"></i> Practice Questions</h2>
                <p class="pb-5" style="color:#99e4f1">More than 1500 practice questions, which have been asked in previous govt and bank exams.</p>
            </div>
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-user"></i> Student Friendly</h2>
                <p class="pb-5" style="color:#99e4f1">We have built the learning modules to makes student learning simple, interesting and effective.</p>
                <h2><i class="fa fa-puzzle-piece"></i> Mock Tests</h2>
                <p class="pb-5" style="color:#99e4f1">Timed bound tests have been included to give a real time experience of Competitive exams.</p>
            </div>
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-paper-plane"></i> Learn on Go</h2>
                <p class="pb-5" style="color:#99e4f1">Online learning  make it easy to prepare for exams from any location and at student convenient time.</p>
                <h2><i class="fa fa-bar-chart"></i> Performance Analytics</h2>
                <p class="pb-5" style="color:#99e4f1">Detailed analytics for pactice and  tests will help student to track his mistakes and work on it.  </p>
            </div>
        </div>
                
        
    </div>
    </div> 

      <div class=" p-5" style="background:#485d71">

    <div class="container  text-white">
        <div class="text-center pb-5"><h1 class="titlea">Corporate Benefits </h1></div>
        <div class="row">
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-desktop"></i> Digital Presence</h2>
                <p class="pb-5" style="color:#939da7">This is the right opportunity to expand your reach globally by offering online courses</p>
            </div>
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-graduation-cap"></i> Academic Progress</h2>
                <p class="pb-5" style="color:#939da7"> Your students can take the atmost advantage in their academics with these digital courses</p>
            </div>
            <div class="col-12 col-md-4">
                <h2><i class="fa fa-rupee"></i> Recurring Revenue</h2>
                <p class="pb-5" style="color:#939da7">These online courses can be offered to students year on year which opens the doors for recurring revenue</p>
            </div>
        </div>
                
        
    </div>
    </div> 
  <div class=" p-5" style="background:#34495d">

    <div class="container  text-white">
        <div class="text-center pb-5"><h1 class="titlea"> Why Us?</h1></div>
        <div class="row">
            <div class="col-12 col-md-4">
                <p><i class="fa fa-5x fa-cogs"></i></p>
                <h2> Hastle Free Installation</h2>
                <p class="pb-5" style="color:#69839c">We will setup a dedicated website with content, with you college branding </p>
            </div>
            <div class="col-12 col-md-4">
                <p><i class="fa fa-5x fa-wrench"></i></p>
                <h2>Periodic Maintenance</h2>
                <p class="pb-5" style="color:#69839c">We take the responsibility to maintain your website with zero downtime</p>
            </div>
            <div class="col-12 col-md-4">
                <p><i class="fa fa-5x fa-phone-square"></i></p>
                <h2> Technical Support</h2>
                <p class="pb-5" style="color:#69839c">Our team will be available for immediate tech support and any other issues</p>
            </div>
        </div>
                
        
    </div>
    </div>  
@endif

@if(auth::user())

<div class="container">
<div class="mb-4  mt-4 bg-white p-4">

    <div class="row">
        <div class="col-md-7 p-4">
            <div class="row mt-2 ">
                <div class="col-12 col-md-3">
                    <img class="img-thumbnail rounded-circle mb-3" src="{{ Gravatar::src(auth::user()->email, 140) }}">
                </div>
                <div class="col-12 col-md-9">

                    <h2>Hi, {{ auth::user()->name}}</h2>
            <p> Welcome aboard</p>

            <p class="lead">We are here to empower the colleges <br> with digital learning modules.</p>

            
            <a class="btn border border-success text-success mt-2" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" role="button">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

                </div>
            </div>
        </div>
        <div class="col-md-5 d-none d-md-block p-4">
            <div class="text-center mt-0 mt-mb-0">
                <img src="{{ asset('/img/678.jpg')}}" width="380px"/>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">

            <div class="col-12 col-md-8">
                <div>
                    <h1> <u>Account Details</u></h1>
                    <dl class="row">
                      <dt class="col-sm-3">Name</dt>
                      <dd class="col-sm-9">{{ $client->name }}</dd>

                      <dt class="col-sm-3">Website</dt>
                      <dd class="col-sm-9"><a href="https://{{ $client->slug}}.onlinelibrary.co" ><span class="badge badge-warning">{{ $client->slug}}.onlinelibrary.co</span></a></dd>

                      <dt class="col-sm-3">Credit Points</dt>
                      <dd class="col-sm-9"><h1>0 / {{ $client->getCreditPoints() }}</h1></dd>
                      <dt class="col-sm-3">Package</dt>
                      <dd class="col-sm-9">{{ $client->getPackageName() }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="bg-light p-3 border rounded">
                <h1> Buy Credits  </h1>
                <form method="post" action="{{ route('payment.order')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="form-group mb-2">
                    <label for="exampleFormControlSelect1" class="mb-2">Credit Rate - <i class="fa fa-rupee"></i> <span class="credit_rate">{{ $client->getOfferRate()}}</span> / credit</label>
                    <input class="form-check-input" type="hidden" name="type" id="exampleRadios1" value="paytm" >
                    <br>
                    <input class="form-control credit_count" type="text" name="credit_count"  value="10"  >
                    
                    <input class="form-check-input" type="hidden" name="package" id="exampleRadios1" value="credit">
                    <input class="form-check-input" type="hidden" name="credit_rate"  value="{{$client->getPackageRate()}}">
                    <input class="form-check-input" type="hidden" name="txn_amount"  value="1">
                    <div class="mt-3 display-4"><i class="fa fa-rupee"></i><span class="price"> 200000</span></div>
                    <br>
                  <button class="btn btn-lg btn-outline-primary" type="submit">Buy via PayTM</button> 
                  <hr>
                  <p> The credit Rate calculation is given <a href="{{ route('credit-rate') }}">here</a></p>
                </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



@endif


@endsection           