	@auth
		@if($obj->users->contains(\auth::user()->id))
		<div class="alert alert-info alert-important" role="alert">
		  <h4 class="mb-0">You have applied for this job </h4>
		</div>
		@else
			@if(\carbon\carbon::parse($obj->last_date)->gt(\carbon\carbon::now()))
			<a href="{{ route('job.show',$obj->slug)}}?apply=1" class="btn btn-lg btn-success w-100 ">Apply Now</a>
			@else
			<div class="alert alert-info alert-important" role="alert">
		 	 <h4 class="mb-0">Job is closed </h4>
			</div>
			@endif
		@endif
	@else
		<a href="#" data-toggle="modal" class="btn btn-lg btn-success w-100 " data-target="#myModal2">
		Apply Now</a>
	@endauth