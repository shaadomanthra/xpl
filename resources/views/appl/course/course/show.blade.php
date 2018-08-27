@extends('layouts.nowrap-product')
@section('content')

@include('flash::message')  


<div class="wrapper " >
    <div class="container" >    
          
    <div class="row mt-3" >
	<div class="col-12 col-md-4 col-lg-3  mt-3">
	<div class="bg-light p-4 border mb-4">
			<h1 class="mb-4 mb-md-3">
			<i class="fa fa-align-right"></i> {{ $course->name }} <span class="s15 text-secondary"> 2hr 3min</span>
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


<div class="p-3 border mb-5"> 
	<div class="row">
		<div class="col-12 col-md-2 pb-2 pb-md-0"><h3 class="mt-2">Exam Filter</h3></div>
		<div class="col-12 col-md-4"><select class="custom-select  mb-2">
  <option selected>All Questions</option>
  <option value="1">SSC</option>
  <option value="2">IBPS</option>
  <option value="3">SBI</option>
</select>
	</div>
	<div class="col-12 col-md-6"><h3><div class="float-right mt-2">Questions(1200)</div></h3></div>
	</div>
			
		</div>

	<div class="row ml-0 mr-0 mr-md-2 mb-3 mb-md-5">
		
			<div class=" col-12 ">
				
				<div class="row">
					<div class="col-8"><h2 class="mb-3"> <span class="bg-light p-1 pr-3 pl-3 border">1</span> &nbsp;Problems on Ages </h2></div>
					<div class="col-4"><h2 class=" text-secondary float-right">10m 56s </h2></div>
				</div>

				<p class="mb-3">
					This chapter covers basic questions on ages concept. Generally three type of questions asked from this topic, one is based on ratios, second is based on relationships and the thrid is data sufficiency questions.
				</p>
				
							<div class=" mb-3">
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-9">
							<a href="{{ url('courses/video') }}">
								<i class="fa fa-play-circle-o"></i> Introduction to Problems on Ages and Type 1 Questions 
							</a> &nbsp;
							<span class="badge badge-warning">Practice 12Q</span>
						</div>
						<div class="col-3"><span class="float-right">6m 3s </span></div>
					</div>
				</div>
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Type 2 - Relationship Data Questions</a>&nbsp;
							<span class="badge badge-warning">Practice 8Q</span> </div>
						<div class="col-4"><span class="float-right">7m 35s </span></div>
					</div>
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Type 3 - Data Sufficiency Questions</a> &nbsp;
							<span class="badge badge-warning">Practice 4Q</span></div>
						<div class="col-4"><span class="float-right">4m 5s </span></div>
					</div>
				</div>
				


				

				

			</div>

			</div>
	</div>

	<div class="row ml-0 mr-0 mr-md-2 mb-3 mb-md-5">
		
			<div class=" col-12 ">
				
				<div class="row">
					<div class="col-8"><h2 class="mb-3"> <span class="bg-light p-1 pr-3 pl-3 border">2</span> &nbsp; Simple Interest </h2></div>
					<div class="col-4"><h2 class=" text-secondary float-right">15m 28s </h2></div>
				</div>

				<p class="mb-3">
					This chapter covers basic questions on ages concept. Generally three type of questions asked from this topic, one is based on ratios, second is based on relationships and the thrid is data sufficiency questions.
				</p>
				
							<div class=" mb-3">
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-9">
							<a href="{{ url('courses/video') }}">
								<i class="fa fa-play-circle-o"></i> Introduction to Simple Interest and Type 1 Questions 
							</a> &nbsp;
							<span class="badge badge-warning">Practice 9Q</span>
						</div>
						<div class="col-3"><span class="float-right">4m 3s </span></div>
					</div>
				</div>
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Type 2 - Corelation Type Questions </a>&nbsp;
							<span class="badge badge-warning">Practice 2Q</span> </div>
						<div class="col-4"><span class="float-right">3m 35s </span></div>
					</div>
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Type 3 - Formula Based Questions</a> &nbsp;
							<span class="badge badge-warning">Practice 3Q</span></div>
						<div class="col-4"><span class="float-right">5m 51s </span></div>
					</div>
				</div>
				
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Type 4 - Miscelleneous Questions</a> &nbsp;
							<span class="badge badge-warning">Practice 5Q</span></div>
						<div class="col-4"><span class="float-right">3m 5s </span></div>
					</div>
				</div>

				

				

			</div>

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
		<iframe src="//player.vimeo.com/video/22428395"></iframe>
	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection           