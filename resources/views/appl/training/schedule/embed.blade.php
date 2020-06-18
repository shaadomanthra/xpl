

<div class="mb-2">



@if($r->type=='youtube_video_link')

<div class="block block_{{$r->id}} my-2" style="display: none">
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{youtube_id($r->link)}}?rel=0" allowfullscreen></iframe>
</div>
</div>
@elseif($r->type=='audio_link')
<div class="block block_{{$r->id}} my-2" style="display: none">
<figure class="">
    <audio
        controls
        src="{{ $r->link }}" style="width:100%">
            Your browser does not support the
            <code>audio</code> element.
    </audio>
</figure>
</div>

@elseif($r->type=='test_link')
<div class="block block_{{$r->id}} my-2" style="display: none">
	<a href="{{$r->link}}/instructions?code=demo" class="btn btn-success" target="_blank"><i class="fa fa-paper-plane"></i> Try Now</a>
</div>
@elseif($r->type=='ppt_link')
<div class="block block_{{$r->id}} my-2" style="display: none">
	{!! $r->link !!}
</div>
@else
<div class="block block_{{$r->id}} my-2" style="display: none">
	<div id="example1"></div>

	<script>PDFObject.embed("{{ $r->link }}", "#example1");</script>
</div>
@endif

</div>