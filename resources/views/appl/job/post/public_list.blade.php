


 @if($objs->total()!=0)

  @foreach($objs as $key=>$obj) 
  @if($obj->status==1 || $obj->status==3)
 <div class="bg-white p-4 p-md-5 mb-4">  
              <div class="media ">
              <div class="mr-4 d-none d-md-block" style="width:100px">
            @if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.jpg'))
                  <img class="mr-3 w-100" src="{{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.jpg') }}" alt="{{$obj->title}}">
              @elseif(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.png'))
               <img class="mr-3 w-100" src="{{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.png') }}" alt="{{$obj->title}}">
              @else
              <img class="mr-3" src="https://i.imgur.com/LFQMZfb.png" alt="{{$obj->title}}">
              @endif
            </div>
  <div class="media-body">
    <div class='mb-4'>
    <a href="{{ route('job.show',$obj->slug)}}"><h2 class="mt-0">{{$obj->title}}
      @if(\carbon\carbon::parse($obj->last_date)->gte(\carbon\carbon::now()))
      <span class="badge badge-warning float-right">open</span>
      @else
      <span class="badge badge-secondary float-right">closed</span>
      @endif
    </h2></a>
    {!! substr(strip_tags($obj->details),0,200) !!} @if(strlen(strip_tags($obj->details))>200) ...@endif
    </div>
     @auth
     @if($j = $myjobs->find($obj->id))
    <p>
    <span class="badge badge-success"><i class="fa fa-check-circle"></i> Applied <span style="color:#9ed3a4">@if($j->created_at){{$j->created_at->diffForHumans()  }}@endif</span></span></p>
    @endif
    @endauth
    <div class="mb-4">
      <div class="row mb-2">
            <div class="col-5 col-md-4"><i class="fa fa-map-marker"></i>&nbsp; Locations</div>
            <div class="col-7 col-md-8">{{str_replace(',',', ',$obj->location)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-5 col-md-4"><i class="fa fa-university"></i>&nbsp; Education</div>
            <div class="col-7 col-md-8">{{str_replace(',',', ',$obj->education)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-5 col-md-4"><i class="fa fa-calendar"></i>&nbsp; Year<span class="d-none d-md-inline"> of passing</span></div>
            <div class="col-7 col-md-8">{{str_replace(',',', ',$obj->yop)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-5 col-md-4"><i class="fa fa-graduation-cap"></i>&nbsp; Acad<span class="d-none d-md-inline">emic</span>s</div>
            <div class="col-7 col-md-8">{{$obj->academic}}% & above</div>
          </div>

          <div class="row mb-2">
            <div class="col-5 col-md-4"><i class="fa fa-flickr"></i>&nbsp; Salary</div>
            <div class="col-7 col-md-8">
              @if($obj->salary_num)
              {{$obj->salary_num}} 
              @else
              {{$obj->salary}} 
              @endif
            </div>
          </div>
    </div>

    <a href="{{ route('job.show',$obj->slug)}}" class="btn btn-primary mb-4">View details</a>

  </div>
</div>
</div>
@endif
              @endforeach      
            
        @else
        <div class="card card-body bg-light">
          No {{ $app->module }} listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($objs->total() > config('global.no_of_records'))mt-3 @endif">
        {{$objs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
