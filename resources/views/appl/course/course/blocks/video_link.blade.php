@auth
<a href="{{ route('course.category.video',[$course->slug,$c->slug]) }}">
@else
<a href="#" data-toggle="modal" data-target="#myModal2">
@endauth

  @if($c->video_link)
      @if(is_numeric($c->video_link))
      <i class="fa fa-lock"></i>
      @else
      <i class="fa fa-circle-o" aria-hidden="true"></i>
      @endif
  @elseif($c->pdf_link)
        @if(strpos($c->pdf_link, '.mp3') !== false)
        <i class="fa fa-file-sound-o"></i> &nbsp;
        @else
        <i class="fa fa-file-pdf-o"></i> &nbsp;
        @endif
  @elseif($c->exam_id)	
  <i class="fa fa-external-link"></i>
  @endif

  {{ $c->name }}


</a>
