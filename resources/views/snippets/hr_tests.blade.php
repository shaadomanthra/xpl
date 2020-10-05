
 @if($exams->total()!=0)
<div class="row ">
@foreach($exams as $key=>$e)  

   
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
            <div class='col-8 col-md-7'>


              <h4 class="mb-1 mt-2 lh15">

                @if(isset($e->pivot->role))
                  @if($e->pivot->role=='viewer')
                  <a href=" {{ route('test.active',$e->slug)}} " data-toggle="tooltip" title="View Test">
                  @else
                  <a href=" {{ route('exam.show',$e->slug) }} " data-toggle="tooltip" title="View Test">
                  @endif
                @else
                  <a href=" {{ route('exam.show',$e->slug) }} " data-toggle="tooltip" title="View Test">
                @endif
                
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


                @if($user->role==13)
                   <span class=" badge badge-warning">Admin</span>
                @else

                  @if(isset($e->pivot->role))
                    @if($e->pivot->role=='viewer')
                    <span class=" badge badge-secondary">Invigilator</span>
                    @elseif($e->pivot->role=='evaluator')
                    <span class=" badge badge-primary">Evaluator</span>
                    @elseif(auth::user()->role==13)
                      <span class=" badge badge-warning">Admin</span>
                    @else
                      <span class=" badge badge-warning">Owner</span>
                    @endif
                  @endif


                @endif
                

              </div>
              
            </div>
            <div class='col-2 col-md-2'>
              @if($user->role==13)
                <div class="heading_one float-right f30">
                    <a href="{{ route('test.report',$e->slug)}}" data-toggle="tooltip" title="Attempts">
                    @if(isset($e)){{ $e->users_count }}@endif
                    </a>
                  </div>
              @else

                @if(isset($e->pivot->role))
                 @if($e->pivot->role!='viewer')
                  <div class="heading_one float-right f30">
                    <a href="{{ route('test.report',$e->slug)}}" data-toggle="tooltip" title="Attempts">
                    @if(isset($e)){{ $e->users_count }}@endif
                    </a>
                  </div>
                  @endif
                @endif

              @endif
               
            </div>

          </div>
        </div>
        	<div class="pb-1">

          
        	
          
        </div>
        </div>
    </div>
              </div>
              @endforeach  
            </div>
@endif

<nav aria-label="Page navigation  " class="card-nav @if($exams->total() > 8)my-3 @endif">
        {{$exams->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>