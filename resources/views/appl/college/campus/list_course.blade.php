<div class="row">
@foreach($courses as $course)	
	@if($course->status==1 ) 
	  <div class="col-12 col-md-6 ">
	  <div class="border mb-3 mb-md-4 mt-md-2">
	    <h2 class="  p-4 mb-0" >
	      <div class="">{{ $course->name }}</div>
	    </h2>
	    <div class=" bg-white " >
	      <div class="card-body">
	        <p class="card-text mt-2">{!! $course->description !!}</p>
	        <a href="{{ route('course.show',$course->slug) }} ">
	          <button class="btn btn-outline-primary btn-sm " >View Course</button>
	        </a>
	        @if($user)
	        	<a href="{{ route('campus.courses.student.show',[$course->slug,$user->username]) }} ">
		          <button class="btn btn-outline-success btn-sm " ><i class="fa fa-bar-chart"></i> Analytics</button>
		        </a>
	        @else
		        <a href="{{ route('campus.courses.show',$course->slug) }} ">
		          <button class="btn btn-outline-success btn-sm " ><i class="fa fa-bar-chart"></i> Analytics</button>
		        </a>
	        @endif
	        
	      </div>
	    </div>
	  </div>
	  </div>
	  @endif
	  @endforeach
	</div>