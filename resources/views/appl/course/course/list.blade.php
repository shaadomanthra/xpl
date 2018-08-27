
  @foreach($courses as $key=>$course) 
  <div class="col-12 col-md-6 col-lg-4">
  <div class="border mb-3 mb-md-4 mt-md-2">
    <h2 class="  p-4 pt-5 mb-0" style="background:#f8f8f8;border-bottom:1px solid #eee;">  {{ $course->name }} </h2>
    <div class=" bg-white " >
      <div class="card-body">
        <p class="card-text">{!! $course->description !!}</p>
        <a href="{{ route('course.show',$course->slug) }} ">
          <button class="btn btn-outline-primary btn-sm " >View Course</button>
        </a>
      </div>
    </div>
  </div>
  </div>
  @endforeach
<nav aria-label="Page navigation  " class="card-nav @if($courses->total() > config('global.no_of_records'))mt-3 @endif">
        {{$courses->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
</nav>


       
        
