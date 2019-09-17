<div class="row mt-3">
	<div class="col-12">
		<div class="progress progress-sm" style="height:3px">
			<div class="progress-bar bg-success" role="progressbar" style="width: {{ $categories->$cid->correct_percent}}%" aria-valuenow="{{ $categories->$cid->correct}}" aria-valuemin="0" aria-valuemax="100"></div>
			<div class="progress-bar bg-danger" role="progressbar" style="width: {{ $categories->$cid->incorrect_percent}}%" aria-valuenow="{{ $categories->$cid->incorrect}}" aria-valuemin="0" aria-valuemax="100"></div>
		</div>

	</div>
</div>