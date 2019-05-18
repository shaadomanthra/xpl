@extends('layouts.app')
@section('title', $course->name.' | PacketPrep')
@section('keywords', $course->keywords)
@section('description', $course->description)
@section('content')

@include('flash::message')  

	<div class="d-none d-md-block">
  <nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.index')}}">Courses</a></li>
      <li class="breadcrumb-item">{{ $course->name }}</li>
      
    </ol>
  </nav>
</div>
          
    <div class="row mt-md-3" >
	<div class="col-12 col-md-4 col-lg-4 mt-1">
		<div class="border mb-3">
		<h2 class="  p-4  mb-0" style="background: #ecf2f6;  border-bottom:1px solid #eee;height:120px;"> 
			@if($course->image) 
		      <img src="{{ $course->image }}" style="width:70px" class="float-right"/> 
		      @endif 
		      <div class="pt-4">{{ $course->name }}</div>
		</h2>
		<div class=" p-4 mb-3  bg-white " style="">

			<div class=" mb-3" style="">
			{!! $course->description !!}
			@can('update',$course)
				<a href="{{ route('course.edit',$course->slug) }}">
				<i class="fa fa-edit"></i>
				</a>
				@endcan
		</div>
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
			<button class="btn btn-success btn-lg mb-3" >
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
			
			
			@if($course->intro_vimeo )
			<button class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#myModal"><i class ="fa fa-video-camera"></i> Watch Intro</button>
			@endif

			@if($course->intro_youtube )
			<button class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#myModal"><i class ="fa fa-video-camera"></i> Watch Intro</button>
			@endif
			
			@if(\auth::user())
				@if(\auth::user()->productvalidity($course->slug)==2)
				<a href="{{ route('productpage',$product->slug) }}">
				<button class="btn btn-success btn-lg" ><i class ="fa fa-shopping-cart"></i> Buy</button>
				</a>

				@endif
			
			@else
			<a href="{{ route('productpage',$product->slug) }}">
			<button class="btn btn-success btn-lg" ><i class ="fa fa-shopping-cart"></i> Buy</button>
			</a>

			@endif
			
		</div>
	</div>
	</div>		
	

	<div class="col-12 col-md-8 col-lg-8 mt-md-1">

		@if(\auth::user())
		@if(count($exams))
		<div class="pl-3 mb-0 mb-md-3 mt-0 mt-md-0"> 
			<div class="row">
				
				<div class="col-12 mb-3 mb-md-0 col-md-4"> 
					<div class="mr-3">
					<div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-font-awesome fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Questions Attempted <div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $course->attempted($course)}} / {{ ($ques_count)?$ques_count:'0' }} </div>
						</div>

						</div>
					</div>
				</div>
				</div>

				<div class="col-12 mb-3 mb-md-0 col-md-4 "> 
					<div class="mr-3 mr-md-2 ml-0 ml-md-1">
					<div class="row  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-area-chart fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Performance Accuracy<div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($course->accuracy($course))
						{{ $course->accuracy($course)}} %
					@else
					--
					@endif </div>
						</div>

						</div>
					</div>
				</div>
				</div>

				<div class="col-12 mb-3 mb-md-0 col-md-4 "> 
					<div class="mr-3 ml-0 ml-md-2">
					<div class="row border  rounded p-2 pt-3 pb-3" style="background: rgba(204, 232, 255, 0.3);border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-clock-o fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Average Time per question<div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($course->time($course))
						{{ $course->time($course)}} sec
					@else
					--
					@endif </div>
						</div>

						</div>
					</div>
				</div>
				</div>

				
				
			</div>		
		</div>
		@endif
		@endif


		<div class="row ml-0 mr-0  mb-0 mb-md-3 bg-white pt-4 rounded" >
			{!! $nodes !!}
		</div>

@if(count($exams)!=0) 
		<div class=" ">
			<h1 class="mb-4 p-3 border rounded"> <i class="fa fas fa-gg"></i> Online Tests</h1>


			     
 <div class="row ">
    
  @foreach($exams as $key=>$exam)  
  @if($exam->status != 0)
<div class="col-12 col-md-6 mb-4"> 
  
          <div class="bg-white border">
            <div  style="background: #ebf3f7">&nbsp;</div>
              <div class="card-body">
              	@if($exam->status==1)
                <span class="badge badge-warning">FREE</span>
                @else
                <span class="badge badge-primary">PREMIUM</span>

                @endif
                  <h1>{{ $exam->name }}</h1>
                    {{ $exam->question_count() }} Questions | {{ $exam->time() }} min<br>

                    <div class="pt-2">
                   @if(!$exam->attempted())
                  <a href="{{ route('assessment.show',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm"> <i class="fa fa-paper-plane" ></i> Details</button>
                  </a>
                  @else
                  <a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
                  </a>
                  @endif
                </div>
              </div>
          </div>
    
</div>
  @endif
    @endforeach  
  </div>       

		</div>
		@endif

		

      
	</div>
	</div>







<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       <div class="embed-responsive embed-responsive-16by9">
       	@if($course->intro_vimeo)
		<iframe src="//player.vimeo.com/video/{{ $course->intro_vimeo }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		@else
		<iframe src="https://www.youtube.com/embed/{{ $course->intro_youtube }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		@endif
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection           