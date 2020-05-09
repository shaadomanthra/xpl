
@if(count($objs)!=0)
<div class="row ">
@foreach($objs as $obj)
@if($obj->status==1)
<div class="col-12 col-md-6 ">
 <div class="p-2 bg-white mb-3" style="box-shadow: 2px 2px 2px 2px #eee">
  <div class="row no-gutters">
   @if(Storage::disk('public')->exists($obj->image))
   <div class="col-5" >
    <div class="p-3">
     <a href="{{ route('page',$obj->slug) }}" >
      
           <picture >
  <source srcset="{{ asset('/storage/articles/'.$obj->slug.'_300.webp') }} 320w,
             {{ asset('/storage/articles/'.$obj->slug.'_600.webp') }}  480w,
             {{ asset('/storage/articles/'.$obj->slug.'_900.webp') }}  800w,
             {{ asset('/storage/articles/'.$obj->slug.'_1200.webp') }}  1100w" type="image/webp" sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px" alt="{{  $obj->name }}" style="width:100%">
  <source srcset="{{ asset('/storage/articles/'.$obj->slug.'_300.jpg') }} 320w,
             {{ asset('/storage/articles/'.$obj->slug.'_600.jpg') }}  480w,
             {{ asset('/storage/articles/'.$obj->slug.'_900.jpg') }}  800w,
             {{ asset('/storage/articles/'.$obj->slug.'_1200.jpg') }}  1100w," type="image/jpeg" sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px" alt="{{  $obj->name }}" style="width:100%"> 
  <img srcset="{{ asset('/storage/articles/'.$obj->slug.'_300.jpg') }} 320w,
             {{ asset('/storage/articles/'.$obj->slug.'_600.jpg') }}  480w,
             {{ asset('/storage/articles/'.$obj->slug.'_900.jpg') }}  800w,
             {{ asset('/storage/articles/'.$obj->slug.'_1200.jpg') }}  1100w,"
      sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px"
      src="{{ asset('/storage/articles/'.$obj->slug.'_300.jpg') }} " class=" card-img-top" alt="{{  $obj->name }}" style="width:100%">
</picture>

    </a>
    </div>
  </div>
      @endif
  <div class="col">
  <div class="p-3">
    <a href="{{ route('page',$obj->slug) }}" ><h4 class="card-title article">{{ $obj->name }}</h4></a>
    
    <a href="{{ route('page',$obj->slug) }}" class="btn btn-success"><i class="fa fa-align-right"></i> read more</a>
  </div>
</div>
</div>
</div>
</div>
@endif
@endforeach
</div>
<div class="p-2"></div>
@else
<div class="card card-body bg-light">
  No Jobs listed
</div>
@endif
<div class="">
<nav aria-label="Page navigation  " class="card-nav ">
        {{$objs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
      <div class="p-3"></div>
    </div>

