
	@auth
		@if($userdata)
		<div class="alert alert-info alert-important" role="alert">
		  <h4 class="mb-0">You have applied for this job </h4>


		  <hr>
		  @if($userdata->pivot->shortlisted=="YES")
		  <h2>Status : <span class="badge badge-primary">Shortlisted</span></h2>
		  @elseif($userdata->pivot->shortlisted=="MAY BE")
		  <h2>Status : <span class="badge badge-secondary ">Under Review</span></h2>
		  @elseif($userdata->pivot->shortlisted=="NO")
		  <h2>Status : <span class="badge badge-danger">Rejected</span></h2>
		  @else
		  <h2>Status : <span class="badge badge-warning">Applied</span></h2>
		  @endif

		</div>
		@else
			@if(\carbon\carbon::parse($obj->last_date)->gte(\carbon\carbon::now()))
				@if(auth::user()->branch_id && auth::user()->college_id && auth::user()->year_of_passing )
					@if(auth::user()->bachelors < $obj->academic)
					<div class="alert alert-info alert-important" role="alert">
				 	 <p class="mb-0" >The following job opening requires a minimum academic percentage of {{$obj->academic}}% in bachelors. </p><hr>
				 	 Your Academic percentage is {{auth::user()->bachelors}}. <br> <a href="{{ route('profile.complete')}}?redirect={{request()->url()}}">update your profile</a> to apply for this job.
					</div>
					@elseif(!in_array(auth::user()->year_of_passing,explode(',',$obj->yop)))
					<div class="alert alert-info alert-important" role="alert">
					<p class="mb-0" >The following job opening is only for {{str_replace(',',', ',$obj->yop)}} passed out candidates. </p><hr>
					 	 Your Year of passing is {{auth::user()->year_of_passing}}. <br> <a href="{{ route('profile.complete')}}?redirect={{request()->url()}}">update your profile</a> to apply for this job.
					</div>
					@elseif(!Storage::disk('s3')->exists('resume/resume_'.\auth::user()->username.'.pdf'))
					 <div class="alert alert-info alert-important" role="alert">
					<p class="mb-0" >Your resume is not uploaded to xplore platform. You can update it here <a href="{{route('resume.upload')}}?redirect={{request()->url()}}">Update Resume</a> </p>
					</div>
					@elseif(!in_array(auth::user()->branch->name,explode(',',$obj->education)))

						@if(!in_array('OTHER',explode(',',$obj->education)))
						<div class="alert alert-info alert-important" role="alert">
					 	 <p class="mb-0" >The following job opening is only for {{str_replace(',',', ',$obj->education)}}. </p><hr>
					 	 Your branch is {{auth::user()->branch->name}}. <br> <a href="{{ route('profile.complete')}}?redirect={{request()->url()}}">update your profile</a> to apply for this job.
						</div>
						@else
							
						<a href="#" data-toggle="modal" class="btn btn-lg btn-success w-100 " data-target="#myModal4">Apply Now</a>
						@endif
					@else
					<a href="#" data-toggle="modal" class="btn btn-lg btn-success w-100 " data-target="#myModal4">Apply Now</a>
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