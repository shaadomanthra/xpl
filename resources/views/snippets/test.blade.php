 <div class="col-12 col-md-6">
        <div class="mb-4 cardbox">
          <div class="lblue " style="border-radius:5px;">
          <div class=" bg-white p-4  " style='border-radius: 5px;'>
          <div class="row">
            <div class='col-2 col-md-3'>
              @if(isset($e->image))
                @if(Storage::disk('s3')->exists($e->image))
                <div class=" text-center">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url($e->image) }} " class="d-print-none w-100" alt="{{  $e->name }}" style='max-width:80px;'>
                  </picture>
                </div>
                @endif
              @else
              <div class="text-center text-secondary">
                <i class="fa fa-newspaper-o fa-4x p-1 d-none d-md-block" aria-hidden="true"></i>
                <i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
              </div>
              @endif
            </div>
            <div class='col-8 col-md-9'>
              <h4 class="mb-1 mt-2 lh15">
                <a href=" {{ route('assessment.details',$e->slug) }} ">
                @if($e->status==0)
                <i class="fa fa-square-o"></i> 
                @elseif($e->status==1)
                  <i class="fa fa-globe"></i> 
                @else
                  <i class="fa fa-lock"></i> 
                @endif  
                  {{ $e->name }}
                </a>

              </h4>
              <div>
                  @if($e->active==1)
                <span class=" badge badge-secondary">Inactive</span>
                @else
                  <span class=" badge badge-success">Active</span>
                @endif
              </div>

              <div>
                <a href="{{ route('assessment.details',$e->slug)}}" class='btn btn-outline-primary btn-sm mt-3'>
                  <i class="fa fa-paper-plane"></i>
                  Try Now
                </a>
              </div>
              
            </div>
           

          </div>
        </div>
        
        </div>
    </div>
              </div>