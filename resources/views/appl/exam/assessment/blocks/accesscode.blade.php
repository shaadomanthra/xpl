				
				@if($exam->status!=1 && !$attempt && !$entry)
						
					@if(trim(strip_tags($exam->emails)))

					   @auth
					   @if(strpos(strtolower($exam->emails),trim(strtolower(\auth::user()->email)))!==false)
					   	<div class=" mb-2" >
				       <a href="{{route('assessment.access',$exam->slug)}}">
				       	<button class="btn btn-lg btn-outline-primary accesscode_btn" > Access Code </button>
						</a>
						</div>
						@else
						<div class="bg-light border rounded p-3">You are not authorised to attempt this test.</div>
						@endif
				       @else
				       <div class=" mb-2" >
				       <a href="#" data-toggle="modal" data-target="#myModal2">
				       	<button class="btn btn-lg btn-outline-primary accesscode_btn" > Access Code </button>
						</a>
						</div>
				       @endauth

					
					@else

					   @auth
					   	
				       <a href="{{route('assessment.access',$exam->slug)}}">
				       @else
				       <a href="#" data-toggle="modal" data-target="#myModal2">
				       @endauth

						<button class="btn btn-lg btn-outline-primary accesscode_btn" > Access Code </button>
						</a>

					@endif

				@else

					@if($exam->status!=1 && !$entry)
					   @auth
				       <a href="{{route('assessment.access',$exam->slug)}}">
				       @else
				       <a href="#" data-toggle="modal" data-target="#myModal2">
				       @endauth
						<button class="btn btn-lg btn-outline-primary accesscode_btn" > Access Code </button>
						</a>
					@endif

					@if($exam->status==1)
						 @auth
				       <a href="{{route('assessment.instructions',$exam->slug)}}">
				       @else
				       <a href="#" data-toggle="modal" data-target="#myModal2">
				       @endauth
						<button class="btn btn-lg btn-outline-primary accesscode_btn" > Try Now </button>
						</a>
					@endif

				@endif