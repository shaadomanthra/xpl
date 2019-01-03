 @if($exams->total()!=0)     
 <div class="row ">
    
  @foreach($exams as $key=>$exam)  
  @if($exam->status !=0)
<div class="col-12 col-md-4 mb-4"> 
  
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
                   @if(!$exam->attempted())
                  
                  @if($exam->status==1) 
                  <a href="{{ route('assessment.instructions',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-paper-plane" ></i> Try Now
                  </button>
                  </a>
                  @elseif($exam->status == 2)

                  @if(\auth::user())
                  @if($exam->products->first())
                    @if(\auth::user()->productValid($exam->products->first()->slug)==2)
                    <a href="{{ route('productpage',$exam->getProductSlug()) }}">
                    <button class="btn btn-outline-primary btn-sm">
                      <i class="fa fa-lock" ></i> Buy Now
                    </button>
                    </a>
                    @elseif(\auth::user()->productValid($exam->products->first()->slug)==1)
                      <span class="text-danger">Expired</span>

                    @elseif(\auth::user()->productValid($exam->products->first()->slug)==0)  
                      <a href="{{ route('assessment.instructions',$exam->slug) }}">
                    <button class="btn btn-outline-primary btn-sm">
                      <i class="fa fa-paper-plane" ></i> Try Now
                    </button>
                    </a>
                    @endif

                  @else

                    

                  @endif
                  @else

                    @if($exam->products->first())
                    <a href="{{ route('productpage',$exam->getProductSlug()) }}">
                    <button class="btn btn-outline-primary btn-sm">
                      <i class="fa fa-lock" ></i> Buy Now
                    </button>
                    </a>
                    @endif
                  @endif

                  
                  @endif

                  
                  @else
                  <a href="{{ route('assessment.analysis',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm"> <i class="fa fas fa-bar-chart" ></i> Analysis</button>
                  </a>
                  @endif
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