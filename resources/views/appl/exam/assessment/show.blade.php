@extends('layouts.app-border')
@section('title', $exam->name.' ')
@section('description', substr(strip_tags($exam->description),0,200))
@section('content')

<div class="mb-md-5 mb-2 mt-3">


		

	<div class=" border p-3 bg-white rounded" style="min-height:300px;">
		<div class="row">
			<div class="col-12 col-md-2 mt-3 ml-3">


	 @if(isset($exam->image))
	      @if(Storage::disk('s3')->exists($exam->image))
	      <picture>
			  <img 
      src="{{ Storage::disk('s3')->url($exam->image) }} " class="w-100 d-print-none" alt="{{  $exam->name }}" style='max-width:200px;'>
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
					<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> OPEN
				</span>
					@endif</h1>

				<p class="mb-3">
				{!! $exam->description  !!}
				</p>
				@include('appl.exam.assessment.blocks.camera')
				@if($entry)
				  @if(!$attempt)
                  <a href="{{route('assessment.instructions',$exam->slug)}}">
				<button class="btn btn-lg btn-success accesscode_btn"> Attempt Test </button>
				</a>
                  @endif
				@else
					@if($product)
						@if($exam->status ==1)
						<a href="{{route('assessment.instructions',$exam->slug)}}">
						<button class="btn btn-lg btn-success accesscode_btn"> Attempt Test </button>
						</a>
						@else
				       <a href="{{route('productpage',$product->slug)}}">
						<button class="btn btn-lg btn-success"> Buy Now </button>
						</a>
						@endif
                  	@elseif($exam->slug == '34781' && $user->posts->contains(4))
                    <a href="{{route('assessment.instructions',$exam->slug)}}">
					<button class="btn btn-lg btn-success accesscode_btn"> Attempt Test </button>
					</a> 
					@elseif($exam->slug != '34781' && $exam->status==1) <!-- free Test -->
					<a href="{{route('assessment.instructions',$exam->slug)}}">
					<button class="btn btn-lg btn-success accesscode_btn"> Attempt Test </button>
					</a>
					@else

					@if($product)
					<a href="{{route('productpage',$product->slug)}}">
						<button class="btn btn-lg btn-success"> Buy Now </button>
					</a>
					@else
					<div class="bg-light border rounded p-3">You are not authorised to attempt this test.</div>
					@endif

					@endif

				@endif


				@if($exam->status!=1 && !$attempt)
				
				@if(trim(strip_tags($exam->emails)))

				   @auth
				   @if(strpos(strtolower($exam->emails),strtolower(\auth::user()->email))!==false)
				   	
			       <a href="{{route('assessment.access',$exam->slug)}}">
			       	<button class="btn btn-lg btn-outline-primary accesscode_btn"> Access Code </button>
					</a>
					@else
					<div class="bg-light border rounded p-3">You are not authorised to attempt this test.</div>
					@endif
			       @else
			       
			       <a href="#" data-toggle="modal" data-target="#myModal2">
			       	<button class="btn btn-lg btn-outline-primary accesscode_btn"> Access Code </button>
					</a>
			       @endauth

				
				@else
				
				   @auth
				   	
			       <a href="{{route('assessment.access',$exam->slug)}}">
			       @else
			       <a href="#" data-toggle="modal" data-target="#myModal2">
			       @endauth

					<button class="btn btn-lg btn-outline-primary accesscode_btn"> Access Code </button>
					</a>

				@endif
				@endif

				@if($attempt)
				<a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-lg btn-success"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
                  </a>
				@endif

				@auth
				@if(\auth::user()->username=='demo500')
				@if($exam->status!=1)
				<div class="mt-4 alert alert-warning alert-important">
					<h3><i class="fa fa-gg"></i> Trial Account</h3> You can use the access code <b>'DEMO'</b> to attempt the test. The data is temporary, and the result will be erased after logout.</div>

				@endif
				@endif
				@endauth
<!--
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
		-->
		
		
		

	</div>
</div>


<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      {{
      		request()->session()->put('redirect.url',url()->current())
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