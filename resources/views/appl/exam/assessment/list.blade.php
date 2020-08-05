 @if($exams->total()!=0)     
 <div class="row ">


  @foreach($exams as $key=>$exam)  
  @if($exam->status !=0)
<div class="col-12 col-md-4 mb-4"> 
  
          <div class="bg-white border rounded">
            <div  style="background: #ebf3f7;padding:3px"></div>
              <div class="card-body">
                @if($exam->active==1)
                <span class="badge badge-secondary">Inactive</span>
                @elseif($exam->active ==0)
                <span class="badge badge-success">Active</span>
                @endif
                  <h4 class="my-2">{{ $exam->name }}</h4>
                    {{ $exam->time() }} min<br>

                    <div class="pt-2">
                  
                  <a href="{{ route('assessment.show',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-paper-plane" ></i> Details
                  </button>
                  </a>
                </div>
              </div>
          </div>
</div>
  @endif
    @endforeach  
  </div>          
@else
  <div class="card card-body bg-light mb-4">
    No tests listed 
    @if(request()->has('filter'))
      in {{ request()->get('filter')}}
    @endif
  </div>
@endif

<div class="mb-4">
<nav aria-label="Page navigation " class="card-nav @if($exams->total() > config('global.no_of_records'))mt-3 @endif">
  {{$exams->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
</nav>

</div>