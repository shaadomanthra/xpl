@extends('layouts.app-border')
@section('title', 'Test Instructions - '.$exam->name.'')
@section('content')


<div class="mb-md-5 mb-2 mt-3">
	<div class="">

	<div class=" border p-4 p-md-5 bg-white rounded">

	@if($exam->camera)
		<div class="ins_block ins_block_1 mb-3">
			<h3><i class="fa fa-bars  " aria-hidden="true"></i> Let's set up your test area</h3>
			<h5 class="mb-5">You must have everything below to start the test</h5>

			<p> <i class="fa fa-id-card text-info" ></i> &nbsp;&nbsp;&nbsp;Your Aadhar card, college id or other government issued photo ID</p>
			<p> <i class="fa fa-lightbulb-o  text-info" ></i> &nbsp;&nbsp;&nbsp; A quite well-lit room with no one else present </p>
			<p> <i class="fa fa-clock-o  text-info" ></i> &nbsp;&nbsp;&nbsp; {{$exam->time}} - {{($exam->time+10)}} minutes of free time to take the test </p>
			<p> <i class="fa fa-wifi  text-info" ></i> &nbsp;&nbsp;&nbsp; A reliable internet connection </p>
			<p> <i class="fa fa-camera  text-info" ></i> &nbsp;&nbsp;&nbsp; A computer/device with a front-facing camera </p>

			<a href="#" class="btn btn-lg btn-primary mt-3 btn-ins-next px-5" data-next="2"> Start</a>
			<a href="{{route('assessment.details',$exam->slug)}}" class="btn btn-lg btn-outline-danger mt-3 px-5"> Quit</a>
		</div>

		<div class="ins_block ins_block_2 mb-3"  style="display:none">
			<h3><i class="fa fa-bars  " aria-hidden="true"></i> Things to note</h3>
			<h5 class="mb-5">Disable all the desktop/mobile notifications throughout the test </h5>

			<p> <i class="fa fa-camera text-info" ></i> &nbsp;&nbsp;&nbsp;Do not leave the camera preview</p>
			<p> <i class="fa fa-caret-square-o-right   text-info" ></i> &nbsp;&nbsp;&nbsp; Do not look away from the screen </p>
			<p> <i class="fa fa-window-maximize   text-info" ></i> &nbsp;&nbsp;&nbsp; Do not leave your web browser </p>
			<p> <i class="fa fa-podcast text-info" ></i> &nbsp;&nbsp;&nbsp; Do not speak unless instructed</p>
			<p> <i class="fa fa-users  text-info" ></i> &nbsp;&nbsp;&nbsp; Do not allow others in the room with you </p>
			<p> <i class="fa fa-book text-info" ></i> &nbsp;&nbsp;&nbsp; Do not use any outside reference material </p>

			<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="1"> Prev</a>
			<a href="#" class="btn btn-lg btn-primary btn-ins-next mt-3 px-5" data-next="3"> Next</a>
		</div>


		<div class="ins_block ins_block_3 mb-3"  style="display:none">
			<h3><i class="fa fa-bars  " aria-hidden="true"></i> My Details</h3>
			<h5 class="mb-5">I confirm, the below details are correct </h5>

			
			<dl class="row">
				  <dt class="col-sm-2">Full Name</dt>
				  <dd class="col-sm-10">{{ auth::user()->name}}</dd>
				  <dt class="col-sm-2">College Name</dt>
				  <dd class="col-sm-10">{{ auth::user()->college->name}}</dd>
				  <dt class="col-sm-2">Branch</dt>
				  <dd class="col-sm-10">{{ auth::user()->branch->name}}</dd>
				  <dt class="col-sm-2">Roll Number</dt>
				  <dd class="col-sm-10">{{ auth::user()->roll_number}}</dd>
				  <dt class="col-sm-2">Email</dt>
				  <dd class="col-sm-10">{{ auth::user()->email}}</dd>
				  <dt class="col-sm-2">Phone Number</dt>
				  <dd class="col-sm-10">{{ auth::user()->phone}}</dd>
			</dl>

			<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="2"> Prev</a>
			<a href="#" class="btn btn-lg btn-primary btn-ins-next mt-3 px-5" data-next="4"> Next</a>
		</div>
		
		<div class="ins_block ins_block_4" style="display:none">
			<h3><i class="fa fa-bars  " aria-hidden="true"></i> Take a Selfie picture </h3>
			<h5 class="mb-5">This photo will be verified by the proctor</h5>

			<div class="row">
				<div class="col-12 col-md-4">
					<div class="bg-light border p-4 rounded mb-4 mb-md-0">
					<div class=" camera_success " >
						
						<video id="video2" class="w-100 " data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="0" data-c="300000" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}">Video stream not available.</video>

						
					</div>
					<a href="#" class="btn btn-lg btn-success selfie_capture px-5"  style="" > Capture</a>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<canvas id="canvas2" class="border" width="250px"></canvas>
					<img id="photo2" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="0" data-c="0" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}" style='display: none'> 
				</div>
			</div>

			<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="3"> Prev</a>
			<a href="#" class="btn btn-lg btn-primary mt-3 btn-ins-next px-5" data-next="5"> Next</a>
		</div>

		<div class="ins_block ins_block_5" style="display:none">
			<h3><i class="fa fa-bars  " aria-hidden="true"></i> Take a picture of your Photo ID card</h3>
			<h5 class="mb-5">This photo id will be verified by the proctor</h5>

			<div class="row">
				<div class="col-12 col-md-4">
					<div class="bg-light border p-4 rounded mb-4 mb-md-0">
					<div class=" camera_success " >
						
						<video id="video" class="w-100 id_card_capture" data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="0" data-c="200000" data-username="{{\auth::user()->username}}" data-test="{{$exam->id}}">Video stream not available.</video>

						
					</div>
					<a href="#" class="btn btn-lg btn-success id_capture px-5"  style="" > Capture</a>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<canvas id="canvas" class="border" width="250px"></canvas>
					<img id="photo" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="{{ route('img.post') }}" data-count="0" data-c="0" data-username="{{\auth::user()->username}}" data-name="{{\auth::user()->name}}" data-roll="{{\auth::user()->rollnumber}}" data-college="{{\auth::user()->college->name}}"
					data-branch="{{\auth::user()->branch->name}}"  data-test="{{$exam->id}}" style='display: none' data-bucket="{{ env('AWS_BUCKET')}}" data-region="{{ env('AWS_DEFAULT_REGION')}}"> 
				</div>
			</div>

			<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="4"> Prev</a>
			<a href="#" class="btn btn-lg btn-primary mt-3 btn-ins-next px-5" data-next="6"> Next</a>
		</div>


		<div class="ins_block ins_block_6" style="display:none">
		<h3><i class="fa fa-bars  " aria-hidden="true"></i> {{ $exam->name }}  - Instructions</h3>
		{!! $exam->instructions  !!}
		
		<hr>
		<div class="form-check">
			<h5 class="text-info">Kindly accept the terms to start the test</h5>
		    <input type="checkbox" class="form-check-input" id="terms">
		    <label class="form-check-label" for="terms">I have read and understood the instructions. I declare that I am not in possession of any prohibited material with me. I agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test and/or to disciplinary action, which may include ban from future Tests / Examinations.</label>
		 </div>
		&nbsp;&nbsp;&nbsp;&nbsp;<br>

		@if($exam->camera)
		<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="5"> Prev</a>
		@endif

		<a href="#" class="btn btn-lg btn-primary mt-3 btn-ins-next px-5 btn-accept disabled" data-next="7">
		Accept and Proceed
		</a>
	</div>

		@if(strtolower($exam->settings->manual_approval)=='yes')
			<div class="ins_block ins_block_7" style="display:none">
				<h3><i class="fa fa-bars  " aria-hidden="true"></i> Awaiting proctors approval</h3>
				<h5 class="mb-5">
					<div class="spinner-border spinner-border-sm" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
				Test will start in few minutes</h5>

				<div class="message"></div>

				<div class="row">
					<div class="col-12 col-md-4">
						<div class="bg-light border rounded p-3 mb-3 mb-md-0">
							<h5><i class="fa fa-picture-o"></i> Selfie Photo</h5>
						<div class="selfie_container"></div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="bg-light border rounded p-3">
							<h5><i class="fa fa-vcard"></i> ID Card Photo</h5>
						<div class="idcard_container"></div>
						</div>
					</div>
				</div>

				<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="6"> Prev</a>
			</div>
		@endif

			@if($exam->examtype->name=='api')
			<a href="{{ env('API_URL').$exam->slug.'/try?id='.auth::user()->id.'&source='.env('APP_NAME').'&username='.auth::user()->username.'&private=1&uri='.route('assessment.analysis',$exam->slug) }}" class='btn btn-lg btn-primary mt-3 btn-accept d-none test_link'>
			@else
			<a href="{{route('assessment.try',$exam->slug)}}@if(request()->get('code'))?code={{ request()->get('code') }}@endif" class='btn btn-lg btn-primary mt-3 btn-accept d-none test_link'>
			@endif Next</a>

	@else

		<div class="ins_block ins_block_5" @if($exam->camera)  style="display:none" @endif>
		<h3><i class="fa fa-bars  " aria-hidden="true"></i> {{ $exam->name }}  - Instructions</h3>
		{!! $exam->instructions  !!}
		
		<hr>
		<div class="form-check">
			<h5 class="text-info">Kindly accept the terms to start the test</h5>
		    <input type="checkbox" class="form-check-input" id="terms">
		    <label class="form-check-label" for="terms">I have read and understood the instructions. I declare that I am not in possession of any prohibited material with me. I agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test and/or to disciplinary action, which may include ban from future Tests / Examinations.</label>
		 </div>
		&nbsp;&nbsp;&nbsp;&nbsp;<br>

		@if($exam->camera)
		<a href="#" class="btn btn-lg btn-outline-secondary btn-ins-next mt-3 px-5" data-next="4"> Prev</a>
		@endif

		@if(isset($exam->examtype))
			@if($exam->examtype->name=='api')
			<a href="{{ env('API_URL').$exam->slug.'/try?id='.auth::user()->id.'&source='.env('APP_NAME').'&username='.auth::user()->username.'&private=1&uri='.route('assessment.analysis',$exam->slug) }}" class='btn btn-lg btn-primary mt-3 btn-accept disabled'>
			@else
			<a href="{{route('assessment.try',$exam->slug)}}@if(request()->get('code'))?code={{ request()->get('code') }}@endif" class='btn btn-lg btn-primary mt-3 btn-accept disabled'>
			@endif
		@else
			<a href="{{route('assessment.try',$exam->slug)}}@if(request()->get('code'))?code={{ request()->get('code') }}@endif" class='btn btn-lg btn-primary mt-3 btn-accept disabled'>
		@endif
		Accept and Proceed
		</a>
	</div>

	@endif
		
	</div>
	<p class="bg-light border rounded p-3" style="margin-top:-5px;">Incase of any query, write to us at <span class="text-info">info@xplore.co.in</span> or call us at <span class="text-info">1800-890-1324</span></p>
	</div>
</div>
@endsection           