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
				
			@endcan

			@if(\auth::user())
			@if(\auth::user()->isSiteAdmin()))
			<div class="my-3">
			<a href="{{ route('course.analytics',$course->slug)}}">
				<i class="fa fa-bar-chart"></i> Analytics
				</a>
			</div>
			@endif
			@endif
		</div>
		@include('appl.course.course.blocks.access')
		</div>
	</div>

	@if(\auth::user())
 		@if(\auth::user()->isSiteAdmin())
 		 <form action="" class="card mb-3">
         <div class="card-body form-group ">
         	<h3>Admin tools</h3>
         	<hr>
			    <label for="exampleInputEmail1">Batch Number</label>
			    <input type="text" class="form-control mb-3" id="exampleInputEmail1" aria-describedby="emailHelp" name="batch" placeholder="Enter batch number" value="{{ request()->get('batch') }}">
			 		 <input type="hidden" class="form-control mb-3" name="refresh"  value="{{ request()->get('refresh') }}">
			    <button type="submit" class="btn btn-primary">Submit</button>
			    <a href="{{ route('course.show',$course->slug)}}?refresh=1" class="btn btn-outline-primary ml-2">Refresh Data</a>
			  </div>

     </form>
    @endif
  @endif


	@if(count($practice_set))
	@if(\auth::user())
	<div class="border mb-3">
		<div class=" p-4 mb-3  bg-white " style="">
			<div class=" mb-1" style="">
			<h3><i class="fa fa-shield"></i> Leaderboard <span class="float-right"><i class="fa fa-bolt"></i> Streak</span></h3>
			@if(!request()->get('batch'))
			<h5 class="text-info">Batch : {{ strtoupper($bno)  }}</h5>
			@else
			<h5 class="text-info">Batch : {{ strtoupper($bno)  }}</h5>
			@endif
			<hr class="{{$j=1}}">
			@foreach($practice_set as $uid=>$p)
				<div @if($uid==\auth::user()->id) class="text-primary border p-2 rounded bg-light" @else class="  p-2 rounded" @endif> {{$j++}}. {{ $users->find($uid)->name }} <span class="float-right">{{ $p * 10 }}</span></div>
			@endforeach
		</div>
		</div>
	</div>
	@endif
	@else
		@if(\auth::user())
 		@if(\auth::user()->isSiteAdmin())
 		<div class="border mb-3">
		<div class=" p-4 mb-3  bg-white " style="">
			<div class=" mb-1" style="">
			<h3><i class="fa fa-shield"></i> Leaderboard <span class="float-right"><i class="fa fa-bolt"></i> Streak</span></h3>
			@if(!request()->get('batch'))
			<h5 class="text-info">Batch : {{ strtoupper($bno) }}</h5>
			@else
			<h5 class="text-info">Batch : {{ strtoupper($bno) }}</h5>
			@endif
			<hr class="{{$j=1}}">
			- No Data -
		</div>
		</div>
	</div>
 		@endif
 		@endif
	@endif

	</div>		
	

	<div class="col-12 col-md-8 col-lg-8 mt-md-1">
		@if(\auth::user())
		@if($ques_count)
		<div class="pl-3 mb-0 mb-md-3 mt-0 mt-md-0"> 
			<div class="row">
				
				<div class="col-12 mb-3 mb-md-0 col-md-4"> 
					<div class="mr-3">
					<div class="row border  rounded p-2 pt-3 pb-3" style="background: white;border:1px solid white;">
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
					<div class="row  rounded p-2 pt-3 pb-3" style="background: white;border:1px solid #8db8dc4d;">
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
					<div class="row border  rounded p-2 pt-3 pb-3" style="background: White;border:1px solid #8db8dc4d;">
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

                     	@if($categories->$cid->total!=0)
                     		@include('appl.course.course.blocks.progress')
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
			<h1 class="mb-4 mt-4 p-3 border rounded"> <i class="fa fas fa-gg"></i> Online Tests

				<span class="float-right">
				  @if(\auth::user())
           @if(\auth::user()->isSiteAdmin())
           	@if($bno)
						<a href="{{ url('/performance') }}?course={{$course->slug}}&info={{$bno}}" class="btn btn-outline-primary btn-sm "> <i class="fa fas fa-bar-chart" ></i> All Tests</a>
						@else
						<a href="{{ url('/performance') }}?course={{$course->slug}}" class="btn btn-outline-primary btn-sm "> <i class="fa fas fa-bar-chart" ></i> All Tests</a>
						@endif
						@endif
					@endif
				</span>
			</h1>




			     
 <div class="row ">
 	<div class="col-12 "> 
 	<div class="card mb-0 pb-0">
    

  <table class="table table-bordered mb-0 pb-0">
  <thead>
    <tr class="bg-light">
      <th scope="col">#</th>
      <th scope="col">Test Name</th>
      <th scope="col">Type</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody class="{{$j=1}}">
  	@foreach($exams as $key=>$exam)  
  	@if($exam->status != 0)
    <tr>
      <th scope="row">{{$j++}}</th>
      <td>{{ $exam->name }}</td>
      <td>@if($exam->status==1)
          <span class="badge badge-warning">FREE</span>
          @else
          <span class="badge badge-primary">PREMIUM</span>
          @endif
       </td>
      <td>@if(!isset($course->attempt[$exam->id]))
                  <a href="{{ route('assessment.show',$exam->slug) }}">
                  <button class="btn btn-success btn-sm"> <i class="fa fa-paper-plane" ></i> Try Test</button>
                  </a>
                  @else
                  <a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-outline-secondary btn-sm"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
                  </a>
          @endif


          @if(\auth::user())
           @if(\auth::user()->isSiteAdmin() )
           	@if($bno)
						<a href="{{ url('/performance') }}?exam={{$exam->slug}}&info={{$bno}}" class="btn btn-outline-primary btn-sm "> <i class="fa fas fa-bar-chart" ></i> All Users</a>
						@else
						<a href="{{ route('course.analytics',$course->slug)}}?exam={{$exam->slug}}" class="btn btn-outline-primary btn-sm "> <i class="fa fas fa-bar-chart" ></i> All Users</a>
						@endif
						@endif
					@endif
      </td>

    </tr>
    @endif
    @endforeach
   
  </tbody>
</table>

    </div> 
  </div>
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