@extends('layouts.app')
@section('title', 'Sample Report | PacketPrep')
@section('content')


<div class="p-3  display-3 border rounded bg-white  mb-4"><i class="fa fa-bar-chart"></i> Student Assessment Report</div>

<div class="p-3 bg-white border mb-4">
	<div class="row">
		<div class="col-6 col-md-3">
			<div class="p-3">
			<img src="https://firstacademy.in/wp-content/uploads/2017/07/Preeti2.jpg" alt="..." class="img-thumbnail rounded-circle">
			</div>
		</div>
		<div class="col-12 col-md-9">
			<div class="p-3">
				<h1 class="text-primary">Preeti Mohanta</h1>
				<hr>
				<dl class="row">
					<dt class="col-sm-3">College</dt>
					<dd class="col-sm-9"> Biju Patnaik University of Technology </dd>
					<dt class="col-sm-3">Department</dt>
					<dd class="col-sm-9">BE - Electrical </dd>
					<dt class="col-sm-3">Year of Passing</dt>
					<dd class="col-sm-9">2018</dd>
					<dt class="col-sm-3">CGPA</dt>
					<dd class="col-sm-9">7.1</dd>
				</dl>
				<div></div>
				<div class=""></div>
			</div>
		</div>
	</div>
</div>

<div class="mb-md-5">
	<div class="">
		
		<div class="row">
			<div class="col-12 col-md-4 mb-3">
				<div class="card p-3" style="background: #F9FCE5;border: 2px solid #D1D3C5;color: #9D9792;">
					<div class="card-body">
						<div class="text-center p-3 pb-4 pt-4" style="height:264px">
						<img src="" style="width:120px;"  class="mb-3"/>
						
							<img src="{{ asset('/img/medals/excellent.png')}}" style="width:120px;"  class="mb-3"/>
						<div class="">Performance</div>
						<h1> Excellent</h1>
						</div>

					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 mb-3">
				<div class="card p-3 mb-4" style="background: #e8efff;border: 2px solid #bbc9db;color: #889dbd;">
					<div class="p-2 text-center">
						<h3><i class="fa fa-bookmark"></i> Score</h3>
						<div class="display-1">410</div>
						<div class="">out of 500</div>
					</div>
				</div>
				<div class="card p-3" style="background: #E8FFEF;border: 2px solid #BBDBC5;color: #5B8568;">
					<div class="p-2 text-center">
						<h3><i class="fa fa-thumbs-up"></i> Accuracy</h3>
						<div class="display-3">78%</div>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-4 mb-3">
				<div class="card p-3 mb-4" style="background: #e8efff;border: 2px solid #bbc9db;color: #889dbd;">
					<div class="p-2 text-center">
						<h3><i class="fa fa-bookmark"></i> Rank</h3>
						<div class="display-1">145</div>
						<div class="">out of 900</div>
					</div>
				</div>
				<div class="card p-3 mb-2" style="background: #E8FFEF;border: 2px solid #BBDBC5;color: #5B8568;">
					<div class="p-2 text-center">
						<h3><i class="fa fa-clock-o"></i> Avg Time </h3>
						<div class="display-3">3.25 min</div>
					</div>
				</div>
			</div>
		</div>

		

	</div>


	@if(isset($secs))
	<div class="row">
	@foreach($secs as $sec =>$section)
	
				<div class="col-12 col-md-6">
		<div class="card mb-3 bg-light mb-4"  style="background: #FFF;border: 2px solid #EEE;">
			<div class="card-header h3">
				<i class="fa fa-gg"></i> {{ $sec }}
			</div>
			<div class="card-body">
			

						<div class="p-2 " height="200px">
						<canvas id="{{$section->section_id}}Container" width="600" height="200px"></canvas>
						<div class="text-center mt-4">
							<span style="color:rgba(60, 120, 40, 0.8)"><i class="fa fa-square"></i> Excellent </span>

							&nbsp;<span style="color:rgba(60, 108, 208, 0.8)"><i class="fa fa-square"></i> Good </span>&nbsp;
							<span style="color:rgba(255, 206, 86, 0.9)"><i class="fa fa-square"></i> Average</span>
						&nbsp;<span style="color:rgba(219, 55, 50, 0.9)"><i class="fa fa-square"></i> Poor</span></div>
						<h3 class="text-center mt-3">Average Score - {{$section->average}}</h3>
					</div>
					<div class=" border p-3 rounded" style="background:#eee">
							<h3>Remarks</h3>
							<div>{!! $section->suggestion !!}</div>
					</div>
				</div>
				
			</div>
		</div>
		
		@endforeach
		</div>
		@endif

		<!--
		<div class=" p-3" style="background:#eee;border:1px solid #e4e4e4;">
			<h2 class="mb-3" >Future Aspirations</h2>

			<div class="row">
				<div class="col-6 col-md-3 mb-3 mb-md-0">
					<div class="bg-white border p-3  rounded text-center">
						<div class="mb-3 h3 text-center"><b class="text-center ">MTECH</b></div>
						<div class="">
							<i class="fa fa-times-circle fa-3x icon-times"></i>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-3">
					<div class="bg-white border p-3  rounded text-center">
						<div class="mb-3 h3 text-center"><b class="text-center ">MBA</b></div>
						<div class="">
							<i class="fa fa-times-circle fa-3x icon-times"></i>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-3">
					<div class="bg-white p-3 border rounded text-center">
						<div class="mb-3 text-center"><b class="text-center ">MS</b></div>
						<div class="">
							<i class="fa fa-check-circle fa-3x text-success"></i>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-3">
					<div class="bg-white p-3 border rounded text-center">
						<div class="mb-3 text-center"><b class="text-center ">JOB</b></div>
						<div class="">
							<i class="fa fa-check-circle fa-3x text-success"></i>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="border bg-white p-4 mt-4">
			<h3 class="display-3 mb-3">Comments for Hire</h3> 
			<div class="">
				<ul>
					<li>Based on the scores the candidate will be an <b><span class="text-success"><i class="fa fa-star"></i> EXCELLENT</span></b> fit for telephone response roles.</li>
					<li>The candidate shows great tendency towards <b><span class="text-warning"><i class="fa fa-circle"></i> Commitment </span></b> and <b><span class="text-warning"><i class="fa fa-clock-o"></i> Time management.</span></b></li>
					<li>The <b><span class="text-success"><i class="fa fa-star"></i> EXCELLENT</span></b> skills in domain specific knowledge will see the candidate perform in technical roles.</li>
					<li>Note: Based on the interests <b><span class="text-info"><i class="fa fa-plane"></i> MS in US</span></b> the candidate might leave the job in favour of higher studies.</li>
				</ul>
				 

			</div>
		</div>
	-->

</div>
@endsection           