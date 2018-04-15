@extends('layouts.nowrap')
@section('content')

<div class="line" style="padding:1px; background:#eee" ></div>
<div class="bg-white p-3 pt-4 pb-4 p-md-4  mb-4 ">
	@include('flash::message')  
	<div class="wrapper ">  
	<div class="container">
	<div class="row pt-4 pb-4">
		<div class="col-12 col-md-7 col-lg-8">
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
		<div class="col-12 col-md-5 col-lg-4">
			<div class=" mt-2">
			<h2 class=" mb-3 mt-5 mt-md-0" >Priority Index <i class="fa fa-info-circle s15 text-secondary " data-toggle="tooltip" data-placement="top" title="More Information" ></i></h2>
			<div class=" bg-white " >
				
				<h1>
				<i class="fa fa-star fa-dark"></i>  
				<i class="fa fa-star fa-dark"></i> 
				<i class="fa fa-star fa-light"></i> 
				<i class="fa fa-star fa-light"></i> 
				<i class="fa fa-star fa-light"></i> &nbsp;<span class="fa-dark"><b>3.0</b></span></h1>
			
			</div>
			</div>

			<div class=" mt-5">
			<h2 class=" mb-3" >Marks Weightage <i class="fa fa-info-circle s15 text-secondary " data-toggle="tooltip" data-placement="top" title="More Information" ></i></h2>
			<div class=" bg-white " >
				<div class="row no-gutters">
					<div class="col-4">
						<div class="bg-light border rounded p-3 text-center mr-1">
							<div class="">Max</div>
							<h1>{{ $course->weightage_min }}</h1>
						</div>
					</div>
					<div class="col-4 ">
						<div class="bg-light border rounded p-3 text-center ml-1 mr-1">
							<div class="">Avg</div>
							<h1>{{ $course->weightage_avg }}</h1>
						</div>
					</div>
					<div class="col-4 ">
						<div class="bg-light border rounded p-3 text-center ml-1">
							<div class="">Min</div>
							<h1>{{ $course->weightage_max }}</h1>
						</div>
					</div>
				</div>
			
			</div>
			</div>

  		</div>
</div>
	</div>
</div>
</div>

<div class="wrapper " >
    <div class="container" >    
          
    <div class="row mt-5" >
	

	<div class="col-12 col-md-7 col-lg-8">

	<div class="row ml-0 mr-0 mr-md-2 mb-3 mb-md-5">
		<div class="col-2 d-none d-lg-block">
			<div class="  border rounded text-center p-3" style="font-size:40px;background:#eef1f3">1</div>
		</div>
			<div class=" col-12 col-lg-10">
				
				<div class="row">
					<div class="col-8"><h2 class="mb-3"> <span class="d-inline d-lg-none">1.</span> Propositional Logic </h2></div>
					<div class="col-4"><h2 class=" text-secondary float-right">20m 56s </h2></div>
				</div>

				<p class="mb-3">
					This chapter covers identifying the propositions, basic logical connectives like conjunction, disjunction, exclusive or, implication, bi-implication, precedence rules. Finding tautology, contradiction, satisfiable and unsatisfiable formulae. Finding two formulae are equivalent using logical equivalence rules. Checking if the argument is valid or not using rules of inference.
				</p>
				
							<div class=" mb-3">
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8">
							<a href="{{ url('courses/video') }}">
								<i class="fa fa-play-circle-o"></i> Propositions, Negation and Conjunction
							</a> 
						</div>
						<div class="col-4"><span class="float-right">12m 3s </span></div>
					</div>
				</div>
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Or, Exor, If-then, Iff, Precedence</a> </div>
						<div class="col-4"><span class="float-right">30m 35s </span></div>
					</div>
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Logical Equivalence</a> </div>
						<div class="col-4"><span class="float-right">34m 5s </span></div>
					</div>
				</div>
				<div class="ml-2  pt-3 pb-3 mb-3 pl-3" style="background:#eef1f3">
					<a href="{{ url('courses/lecture') }}">
						<i class="fa fa-th"></i>  Checkpoint ML101
					</a> 
					<span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8">
							<a href="{{ url('courses/video') }}">
								<i class="fa fa-play-circle-o"></i> Propositions, Negation and Conjunction
							</a> 
						</div>
						<div class="col-4"><span class="float-right">12m 3s </span></div>
					</div>
				</div>
				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Or, Exor, If-then, Iff, Precedence</a> </div>
						<div class="col-4"><span class="float-right">30m 35s </span></div>
					</div>
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Logical Validity</a> </div>
						<div class="col-4"><span class="float-right">3m 35s </span></div>
					</div>
				</div>

				

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3">
					<a href="{{ url('courses/lecture') }}">
						<i class="fa fa-file-text-o"></i>  Key Notes
					</a> 
					<span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-university"></i>  Archive Questions </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-paper-plane-o"></i>  Exercise Questions </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

			</div>

			</div>
	</div>


	<div class="row ml-0 mr-0 mr-md-2 mb-3 mb-md-5">
		<div class="col-2 d-none d-lg-block">
			<div class="  border rounded text-center p-3" style="font-size:40px;background:#eef1f3">2</div>
		</div>
			<div class=" col-12 col-lg-10">

				<div class="row">
					<div class="col-8"><h2 class="mb-3"> <span class="d-inline d-lg-none">2.</span> Propositional Logic </h2></div>
					<div class="col-4"><h2 class=" text-secondary float-right">20m 56s </h2></div>
				</div>
				

				<p class="mb-3">
					This chapter covers identifying the propositions, basic logical connectives like conjunction, disjunction, exclusive or, implication, bi-implication, precedence rules. Finding tautology, contradiction, satisfiable and unsatisfiable formulae. Finding two formulae are equivalent using logical equivalence rules. Checking if the argument is valid or not using rules of inference.
				</p>
				
			<div class=" mb-3">
				<div class="ml-4">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Propositions, Negation and Conjunction</a> </div>
						<div class="col-4"><span class="float-right">12m 3s </span></div>
					</div>
					<hr> 
				</div>
				<div class="ml-4">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Or, Exor, If-then, Iff, Precedence</a> </div>
						<div class="col-4"><span class="float-right">30m 35s </span></div>
					</div>
					<hr> 
				</div>

				<div class="ml-4">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Logical Equivalence</a> </div>
						<div class="col-4"><span class="float-right">34m 5s </span></div>
					</div>
					<hr> 
				</div>

				<div class="ml-4 mb-3">
					<div class="row">
						<div class="col-8"><a href="#"><i class="fa fa-play-circle-o"></i> Logical Validity</a> </div>
						<div class="col-4"><span class="float-right">3m 35s </span></div>
					</div>
				</div>

				

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-file-text-o"></i>  Key Points </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-list-ul"></i>  Solved Examples </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-th"></i>  Practice Questions </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

				<div class="ml-2  pt-3 pb-3 mb-1 pl-3" style="background:#eef1f3"><a href="#"><i class="fa fa-paper-plane"></i>  Chapter Test </a> <span class=" mr-3 text-secondary float-right"> <i class="fa fa-lock"></i> </span>
				</div>

			</div>
		</div>
	</div>

	</div>
	

	<div class="col-12 col-md-5 col-lg-4">

		<div class=" rounded mb-4 mb-md-5 mt-2">
			<div class=" bg-white " >
			  <div class="card-body rounded bg-success text-light">
				<h2><b> <i class="fa fa-diamond" ></i> Premium Access </b></h2>
				<div class="mb-3"> Get full access to Study Notes, Worksheets, Solved Examples, Practice Questions and Online Tests for Mathemtatical Logic.</div>
				<button class="btn btn-outline-light"><i class="fa fa-rupee"></i> {{ $course->price }}</button>

			  </div>
			</div>
		</div>

		<div class="border mb-4 mb-lg-5 ">
			<h2 class="  p-4   mb-0" style="background:#eef1f3">Important Topics <i class="fa fa-info-circle s15 text-secondary " data-toggle="tooltip" data-placement="top" title="More Information" ></i></h2>
			<div class=" bg-white " >
			  <div class="card-body">
				{!! $course->important_topics !!}
			  </div>
			</div>
		</div>

		<div class="border mb-4 ">
			<h2 class="  p-4   mb-0" style="background:#eef1f3">Reference Books <i class="fa fa-info-circle s15 text-secondary " data-toggle="tooltip" data-placement="top" title="More Information" ></i></h2>
			<div class=" bg-white " >
			  <div class="card-body">
				{!! $course->reference_books !!}
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
  <iframe id="intro" class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $course->intro_youtube }}" allowfullscreen></iframe>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection           