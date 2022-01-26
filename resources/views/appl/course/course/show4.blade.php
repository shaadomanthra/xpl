@extends('layouts.app')
@section('title', $course->name.' ')
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
		<h2 class="  p-4  mb-0" style="background: #eee;  border-bottom:1px solid #eee;height:120px;"> 
			
		      <div class="pt-4">{{ $course->name }}</div>
		</h2>
		<div class=" p-4 mb-3  bg-white " style="">

			<div class=" mb-3" style="">
			{!! $course->description !!}
			@can('update',$course)
				<a href="{{ route('course.edit',$course->slug) }}">
				<i class="fa fa-edit"></i>
				</a>
				<a href="{{ route('admin.analytics.course') }}?course={{$course->slug}}">
				<i class="fa fa-bar-chart"></i> 
				</a>
			@endcan
		</div>

		@include('appl.course.course.blocks.access')
			
		</div>
	</div>

	</div>		
	

	<div class="col-12 col-md-8 col-lg-8 mt-md-1">

		@if(\auth::user())
		@if($ques_count)

		<div class="pl-3 mb-0 mb-md-3 mt-0 mt-md-0"> 
			<div class="row">
				
				<div class="col-12 mb-3 mb-md-0 col-md-4"> 
					<div class="mr-3">
					<div class="row border  rounded p-2 pt-3 pb-3" style=";border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-font-awesome fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Questions Attempted <div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">{{ $course->user['attempted'] }} / {{ ($ques_count)?$ques_count:'0' }} </div>
						</div>

						</div>
					</div>
				</div>
				</div>

				<div class="col-12 mb-3 mb-md-0 col-md-4 "> 
					<div class="mr-3 mr-md-2 ml-0 ml-md-1">
					<div class="row  rounded p-2 pt-3 pb-3" style="border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-area-chart fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Performance Accuracy<div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($course->user['accuracy'])
						{{ $course->user['accuracy']}} %
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
					<div class="row border  rounded p-2 pt-3 pb-3" style="border:1px solid #8db8dc4d;">
						<div class="col-4"><div class="mt-2"><i class="fa fa-clock-o fa-3x" style="color: rgba(127, 166, 198, 0.93)"></i></div></div>
						<div class="col-8">
						<div class="  " style="color: rgba(127, 166, 198, 0.93)">
						Average Time per question<div style="font-size: 20px;font-weight: 900;color:rgba(127, 166, 198, 1)">@if($course->user['time'])
						{{ $course->user['time']}} sec
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
		<ul class="list2 list2-first {{$j=0}}" >

			 

		@foreach($nodes as $n)
			<li class="item title-list" id="{{ $n->slug}}" > <h3><span class="bg-light p-1 pr-3 pl-3 border rounded">{{++$j}}</span> &nbsp;{{ $n->name }}</h3>
			@if($n->video_desc)
			<div class="pt-3 title-normal">{!! $n->video_desc !!}</div>
			@endif
			</li>

			@if(count($n->children))
				<ul class="list2">
					@foreach($n->children as $c)

					@if($c->video_link || $c->pdf_link  || $c->video_desc)
						<li class="item {{ $cid = $c->id }}" id="{{ $c->slug }}"> 
						@include('appl.course.course.blocks.video_link')


                     	@if($categories->$cid->total!=0)
                     		@include('appl.course.course.blocks.practice_link')
                     	@endif
                     	
                     	@if($c->exam_id)
                     		@include('appl.course.course.blocks.exam_link')
                     	@endif
                     	
                     	@if($categories->$cid->total!=0)
                     		@include('appl.course.course.blocks.progress')
                     	@endif

						
                     	</li>
                   @else
                   <li class="item {{ $cid = $c->id }}" id="{{ $c->slug }}">	<i class="fa fa-bars"></i> {{$c->name}} 
                   	@if($categories->$cid->total!=0)
                     		@include('appl.course.course.blocks.practice_link')
                     	@endif

                     	@if($c->exam_id)
                     		@include('appl.course.course.blocks.exam_link')
                     	@endif
                   </li>

                     @endif	
                     @endforeach
				</ul>
			@endif
		@endforeach
		</ul>
		</div>

@if($exams) 
@if(count($exams)!=0)
		<div class=" ">
			<h1 class="mb-4 mt-4 p-3 border rounded"> <i class="fa fas fa-gg"></i> Online Tests</h1>


			     
 <div class="row ">
    
  @foreach($exams as $key=>$exam)  
  @if($exam->status != 0)
<div class="col-12 col-md-6 mb-4"> 
  
          <div class="bg-white border">
            <div  style="background: #eee">&nbsp;</div>
              <div class="card-body">
              	@if($exam->status==1)
                <span class="badge badge-warning">FREE</span>
                @else
                <span class="badge badge-primary">PREMIUM</span>

                @endif
                  <h1>{{ $exam->name }}</h1>

                    <div class="pt-2">
                  @if(!isset($course->attempt[$exam->id]))
                  <a href="{{ route('assessment.show',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm"> <i class="fa fa-paper-plane" ></i> Details</button>
                  </a>
                  @else
                  <a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-outline-secondary btn-sm"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
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