@extends('layouts.nowrap-product')
@section('content')

@include('flash::message')  


<div class="wrapper " >
<div class="container" >    
          
    <div class="row mt-3" >
	<div class="col-12 col-md-4 col-lg-3  mt-3">
		<div class="bg-light p-4 border mb-3">
			<h1 class="mb-4 mb-md-3">
			<i class="fa fa-align-right"></i> {{ $course->name }} 
				<span class="s15 text-secondary"> 2hr 3min</span>
				@can('update',$course)
				<a href="{{ route('course.edit',$course->slug) }}">
				<i class="fa fa-edit"></i>
				</a>
				@endcan
			</h1>
			{!! $course->description !!}
			<button class="btn btn-outline-info btn-lg" data-toggle="modal" data-target="#myModal"><i class ="fa fa-video-camera"></i> Watch Intro</button>
		</div>
	</div>		
	

	<div class="col-12 col-md-8 col-lg-9 mt-3">

		@if(count($exams))
		<div class="p-3 border mb-4"> 
			<div class="row">
				<div class="col-12 col-md-2 pb-2 pb-md-0"><h3 class="mt-2">Exam Filter</h3></div>
				<div class="col-12 col-md-4">
					<select class="custom-select  exam mb-2">
					  <option value='all' selected>All Questions</option>
					  @foreach($exams as $exam)
					  <option value="{{$exam->value}}" @if(request()->get('exam')==$exam->value || session('exam')==$exam->value) selected @endif>{{strtoupper($exam->value)}}</option>
					  @endforeach
					</select>
				</div>
				<div class="col-12 col-md-6">
					<h3><div class="float-right mt-2">Questions({{ $ques_count }})</div></h3>
				</div>
			</div>		
		</div>
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