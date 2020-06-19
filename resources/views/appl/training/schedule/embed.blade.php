

<div class="mb-2">
<div class="block block_{{$r->id}} my-2" style="display: none">
@if($r->type=='youtube_video_link')

<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{youtube_id($r->link)}}?rel=0" allowfullscreen></iframe>
</div>

@elseif($r->type=='audio_link')

<figure class="">
    <audio
        controls
        src="{{ $r->link }}" style="width:100%">
            Your browser does not support the
            <code>audio</code> element.
    </audio>
</figure>


@elseif($r->type=='test_link')
	<a href="{{$r->link}}/instructions?code=demo" class="btn btn-success" target="_blank"><i class="fa fa-paper-plane"></i> Try Now</a>
@elseif($r->type=='external_link')
    <a href="{{$r->link}}" class="btn btn-primary" target="_blank"><i class="fa fa-external-link"></i> Open Link</a>
@elseif($r->type=='ppt_link')
	{!! $r->link !!}

@else
	<div id="example1"></div>

	<script>PDFObject.embed("{{ $r->link }}", "#example1");</script>

@endif
@if(\auth::user()->checkRole(['administrator','hr-manager']))
<div class=" mt-3 mb-3">
<span class="">
    <a href=
    "{{route('resource.edit',[$app->training->slug,$r->id])}}"><i class="fa fa-edit" ></i> edit </a>&nbsp;&nbsp;

    <a href=
    "{{route('resource.destroy',[$app->training->slug,$r->id])}}" class="rdelete" data-name="{{$r->name}}"><i class="fa fa-trash"></i> delete</a>
  </span>
</div>
@endif
</div>
</div>

