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
				@include('flash::message')  
				<h1 class="mt-3">
					{{ $exam->name }} 
					@if($exam->status ==2)
						<span class="badge badge-warning ">
						<i class="fa fa-lock" aria-hidden="true"></i>  PRIVATE
						</span>
					@else
						<span class="badge badge-warning ">
						<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> PUBLIC
						</span>
					@endif
				</h1>

				<p class="mb-3">
				{!! $exam->description  !!}
				</p>

				@include('appl.exam.assessment.blocks.camera')


				@if($entry)
				  @if(!$attempt)
				  <div class=" mb-2" >
            <a href="{{route('assessment.instructions',$exam->slug)}}">
								<button class="btn btn-lg btn-success accesscode_btn" > Attempt Test </button>
						</a>
					</div>
          @endif
				@else
					@if($product)
						@if($exam->status ==1)
						<div class=" mb-2" >
						<a href="{{route('assessment.instructions',$exam->slug)}}">
						<button class="btn btn-lg btn-success accesscode_btn" > Attempt Test </button>
						</a>
						</div>
						@else
				       <a href="{{route('productpage',$product->slug)}}">
						<button class="btn btn-lg btn-success"> Buy Now </button>
						</a>
						@endif
					@elseif($exam->status==1) <!-- free Test -->
					<div class=" mb-2" >
					<a href="{{route('assessment.instructions',$exam->slug)}}">
					<button class="btn btn-lg btn-success accesscode_btn" style="display: none"> Attempt Test </button>
					</a>
					</div>
					@else

						@if($product)
						<a href="{{route('productpage',$product->slug)}}">
							<button class="btn btn-lg btn-success"> Buy Now </button>
						</a>
						@else
						
						@endif

					@endif

				@endif


				@if(subdomain()==strtolower(env('APP_NAME')) && auth::user())
					@if(!auth::user()->college_id)
						@include('appl.exam.assessment.blocks.complete_profile')
					@elseif($exam->settings->email_verified==1 && auth::user()->status!=0 && auth::user()->status!=1)
							@include('appl.exam.assessment.blocks.verify_email')
					@elseif(count($form_fields)  && !Storage::disk('s3')->exists('test_info/'.$exam->slug.'/'.auth::user()->username.'.json'))
							@include('appl.exam.assessment.blocks.form_fields')
					@else
						@include('appl.exam.assessment.blocks.accesscode')
					@endif
				@elseif($exam->settings->email_verified!=0 && auth::user())
					@if($exam->settings->email_verified==1 && (auth::user()->status==0 || auth::user()->status==1))
							@include('appl.exam.assessment.blocks.accesscode')
					@else
							@include('appl.exam.assessment.blocks.verify_email')
					@endif
				@elseif(count($form_fields) && auth::user())
					@if(count($form_fields)  && !Storage::disk('s3')->exists('test_info/'.$exam->slug.'/'.auth::user()->username.'.json'))
							@include('appl.exam.assessment.blocks.form_fields')
					@else
							@include('appl.exam.assessment.blocks.accesscode')
					@endif
				@else
					@include('appl.exam.assessment.blocks.accesscode')
				@endif
				

				@if($attempt)
				<div class="alert alert-warning alert-important" role="alert">
			  	You have completed the test. To check the test report click on the analysis button.
				</div>
					<a href="{{ route('assessment.analysis',$exam->slug) }}">
            <button class="btn btn-lg btn-success"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
          </a>
          @if(isset($exam->settings->reattempt))
          	@if($exam->settings->reattempt==1)
          		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal2">
							  Retry the test
							</button>
          	@endif
          @endif

				@endif

				@guest
				<a href="{{ route('login')}}">
		        <button type="button" class="btn btn-success">Login</button>
		    	</a>
				@endguest

				
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
    	@if(request()->session()->get('settings'))
    	@if(request()->session()->get('settings')->register)
    	<a href="{{ route('student.eregister')}}">
        <button type="button" class="btn btn-primary">Register</button>
    	</a>
    	@endif
    	@endif

    	@if(subdomain()=='xplore' || subdomain()=='gradable')
    	<a href="{{ route('student.eregister')}}">
        <button type="button" class="btn btn-primary">Register</button>
    	</a>
    	@endif
      </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="exampleModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel3" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content">
     
      <div class="modal-body">
       This action will erase the last saved test response, and cannot be reversed. Kindly confirm your action.
      </div>
    
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
       <form method="post" action="{{route('assessment.show',$exam->slug)}}">
        <input type="hidden" name="retry" value="1">
        <input type="hidden" name="test_id" value="{{$exam->id}}">
        	@if(\auth::user())
        <input type="hidden" name="user_id" value="{{\auth::user()->id}}">
        	@endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <button type="submit" class="btn btn-danger">Erase my Responses</button>
        </form>
  
      </div>
    </div>
  </div>
</div>
@endsection           