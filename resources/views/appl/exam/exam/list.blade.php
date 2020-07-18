
 @if($exams->total()!=0)

 <div class="row no-gutters">
        @foreach($exams as $key=>$exam)  
        <div class="col-12 col-md-6">
          <div class="cardbox p-3 mb-3 mr-2 ml-2" >
          <div class="row">
            <div class='col-2 col-md-3'>
              @if(isset($exam->image))
                @if(Storage::disk('s3')->exists($exam->image))
                <div class=" text-center">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url($exam->image) }} " class="d-print-none w-100" alt="{{  $exam->name }}" style='max-width:80px;'>
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
                <a href=" {{ route('exam.show',$exam->slug) }} ">
                @if($exam->status==0)
                <i class="fa fa-square-o"></i> 
                @elseif($exam->status==1)
                  <i class="fa fa-globe"></i> 
                @else
                  <i class="fa fa-lock"></i> 
                @endif  
                  {{ $exam->name }}
                </a>

              </h4>
              <div>
                  @if($exam->active==1)
                <span class=" badge badge-secondary">Inactive</span>
                @else
                  <span class=" badge badge-success">Active</span>
                @endif

               
              </div>
              <div class='mt-1'>
                 @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee',]))
                <span class=" border p-0 rounded pr-2 pl-2 pb-1 "><small>{{$exam->user->name}}</small></span>

                @endif
              </div>
              
            </div>
            <div class='col-2 col-md-2'>
              <div class="heading_one float-right f30">{{ $exam->getAttemptCount() }}</div>
            </div>
          </div>
        </div>
              </div>
              @endforeach      
          </div>
        @else
        <div class="card card-body bg-light">
          No Exams listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($exams->total() > config('global.no_of_records'))mt-3 @endif">
        {{$exams->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
