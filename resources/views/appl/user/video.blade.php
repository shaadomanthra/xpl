 <h3 class="bg-white border p-3 mb-0"><i class='fa fa-youtube-play'></i> Profile Video</h3>
         
          @if($user->video)
@if(!is_numeric($user->video))
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $user->video}}?rel=0" allowfullscreen></iframe>
</div>
@else
<div class="embed-responsive embed-responsive-16by9">
  <iframe src="//player.vimeo.com/video/{{ $user->video }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>
@endif

@else
<div class='p-3 bg-light border'>
<a href="{{ route('video.upload') }}" class="btn btn-primary">Add Profile Video</a>
</div>
@endif

