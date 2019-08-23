<div class="row">
	<div class="col-12 col-md-8">
		@foreach($questions as $qno=>$question)
		 
		<div class="mt-1">
		 @include('appl.content.company.blocks.question')
		</div>
		@endforeach
	</div>
	<div class="col-12 col-md-4">
		@include('appl.content.company.blocks.qno')
	</div>
</div>