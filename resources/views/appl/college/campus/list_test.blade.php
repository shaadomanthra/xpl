 @if($exams->total()!=0)     
 <div class="row ">
    
  @foreach($exams as $key=>$exam)  
  @if($exam->status !=0)
<div class="col-12 col-md-6 mb-4"> 
  
          <div class="bg-white border">
            <div  style="background: #ebf3f7">&nbsp;</div>
              <div class="card-body">
                @if($exam->status==1)
                <span class="badge badge-warning">FREE</span>
                @elseif($exam->status ==2)
                <span class="badge badge-info">PREMIUM</span>
                @endif
                  <h1>{{ $exam->name }}</h1>
                    {{ $exam->question_count() }} Questions | {{ $exam->time() }} min<br>

                    <div class="pt-2">
                    <a href="{{ route('campus.tests.show',$exam->slug) }}">
                  <button class="btn btn-outline-success btn-sm">
                    <i class="fa fa-bar-chart" ></i> Analysis
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