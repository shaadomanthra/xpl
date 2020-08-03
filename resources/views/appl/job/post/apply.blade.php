	@auth
		@if($obj->users->contains(\auth::user()->id))
		<div class="alert alert-info alert-important" role="alert">
		  <h4 class="mb-0">You have applied for this job </h4>
		</div>
		@else
			@if(\carbon\carbon::parse($obj->last_date)->gte(\carbon\carbon::now()))
				@if(auth::user()->branch_id && auth::user()->college_id && auth::user()->year_of_passing)
					@if(auth::user()->bachelors < $obj->academic)
					<div class="alert alert-info alert-important" role="alert">
				 	 <p class="mb-0" >The following job opening requires a minimum academic percentage of {{$obj->academic}}% in bachelors. </p><hr>
				 	 Your Academic percentage is {{auth::user()->bachelors}}. <br> <a href="{{ route('profile.complete')}}?redirect={{request()->url()}}">update your profile</a> to apply for this job.
					</div>
					@elseif(!in_array(auth::user()->branch->name,explode(',',$obj->education)))
					<div class="alert alert-info alert-important" role="alert">
				 	 <p class="mb-0" >The following job opening is only for {{str_replace(',',', ',$obj->education)}}. </p><hr>
				 	 Your branch is {{auth::user()->branch->name}}. <br> <a href="{{ route('profile.complete')}}?redirect={{request()->url()}}">update your profile</a> to apply for this job.
					</div>
					@else
					<a href="{{ route('job.show',$obj->slug)}}?apply=1" class="btn btn-lg btn-success w-100 ">Apply Now</a>
					@endif
				@else
				<a href="#" data-toggle="modal" class="btn btn-lg btn-success w-100 " data-target="#myModal3">Apply Now</a>
				@endif
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