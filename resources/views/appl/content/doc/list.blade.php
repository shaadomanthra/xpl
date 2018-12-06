 @if($docs->total()!=0)     
 <div class="row ">
    
  @foreach($docs as $key=>$doc)  
  @if($doc->status ==1)
<div class="col-12 col-md-4 mb-4"> 
  
          <div class="bg-white border">
              <div class="">
                @if($doc->image)
                <div class="bg-white ">
                  <img src="{{ $doc->image }}" class="w-100"/>
                </div>
                @endif
                <div class=" p-3" style="background: #fff">
                  <h1>{{ $doc->name }}</h1>

                    <div class="pt-2 ">
                   
                  <a href="{{ route('docs.show',$doc->slug) }}">
                  <button class="btn btn-outline-success btn-sm"> <i class="fa fas fa-up" ></i> View Track</button>
                  </a>
                </div>
              </div>
              </div>
          </div>
    
</div>
  @endif
    @endforeach  
  </div>          
@else
  <div class="card card-body bg-light mb-4">
    No tests listed 
    @if(request()->has('filter'))
      in {{ request()->get('filter')}}
    @endif
  </div>
@endif

<nav aria-label="Page navigation  " class="card-nav @if($docs->total() > config('global.no_of_records'))mt-3 @endif">
  {{$docs->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
</nav>


