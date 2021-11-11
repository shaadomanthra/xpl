@extends('layouts.app-border')
@section('title', 'Access Code - '.$exam->name.' ')
@section('content')

<div class="mb-md-5 mb-2 mt-3">
	<div class="container">


	<div class=" border p-3 bg-white rounded">
		@include('flash::message')
		<div class="row">
			<div class="col-12 col-md-2">
				@if(isset($exam->image))
	      @if(Storage::disk('public')->exists($exam->image))
	      <picture>
			  <img 
      src="{{ asset('/storage/'.$exam->image) }} " class="w-100 d-print-none" alt="{{  $exam->name }}" style='max-width:200px;'>
			</picture>
	      @endif
	  @else
	  <i class="fa fa-newspaper-o fa-5x p-3 d-none d-md-block" aria-hidden="true"></i>
				<i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>

      @endif
			</div>
			<div class="col-12 col-md-8">
				<h1 class="mt-3">
					
					{{ $exam->name }} @if($exam->status ==2)
					<span class="badge badge-warning ">
					<i class="fa fa-lock" aria-hidden="true"></i>  PRIVATE
				</span>
					@else
					<span class="badge badge-warning ">
					<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> FREE ACCESS
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