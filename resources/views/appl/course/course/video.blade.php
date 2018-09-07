@extends('layouts.app')

@section('content')


<div class="bg-white">
<div class="row ">
  <div class="col-12 col-md-3 d-none d-md-block">
    <div class="list-group">
  <a href="{{route('course.show',$course->slug)}}#{{$parent->slug}}" class="list-group-item list-group-item-action disabled">
    <h2><i class="fa fa-angle-double-left"></i>&nbsp; {{ $parent->name }}</h2>
  </a>
  @foreach($parent->descendants as $k => $item)
  <a href="{{ route('course.category.video',[$course->slug,$item->slug])}} " class="list-group-item list-group-item-action @if($item->slug == $category->slug) active @endif"><span class="border badge badge-light mb-1">{{$k+1}}</span> &nbsp;{{ $item->name }}</a>
  @endforeach
</div>
  </div>
  <div class="col-12 col-md-9">
    <h1 class="mb-4"> <div class=""><i class="fa fa-youtube-play"></i> &nbsp;{{ $category->name }} </div></h1>

@if($category->video_link)
<div class="embed-responsive embed-responsive-16by9 bg-light">
    <iframe src="//player.vimeo.com/video/{{ $category->video_link }}"></iframe>
  </div>

@endif

<div class=" p-3" style="background: #eee; font-size: 20px;">
  <div class="row">
    <div class="col-12 col-md-4">
      @if($prev)
      <a href="{{ route('course.category.video',[$course->slug,$prev->slug])}}">
        <i class="fa fa-angle-double-left"></i> &nbsp;Previous Lesson
      </a>
      @else
      <a href="{{ route('course.show',[$course->slug])}}#{{$parent->slug}}">
        <i class="fa fa-angle-double-left"></i> &nbsp;Course Page
      </a>
      @endif
      
    </div>
    <div class="col-12 col-md-4">
      @if(count($category->questions)!=0)
      <div class="text-md-center mt-3 mt-md-0 mb-3 mb-md-0">
        <a href="{{route('course.question',[$course->slug,$category->slug,''])}}"><i class="fa fa-bars"></i> &nbsp;Practice ({{ count($category->questions)}}Q)</a>
    </div>
    @endif
    </div>
    <div class="col-12 col-md-4">
      @if($next)
      <a href="{{ route('course.category.video',[$course->slug,$next->slug])}}">
        <span class="float-md-right">Next Lesson&nbsp; <i class="fa fa-angle-double-right"></i></span>
      </a>
      @else
      <a href="{{ route('course.show',[$course->slug])}}#{{$parent->slug}}">
        <span class="float-md-right">Course Page&nbsp; <i class="fa fa-angle-double-right"></i></span>
      </a>
      @endif
      
   
    </div>
  </div>
  </div>

  @if($category->video_desc)
  <div class="p-5 bg-light">
    {!! $category->video_desc !!}
  </div>
  @endif
  </div>



</div>    
</div>
@endsection           