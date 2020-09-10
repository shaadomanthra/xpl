
@if($cameratest)

@if(isMobileDevice())
	
	@if($exam->extra)
	<div class="bg-light border rounded p-3 camera_fail mb-3 extra_info" >
		<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test can be attempted from desktop or laptop only. Mobile & Tablets are not allowed. Kindly contact administrator incase of any query.</span></p>
	</div>
	@else

	<div class="bg-light border rounded p-3 camera_fail mb-3" style="display:none">
	<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test requires access to the webcamera. Kindly activate camera before proceeding. Incase of any query kindly reach out to the administration. <hr> Kindly use only google chrome browser.</span></p>
</div>
	@endif

@else
<div class="bg-light border rounded p-3 camera_fail mb-3" style="display:none">
	<p><i class="fa fa-times-circle text-danger "></i> <span class="camera_message">This test requires access to the webcamera. Kindly activate camera before proceeding. Incase of any query kindly reach out to the administration. <hr> Kindly use only google chrome browser.</span></p>
</div>

@endif

<div class="bg-light border rounded p-3 camera_success mb-3" style="display:none">
	
	<video id="video" class="mb-3 bg-light " width="300px" >Video stream not available.</video>
	<canvas id="canvas" style='display: none'>
	</canvas>
	<div><i class="fa fa-thumbs-up text-success"></i> Camera test is successful. Proceed to the test.</div>
</div>
@endif