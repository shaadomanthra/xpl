@extends('layouts.nowrap-product')
@section('content')

@include('flash::message')  


<div class="wrapper " >
<div class="container" >    
          
    <div class="row mt-md-3" >
	<div class="col-12 col-md-4 col-lg-3  mt-3">
		<div class=" p-4  rounded mb-3 text-light" style="background: #0abde3; border:1px solid #2e86de;">
			<h1 class="mb-4 mb-md-3" style="font-weight: 800;">
			<i class="fa fa-align-right"></i> {{ $course->name }} 
				@can('update',$course)
				<a href="{{ route('course.edit',$course->slug) }}">
				<i class="fa fa-edit"></i>
				</a>
				@endcan
			</h1>
			<div class=" mb-3" style="color:white">
			{!! $course->description !!}
		</div>
			<button class="btn btn-outline-light btn-lg" data-toggle="modal" data-target="#myModal"><i class ="fa fa-video-camera"></i> Watch Intro</button>
		</div>
	</div>		
	

	<div class="col-12 col-md-8 col-lg-9 mt-md-3">

		@if(\auth::user())
		@if(count($exams))
		<div class="p-3 border mb-4 bg-light rounded"> 
			<div class="row">
				<div class="col-12 col-md-3 pb-2 pb-md-0">
					<h3 class="mt-2">Exam Filter</h3>
					<div class="mt-3">
						<select class="custom-select  exam mb-2">
					  <option value='all' selected>All Questions</option>
					  @foreach($exams as $exam)
					  <option value="{{$exam->value}}" @if(request()->get('exam')==$exam->value || session('exam')==$exam->value) selected @endif>{{strtoupper($exam->value)}}</option>
					  @endforeach
					</select>
					</div>

				</div>
				<div class="col-12 mb-3 mb-md-0 col-md-3"> 
					<div class="  rounded p-3 " style="background: #ffeaa7;">
						Questions Attempted <div style="font-size: 25px;font-weight: 900;">{{ $course->attempted($course)}} / {{ ($ques_count)?$ques_count:'0' }} </div>

			</div></div>
				<div class="col-12 mb-3 mb-md-0 col-md-3"> <div class="  rounded p-3 " style="background: #fab1a0;">Performance Accuracy <div style="font-size: 25px;font-weight: 900;">
					@if($course->accuracy($course))
						{{ $course->accuracy($course)}} %
					@else
					--
					@endif</div></div></div>
				<div class="col-12  col-md-3"> <div class=" rounded p-3 " style="background: #81ecec;">Average Time  per Question<div style="font-size: 25px;font-weight: 900;">
					@if($course->time($course))
						{{ $course->time($course)}} sec
					@else
					--
					@endif</div></div></div>
				
			</div>		
		</div>
		@endif
		@endif


		<div class="row ml-0 mr-0 mr-md-2 mb-3 mb-md-5">
			{!! $nodes !!}
		</div>
	</div>
	</div>

</div>   
</div>





<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       <div class="embed-responsive embed-responsive-16by9">
		<iframe src="//player.vimeo.com/video/{{ $course->intro_vimeo }}"></iframe>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection           