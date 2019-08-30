@if(\auth::user())
	@if($entry)
	<h2 class="mt-3">Valid till</h2>
	<div class="mb-3"><span class="badge badge-success">  {{date('d M Y', strtotime($entry->valid_till))}}</span></div>
		@if($entry->status ==1)
			@if(strtotime($entry->valid_till) > strtotime(date('Y-m-d')))
			<h2 class="mt-3">Status</h2>
			<div class="mb-3"><span class="badge badge-success">  Active</span></div>
			@else
			<h2 class="mt-3">Status</h2>
			<div class="mb-3"><span class="badge badge-danger">  Expired</span></div>
			<h1 class="mt-3" style="font-weight: 800"><i class="fa fa-rupee"></i> {{ $product->price }}</h1>
			<a href="{{ route('productpage',$product->slug) }}">
				<button class="btn btn-success btn-lg mt-3" >
					@if($product->price==0)
					Access Now
					@else
					<i class ="fa fa-shopping-cart"></i> Buy
					@endif
				</button>
			</a>
			@endif
		@elseif($entry->status == 0)
		<h2 class="mt-3">Status</h2>
		<div class="mb-3"><span class="badge badge-secondary">  Disabled</span></div>
		@endif
	@else
		@if($product)
		<h2 class="mt-3">Validity</h2>
		<div> {{ $product->validity}} months</div>

		<h1 class="mt-3" style="font-weight: 800"><i class="fa fa-rupee"></i> {{ $product->price }}</h1>
		<a href="{{ route('productpage',$product->slug) }}">
			<button class="btn btn-success btn-lg mt-3" >
				@if($product->price==0)
				Access Now
				@else
				<i class ="fa fa-shopping-cart"></i> Buy
				@endif
			</button>
		</a>
		@endif

	@endif
@else
	<h2 class="mt-3">Validity</h2>
	<div> {{ $product->validity}} months</div>
	<h1 class="mt-3" style="font-weight: 800"><i class="fa fa-rupee"></i> {{ $product->price }}</h1>
@endif


@if($course->intro_vimeo || $course->intro_youtube)
	<button class="btn btn-outline-primary btn-lg mt-3" data-toggle="modal" data-target="#myModal"><i class ="fa fa-video-camera"></i> Watch Intro</button>
@endif

@if(\auth::user())
	@if(\auth::user()->productvalidity($course->slug)==2)
	<a href="{{ route('productpage',$product->slug) }}"> 
		<button class="btn btn-success btn-lg mt-3" ><i class ="fa fa-shopping-cart"></i> Buy</button>
	</a>
	@endif
@else
	<a href="{{ route('productpage',$product->slug) }}">
		<button class="btn btn-success btn-lg mt-3" ><i class ="fa fa-shopping-cart"></i> Buy</button>
	</a>
@endif