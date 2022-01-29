<span class="{{ $eid = $c->exam_id }}"></span>
@if(isset($exams[$c->exam_id]->try))
@if($c->exam_id)
  @if(!$exams[$c->exam_id]->try)
        @auth
       <a href="{{ route('assessment.show',$c->exam_id)}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth
          <span class="badge badge-success"> <i class="fa fa-circle-o"></i> Try Test</span>
        </a>
    
  @else
     @auth
       <a href="{{ route('assessment.analysis',$c->exam_id)}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth
           <span class="badge badge-primary"> <i class="fa fa-bar-chart-o"></i> Test Analysis </span>
        </a>
  
  @endif
@endif

@endif