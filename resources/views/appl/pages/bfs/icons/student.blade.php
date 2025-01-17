
 @if($user->trainings->count()!=0)
 @foreach($user->trainings as $key=>$obj)  
 <div class="col-12 col-md-6">
  <!--begin::Card-->
  <div class="card card-custom gutter-b card-stretch ">
    <!--begin::Body-->
    <div class="card-body">
      <!--begin::Section-->
      <div class="d-flex align-items-center">
        <!--begin::Pic-->
        <div class="flex-shrink-0 mr-4 symbol symbol-65 symbol-circle">
          <div class="symbol symbol-50 symbol-light-{{$obj->progress_color()}} mr-1">
            <span class="symbol-label">
              <span class="svg-icon svg-icon-{{$obj->progress_color()}} svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z" fill="#000000" fill-rule="nonzero"/>
                    <path d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z" fill="#000000" opacity="0.3"/>
                  </g>
                </svg></span>
              </span>
            </div>
          </div>
          <!--end::Pic-->
          <!--begin::Info-->
          <div class="d-flex flex-column mr-auto">
            <!--begin: Title-->
            <a href="{{route('trainingpage.show',$obj->slug)}}" class="card-title text-hover-primary font-weight-bolder font-size-h5 text-dark mb-1">{{$obj->name}}</a>
            <span class="text-muted font-weight-bold">{{$obj->progress_message()}}</span>
            <!--end::Title-->
          </div>
          <!--end::Info-->
          <!--begin::Toolbar-->
          <div class="card-toolbar mb-auto">

          </div>
          <!--end::Toolbar-->
        </div>
        <!--end::Section-->
        <!--begin::Content-->
        <div class="d-flex flex-wrap mt-14">
          <div class="mr-12 d-flex flex-column mb-7">
            <span class="d-block font-weight-bold mb-4">Start Date</span>
            <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">{{\carbon\carbon::parse($obj->start_date)->format('d M, Y') }}</span>
          </div>
          <div class="mr-12 d-flex flex-column mb-7">
            <span class="d-block font-weight-bold mb-4">Due Date</span>
            <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">{{\carbon\carbon::parse($obj->due_date)->format('d M, Y') }}</span>
          </div>
          <!--begin::Progress-->
          <div class="flex-row-fluid mb-7">
            <span class="d-block font-weight-bold mb-4">Progress</span>
            <div class="d-flex align-items-center pt-2">
              <div class="progress progress-xs mt-2 mb-2 w-100">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$obj->progress_percent()}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="ml-3 font-weight-bolder">{{$obj->progress_percent()}}%</span>
            </div>
          </div>
          <!--end::Progress-->
        </div>
        <!--end::Content-->
        
     
          </div>
          <!--end::Body-->
          
        </div>
        <!--end::Card-->
</div>
 @endforeach
       
 @else
 <div class="card card-body bg-light">
  No {{ $app->module }} listed
</div>
@endif
