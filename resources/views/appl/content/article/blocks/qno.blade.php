<div class="sticky-top pt-3">
<div class="card mb-3 text-white d-none d-md-block blogd mb-3" style="background:#ca2428">
	<div class="card-body">
		<h3 class="mb-3"><i class="fa fa-th"></i> Questions ({{count($questions)}}) </h3>
		<div class="qset" style="max-height: 240px;overflow-y: auto; ">
		<div class="row no-gutters">
		@foreach($questions  as $kno => $question)
			<div class="col-3 mb-1">
				<div class="pr-1">
					<div class="w100 p-1  kno s{{ ($kno+1 ) }} text-center rounded qborder qgreen_border" data-qno="{{$kno+1}}"
						>{{ ($kno+1 ) }}</div>
					</div>
				</div>
		@endforeach
		</div>
		</div>
	</div>
</div>

@include('snippets.adsense')
</div>
