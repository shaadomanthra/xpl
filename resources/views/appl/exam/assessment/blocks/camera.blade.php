
@if($cameratest)


@if(isMobileDevice())
	
	@if($exam->extra)
	<div class="bg-light border rounded p-3 camera_fail mb-3 extra_info" >
		<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test can be attempted from desktop or laptop only. Mobile & Tablets are not allowed. Kindly contact administrator incase of any query.</span></p>
	</div>
	@else

	<div class="bg-light border rounded p-3 camera_fail mb-3" style="display:none">
	<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test requires access to the webcamera. Kindly activate camera before proceeding. Incase of any query, write to us at <span class="text-info">info@xplore.co.in</span> or call us at <span class="text-info">1800-890-1324</span>.</span></p>
</div>
	@endif

@else


<div class="bg-light border rounded p-3 camera_fail mb-3" style="display:none">
	<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test requires access to the webcamera. Kindly activate camera before proceeding. Incase of any query, write to us at <span class="text-info">info@xplore.co.in</span> or call us at <span class="text-info">1800-890-1324</span>.</span></p>
</div>

@endif

<div class="bg-light border rounded p-3 camera_success mb-3" style="">
	
	<video id="video" class="mb-3 bg-light " width="200px" >Video stream not available.</video>
	<canvas id="canvas" style='display: none'>
	</canvas>
	<img id="photo" alt="The screen capture will appear in this box." data-token="{{ csrf_token() }}" data-hred="" data-count="" data-c="50000" data-username="" data-test="{{$exam->id}}"  data-uname="" data-last_photo="" style='display: none'> 
	<div class="camera_success_message" style="display: none"><i class="fa fa-thumbs-up text-success"></i> Camera test is successful. Proceed to the test.</div>
</div>
@endif
