@extends('layouts.app')
@section('title', 'Test Details - '.$exam->name.' | PacketPrep')
@section('content')

<div class="mb-md-5 mb-2 mt-3">
	<div class="container">


	<div class=" border p-3 bg-white rounded">
		<div class="row">
			<div class="col-12 col-md-2">
				<i class="fa fa-newspaper-o fa-5x p-3" aria-hidden="true"></i>
			</div>
			<div class="col-12 col-md-8">
				<h1 class="mt-3">
					
					{{ $exam->name }} @if($exam->status ==2)
					<span class="badge badge-primary ">
					<i class="fa fa-lock" aria-hidden="true"></i>  PREMIUM
				</span>
					@else
					<span class="badge badge-warning ">
					<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> FREE
				</span>
					@endif</h1>
				{!! $exam->description  !!}
				@if($entry)
				<a href="{{route('assessment.instructions',$exam->slug)}}">
				<button class="btn btn-lg btn-success"> View Instruction </button>
				</a>
				@else
				@if($exam->products->first())
				<a href="{{route('productpage',$exam->products->first()->slug)}}">
				<button class="btn btn-lg btn-success"> Buy Now </button>
				</a>
				@elseif($exam->status==1)
				<a href="{{route('assessment.instructions',$exam->slug)}}">
				<button class="btn btn-lg btn-success"> View Instruction </button>
				</a>
				@endif

				@endif
		<br><br>
			</div>

		</div>
		
		
		
		
	</div>
	</div>
</div>
@endsection           