<div class="row">
	<div class="col-12 col-md-8">
		@foreach($questions as $qno=>$question)
		 
		
		@if($question->answer)
		 <div class="mt-1">
		 @include('appl.content.article.blocks.question')
		 </div>
		 	@if(($qno+1)%5==0)
			<div class="mt-4">
			@include('snippets.adsense')
			</div>
			@endif
		@else
		<div class="mt-1">
		 @include('appl.content.article.blocks.explanation')
		</div>
		 	@if(($qno+1)%3==0)
			<div class="mt-4">
			@include('snippets.adsense')
			</div>
			@endif
		@endif 
		
		@endforeach

	</div>
	<div class="col-12 col-md-4">
		@include('appl.content.article.blocks.qno')
	</div>
</div>