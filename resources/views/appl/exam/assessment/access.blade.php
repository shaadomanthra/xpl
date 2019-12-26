@extends('layouts.app')
@section('title', 'Access Code - '.$exam->name.' | PacketPrep')
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
				
				<div class="p-4 border rounded bg-light mt-4 mb-4">
				<form method="get" action="{{route('assessment.instructions',$exam->slug)}}" >
					<input type="text" class="form-control mb-3" value="" placeholder="Enter the Access Code" name="code"/>

					<button class="btn btn-primary">Submit</button>
				</form>
			</div>
			</div>

		</div>
		
		
		
		
	</div>
	</div>
</div>
@endsection           