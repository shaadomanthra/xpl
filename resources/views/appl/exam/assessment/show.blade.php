@extends('layouts.app')
@section('title', $exam->name.' | Xplore')
@section('description', substr(strip_tags($exam->description),0,200))
@section('content')

<div class=" mb-2 mt-3">


	<div class=" border p-3 bg-white rounded">
		<div class="row">
			<div class="col-12 col-md-2 ">
				<i class="fa fa-newspaper-o fa-5x p-3 d-none d-md-block" aria-hidden="true"></i>
				<i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
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
				  @if(!$attempt)
                  <a href="{{route('assessment.instructions',$exam->slug)}}">
				<button class="btn btn-lg btn-success"> Attempt Test </button>
				</a>
                  @endif
				@else
					@if($product)
						@if($exam->status ==1)
						<a href="{{route('assessment.instructions',$exam->slug)}}">
						<button class="btn btn-lg btn-success"> Attempt Test </button>
						</a>
						@else
				       <a href="{{route('productpage',$product->slug)}}">
						<button class="btn btn-lg btn-success"> Buy Now </button>
						</a>
						@endif
					@elseif($exam->status==1) <!-- free Test -->
					<a href="{{route('assessment.instructions',$exam->slug)}}">
					<button class="btn btn-lg btn-success"> Attempt Test </button>
					</a>
					@else
					@if($product)
					<a href="{{route('productpage',$product->slug)}}">
						<button class="btn btn-lg btn-success"> Buy Now </button>
					</a>
					@endif

					@endif

				@endif

				@if($exam->status!=1 && !$attempt)
				
				   @auth
			       <a href="{{route('assessment.access',$exam->slug)}}">
			       @else
			       <a href="#" data-toggle="modal" data-target="#myModal2">
			       @endauth

				<button class="btn btn-lg btn-outline-warning"> Access Code </button>
				</a>
				@endif

				@if($attempt)
				<a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-lg btn-success"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
                  </a>
				@endif

				<br><br>
			</div>

		</div>
		
		
		
		

	</div>




	@if(\auth::user())
	@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','tpo']))

	<div class="card mt-3 p-4 ">
		<div>
			<span class="badge badge-info"><i class="fa fa-user"></i> Placement Officer </span><br>
		</div>
		<p class="lead mt-2">

			“For the things we have to learn before we can do them, we learn by doing them.”<br>
			- Aristotle
		</p>

		<a href="{{ route('test.analytics',$exam->slug) }}">
			<button class="btn btn-lg btn-outline-info mb-3"> <i class="fa fas fa-bar-chart" ></i> College Analytics</button>
		</a>
		<div class="text-secondary"><small><b>NOTE:</b> This block is visible only to placement officer</small></div>
	</div>
	@endif
	@endif

@if(\auth::user())
@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
	<div class="card bg-light mt-3 p-4 ">
		<div class="mb-3">
			<span class="badge badge-secondary"><i class="fa fa-user"></i> Super Admin </span><br>
		</div>



		<a href="{{ route('test.analytics',$exam->slug) }}?all=1">
			<button class="btn btn-lg btn-outline-secondary mb-3"> <i class="fa fas fa-bar-chart" ></i> Overall Analysis</button>
		</a>
		<div class="text-secondary"><small><b>NOTE:</b> This block is visible only to Super Administrator</small></div>

	</div>
</div>
@endif
@endif

<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-success">Login</button>
    	</a>
      </div>
    </div>
  </div>
</div>
@endsection           