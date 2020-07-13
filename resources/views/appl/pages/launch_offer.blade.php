@extends('layouts.app')
@section('title', 'Xplore - Launch Offer')
@section('content')


<div class="bg-white">
<div class="card-body p-4 ">
<h1>Worried about Campus Placements?</h1>

<div class="row">
	<div class="col-12 col-md-8">
		<p>
 Launching the one stop online Learning and Assessment portal for all your knowledge and placement support services.</p>

 <ul>
	<li> Access to exclusive online video content on aptitude, logical, mental ability,
programming & Interview Skills</li>
<li>Timeline Mock & Practice Tests of Top MNCs with graphical reports of your performance analysis</li>
<li>Verifiable e-certificate that counts as first level interview for some of our client organizations</li>
<li>Get this opportunity to take part in India's first and largest online</li>
<li>Career fair starts from July 27th during this pandemic with 40+ top Companies and around 2,000+ Jobs openings</li>

</ul>
<span class="badge badge-warning">Inaugral Offer</span><br>
<div class="display-3 mb-3" >Rs. <span >100</span></div>

<a href="https://xplore.co.in/productpage/aptitude-course" class="btn btn-primary btn-lg">Buy Now</a>
	</div>
	<div class="col-12 col-md-4">
		<img src="{{ asset('img/launch_offer.jpg')}}" class="py-2 mb-3 w-100"  />
	</div>
</div>


</div>		
</div>
@endsection           