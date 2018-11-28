 @if($exams->total()!=0)     
 <div class="row">
    
  @foreach($exams as $key=>$exam)  
  @if($exam->status ==1)
<div class="col-3 mb-4"> 
  
          <div class="card bg-light">
              <div class="card-body">
                  <h1>{{ $exam->name }}</h1>
                    {{ $exam->question_count() }} Questions | {{ $exam->time() }} min<br>

                    <div class="pt-2">
                   @if(!$exam->attempted())
                  <a href="{{ route('assessment.instructions',$exam->slug) }}">
                  <button class="btn btn-outline-primary btn-sm"> <i class="fa fa-paper-plane" ></i> Try Now</button>
                  </a>
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
  <div class="card card-body bg-light">
    No Tests listed
  </div>
@endif

<nav aria-label="Page navigation  " class="card-nav @if($exams->total() > config('global.no_of_records'))mt-3 @endif">
  {{$exams->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
</nav>
