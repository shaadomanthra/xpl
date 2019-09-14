<div class="card mb-3" >
   @if(Storage::disk('public')->exists($item->image))
     <a href="{{ route('page',$item->slug) }}" >
           <picture>
  <source srcset="{{ asset('/storage/articles/'.$item->slug.'_300.webp') }} 320w,
             {{ asset('/storage/articles/'.$item->slug.'_600.webp') }}  480w,
             {{ asset('/storage/articles/'.$item->slug.'_900.webp') }}  800w,
             {{ asset('/storage/articles/'.$item->slug.'_1200.webp') }}  1100w" type="image/webp" sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px" alt="{{  $item->name }}">
  <source srcset="{{ asset('/storage/articles/'.$item->slug.'_300.jpg') }} 320w,
             {{ asset('/storage/articles/'.$item->slug.'_600.jpg') }}  480w,
             {{ asset('/storage/articles/'.$item->slug.'_900.jpg') }}  800w,
             {{ asset('/storage/articles/'.$item->slug.'_1200.jpg') }}  1100w," type="image/jpeg" sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px" alt="{{  $item->name }}"> 
  <img srcset="{{ asset('/storage/articles/'.$item->slug.'_300.jpg') }} 320w,
             {{ asset('/storage/articles/'.$item->slug.'_600.jpg') }}  480w,
             {{ asset('/storage/articles/'.$item->slug.'_900.jpg') }}  800w,
             {{ asset('/storage/articles/'.$item->slug.'_1200.jpg') }}  1100w,"
      sizes="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            (max-width: 720px) 800px
            1200px"
      src="{{ asset('/storage/articles/'.$item->slug.'_1200.jpg') }} " class="w-100 card-img-top" alt="{{  $item->name }}">
</picture>
    </a>
      @endif
  <div class="card-body">
    <a href="{{ route('page',$item->slug) }}" ><h3 class="card-title article">{{ $item->name }}</h3></a>
    <p class="card-text " style="font-size:15px;line-height:25px">
      {!! 
      substr(strip_tags($item->description),0,100) !!}@if(strlen(strip_tags($item->description))>100) ... @endif</p>
    <a href="{{ route('page',$item->slug) }}" class="btn btn-success"><i class="fa fa-align-right"></i> read more</a>
  </div>
</div>