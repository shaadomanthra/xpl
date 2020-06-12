<span class="{{ $eid = $c->exam_id }}"></span>
@if(!isset($course->attempt[$eid]))
       @if(isset($course->tests->$eid))

       @auth
       <a href="{{ route('assessment.show',$c->exam_id)}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth

       <a href="{{ route('assessment.show',$course->tests->$eid)}}">
         <span class="badge badge-success"> <i class="fa fa-circle-o"></i> Try Test</span>
       </a>
       @else

       @auth
       <a href="{{ route('assessment.show',$c->exam_id)}}">
       @else
       <a href="#" data-toggle="modal" data-target="#myModal2">
       @endauth
       
         <span class="badge badge-success"> <i class="fa fa-circle-o"></i> Try Test</span>
       </a>
       @endif
@else

@if(isset($eid))
<a href="{{ route('assessment.analysis',$course->tests->$eid)}}">
 <span class="badge badge-primary"> <i class="fa fa-bar-chart-o"></i> Test Analysis </span>
</a>
@endif
@endif
