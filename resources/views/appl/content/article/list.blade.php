
@if(count($objs)!=0)
<div class="row ">
@foreach($objs as $obj)
@if($obj->status==1)
<div class="col-12 col-md-6 ">
 <div class="p-2 bg-white mb-3" style="box-shadow: 2px 2px 2px 2px #eee">
  <div class="row no-gutters">
   @if(Storage::disk('s3')->exists($obj->image))
   <div class="col-5" >
    <div class="p-3">
     <a href="{{ route('page',$obj->slug) }}" >
      <img src="{{ Storage::disk('s3')->url($obj->image) }} " class=" card-img-top" alt="{{  $obj->name }}" style="width:100%">
           

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

