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

			@if($count['webcam'])
			<div class="row mb-4 {{$m=0}}">
				@if(isset($images['webcam']))
				@foreach($images['selfie'] as $k=>$f)
				@if(Storage::disk('s3')->exists($f))
				<div class='col-6 col-md-2 {{$m=$m+1}}'>
						<img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-2" />
					</div>
				@endif
				@endforeach
				@foreach($images['idcard'] as $k=>$f)
				@if(Storage::disk('s3')->exists($f))
				<div class='col-6 col-md-2 {{$m=$m+1}}'>
						<img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-2" />
					</div>
				@endif
				@endforeach

				@foreach($images['webcam'] as $k=>$f)
				@if(Storage::disk('s3')->exists($f))
				<div class='col-6 col-md-2 {{$m=$m+1}}'>
						<img src="{{ Storage::disk('s3')->url($f) }}" class="w-100 mb-2" />
					</div>
				@endif
				@if($m==12)
					@break
				@endif

				@endforeach
				@endif
				
			</div>
			@if($count['webcam'])
			<div class="my-4"><b>View :</b> <a href="{{ route('test.snaps',$exam->slug)}}?type=snaps&username={{$user->username}}" class="">Webcam images </a>| <a href="{{ route('test.snaps',$exam->slug)}}?type=screens&username={{$user->username}}" class=""> Screenshot images</a> | <a href="{{ route('test.logs',$exam->slug)}}?username={{$user->username}}" class=""> Detailed Logs</a></div>
			
			@endif
			@endif


		</div>
		</div>
		@endif