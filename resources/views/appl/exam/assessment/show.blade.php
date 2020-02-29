@extends('layouts.app')
@section('title', $exam->name.' | PacketPrep')
@section('description', substr(strip_tags($exam->description),0,200))
@section('content')

<div class="mb-md-5 mb-2 mt-3">


		@if(file_exists('img/'.$exam->slug.'.jpg'))
	<img src="{{'/img/'.$exam->slug.'.jpg'}}" class="w-100"/>
	@else

	 @if(isset($exam->image))
      @if(Storage::disk('public')->exists($exam->image))
      <picture>
		  <img 
		      src="{{ asset('/storage/articles/'.$exam->slug.'.png') }} " class="w-100 d-print-none" alt="{{  $exam->name }}">
		</picture>
      @endif
      @endif
	@endif

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

				<p class="mb-3">
				{!! $exam->description  !!}
				</p>
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

				@if(\auth::user())
				@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','tpo']))
				<hr>
				<span class="badge badge-secondary"><i class="fa fa-user"></i> Placement Officer </span><br>
				<p class="lead mt-2">

				“For the things we have to learn before we can do them, we learn by doing them.”<br>
				- Aristotle
			</p>
				@endif
				@endif

				@if(\auth::user())
					

					@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','tpo']))
						<a href="{{ route('test.analytics',$exam->slug) }}">
	                  <button class="btn btn-lg btn-outline-info mb-3"> <i class="fa fas fa-bar-chart" ></i> College Analytics</button>
	                  </a>
					@endif

					@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
						<a href="{{ route('test.analytics',$exam->slug) }}?all=1">
	                  <button class="btn btn-lg btn-outline-secondary mb-3"> <i class="fa fas fa-bar-chart" ></i> Overall Analysis</button>
	                  </a>

	                  <hr>
	                  <h5>Access Codes</h5>
	                  @foreach( explode(',',$exam->code) as $c)
	                  	<a href="{{ route('test.analytics',$exam->slug) }}?all=1&code={{$c}}">
	                  <button class="btn btn-sm btn-outline-warning mb-3"> <i class="fa fas fa-bar-chart" ></i> {{$c}} </button>
	                  </a>
	                  @endforeach
					@endif

				@endif
		<br><br>
			</div>

		</div>
		
		
		
		

	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      {{
      		request()->session()->put('return',url()->current())
      }}
      
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-success">Login</button>
    	</a>
    	<a href="{{ route('student.eregister')}}">
        <button type="button" class="btn btn-primary">Register</button>
    	</a>
      </div>
    </div>
  </div>
</div>
@endsection           