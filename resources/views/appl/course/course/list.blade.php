
  @foreach($courses as $key=>$course)
  @if(\auth::user())
  @if(\auth::user()->isAdmin())

  <div class="col-12 col-md-6 ">
  <div class="border mb-3 mb-md-4 mt-md-2">
     <h2 class="  p-4  mb-0" style="background: #ecf2f6;  border-bottom:1px solid #eee;height:140px;">
      @if($course->image) 
      <img src="{{ $course->image }}" style="width:70px" class="float-right"/> 
      @endif 
      <div class="pt-4">{{ $course->name }}
        @if($course->product())
        @if($course->product()->price==0)
        <div class="mt-2 h5">
        <span class="badge badge-warning">FREE</span>
      </div>
      @else
      <div class="mt-2 h5">
        <span class="badge badge-info pl-2 pr-2"><i class="fa fa-rupee"></i> {{ $course->product()->price}}</span>
      </div>
      @endif
      @endif
    </div>
     </h2>
    <div class=" bg-white " >
      <div class="card-body">

        <p class="card-text mt-2">{!! $course->description !!}</p>
        <a href="{{ route('course.show',$course->slug) }} ">
          <button class="btn btn-outline-primary btn-sm " >View Course</button>
        </a>
      </div>
    </div>
  </div>
  </div>
  @else

  @if($course->status==1 ) 
  <div class="col-12 col-md-6 ">
  <div class="border mb-3 mb-md-4 mt-md-2">
     <h2 class="  p-4  mb-0" style="background: #ecf2f6;  border-bottom:1px solid #eee;height:140px;">
      @if($course->image) 
      <img src="{{ $course->image }}" style="width:70px" class="float-right"/> 
      @endif 
      <div class="pt-4">{{ $course->name }}
        @if($course->product())
        @if($course->product()->price==0)
        <div class="mt-2 h5">
        <span class="badge badge-warning">FREE</span>
      </div>
      @else
      <div class="mt-2 h5">
        <span class="badge badge-info pl-2 pr-2"><i class="fa fa-rupee"></i> {{ $course->product()->price}}</span>
      </div>
      @endif
      @endif
    </div>
     </h2>
    <div class=" bg-white " >
      <div class="card-body">
        {{ dd($course->product)}}
        <p class="card-text mt-2">{!! $course->description !!}</p>
        <a href="{{ route('course.show',$course->slug) }} ">
          <button class="btn btn-outline-primary btn-sm " >View Course</button>
        </a>
      </div>
    </div>
  </div>
  </div>
  @endif

  @endif
  

  @else

  @if($course->status==1 ) 
  <div class="col-12 col-md-6 ">
  <div class="border mb-3 mb-md-4 mt-md-2">
    <h2 class="  p-4  mb-0" style="background: #ecf2f6;  border-bottom:1px solid #eee;height:140px;">
      @if($course->image) 
      <img src="{{ $course->image }}" style="width:70px" class="float-right"/> 
      @endif 
      <div class="pt-4">{{ $course->name }}
        @if($course->product())
        @if($course->product()->price==0)
        <div class="mt-2 h5">
        <span class="badge badge-warning">FREE</span>
      </div>
      @else
      <div class="mt-2 h5">
        <span class="badge badge-info pl-2 pr-2"><i class="fa fa-rupee"></i> {{ $course->product()->price}}</span>
      </div>
      @endif
      @endif
    </div>
     </h2>
    <div class=" bg-white " >
      <div class="card-body">
        <p class="card-text mt-1">{!! $course->description !!}</p>
        <a href="{{ route('course.show',$course->slug) }} ">
          <button class="btn btn-outline-primary btn-sm " >View Course</button>
        </a>
      </div>
    </div>
  </div>
  </div>
  @endif


  @endif

  @endforeach
<nav aria-label="Page navigation  " class="card-nav @if($courses->total() > config('global.no_of_records'))mt-3 @endif">
        {{$courses->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
</nav>


       
        
