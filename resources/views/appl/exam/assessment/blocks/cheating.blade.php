@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
		<div class="card mb-3 bg-light"  style="background: #FFF;border: 2px solid #EEE;">
			<div class="card-header">
				Cheating Detection
			</div>
			<div class="card-body">
			<div class="row mb-4">
				<div class="col-12 col-md-4">
					<div class="p-3 border rounded" height="">
						<h5>Window Swap</h5>
						<div class="display-4">
							@if($test_overall->window_change)
							{{$test_overall->window_change}}
							@else
							-
						@endif</div>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="p-3 border rounded" height="">
						<h5>Detected Faces</h5>
						<div class="display-4">
						@if($test_overall->face_detect)
							{{$test_overall->face_detect}}
						@else
							-
						@endif</div>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="p-3 border rounded" height="">
						<h5>Cheating</h5>
						<div class="display-4">
							@if($test_overall->cheat_detect==2)
							Not Clear
							@elseif($test_overall->cheat_detect==1)
							Potentially Yes
							@else
							Potentially No
							@endif
						</div>
					</div>
				</div>
			</div>
			@if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$user->username.'_'.$exam->id.'_1.jpg'))
			<div class="row mb-4">
				@for($i=1;$i<13;$i++)
					@if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg'))
					<div class='col-6 col-md-2'>
						<img src="{{ Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="w-100 mb-2" />
					</div>
					@endif
				@endfor
			</div>
			@if($count)
			<div class="my-4">Captured: {{$count}} images</div>
			<a href="{{ route('assessment.analysis',$exam->slug)}}?images=all&student={{$user->username}}" class="mt-3 btn-success btn-lg">view all images</a>
			@endif
			@endif


		</div>
		</div>
		@endif