<div class="row">
	<div class="col-12 col-md-8">
		@foreach($questions as $qno=>$question)
		 
		
		@if($question->answer)
		 <div class="mt-1">
		 @include('appl.content.company.blocks.question')
		 </div>
		 	@if(($qno+1)%5==0)
			<div class="mt-4">
			@include('snippets.adsense')
			</div>
			@endif
		@else
		<div class="mt-1">
		 @include('appl.content.company.blocks.explanation')
		</div>
		 	@if(($qno+1)%3==0)
			<div class="mt-4">
			@include('snippets.adsense')
			</div>
			@endif
		@endif 
		
		@endforeach

		<div class="bg-light border p-3 mt-4 mb-4">
			@include('appl.pages.disqus')
		</div>
	</div>
	<div class="col-12 col-md-4">
		@include('appl.content.company.blocks.qno')
	</div>
</div>