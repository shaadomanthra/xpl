@if($cameratest)
<div class="bg-light border rounded p-3 camera_fail mb-3" style="display:none">

	<p>This test requires access to the webcamera. Kindly activate camera before proceeding. Incase of any query kindly reach out to the administration.</p>
</div>

<div class="bg-light border rounded p-3 camera_success mb-3" style="display:none">
	<video id="video" class="mb-3 bg-light " width="300px" >Video stream not available.</video>
	<canvas id="canvas" style='display: none'>
	</canvas>
	<b>Camera test is successful. Proceed to the test.</b>
</div>
@endif