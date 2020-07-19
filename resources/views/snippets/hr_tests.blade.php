
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
                <a href=" {{ route('exam.show',$e->slug) }} " data-toggle="tooltip" title="View Test">
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
              
            </div>
            <div class='col-2 col-md-2'>
              <div class="heading_one float-right f30">
              	<a href="{{ route('test.report',$e->slug)}}" data-toggle="tooltip" title="Attempts">
              	@if(isset($e)){{ $e->getAttemptCount() }}@endif
              	</a>
              </div>
            </div>

          </div>
        </div>
        <div class="line" style="padding:1px;background:#ebf1fb"></div>  
        	<div class="p-4">

          
        	@foreach($e->latestUsers() as $t)
        		<div class="mb-2"><img src="@if($t->user->getImage()) {{ ($t->user->getImage())}}@else {{ Gravatar::src($t->user->email, 20) }}@endif" class="img-cirlce" style="width:20px" /> &nbsp; &nbsp;
        			<a href="{{ route('profile','@'.$t->user->username) }}" data-toggle="tooltip" title="View  Profile">{{$t->user->name}} </a>

        		  @if($t->status || $e->slug=='psychometric-test')
              has attempted the test
              @else
               has scored <a href="{{ route('assessment.analysis',$e->slug)}}?student={{$t->user->username}}" data-toggle="tooltip" title="View  Report"><b class="">
                @if($t->score){{ $t->score }}@else 0 @endif</b></a> / {{ $t->max }}
              @endif

        		<span class="float-right text-secondary"><small>{{$t->created_at->diffForHumans()}}</small></span></div>
        	@endforeach
          
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