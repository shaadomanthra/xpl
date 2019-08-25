
@if(count($objs)!=0)
<div class="row ">
@foreach($objs as $obj)
<div class="col-12 col-md-6 col-lg-4">
 <div class="card mb-3" >
   @if(Storage::disk('public')->exists($obj->image))
     <a href="{{ route('page',$obj->slug) }}" >
      <img srcset="{{ asset('/storage/articles/'.$obj->slug.'_300.jpg') }} 320w,
             {{ asset('/storage/articles/'.$obj->slug.'_600.jpg') }}  480w,
             {{ asset('/storage/articles/'.$obj->slug.'_900.jpg') }}  800w"
      sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            800px"
      src="{{ asset('/storage/articles/'.$obj->slug.'_900.jpg') }} " class="w-100 card-img-top" alt="{{  $obj->name }}">
    </a>
      @endif
  <div class="card-body">
    <a href="{{ route('page',$obj->slug) }}" ><h2 class="card-title">{{ $obj->name }}</h2></a>
    <p class="card-text">
      {!! 
      substr(strip_tags($obj->description),0,200) !!}@if(strlen(strip_tags($obj->description))>200) ... @endif</p>
    <a href="{{ route('page',$obj->slug) }}" class="btn btn-success">read more</a>
  </div>
</div>
</div>
@endforeach
</div>
<div class="p-2"></div>
@else
<div class="card card-body bg-light">
  No {{ $app->module }} listed
</div>
@endif

