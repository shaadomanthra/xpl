@extends('layouts.nowrap-white')
@section('title', $obj->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="bg">
<div class="dblue " >
  <div class="container p-4">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">
        <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('training.index')}}">Trainings</a></li>
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-chevron-circle-right text-primary"></i> {{ $obj->name }}</p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
         <div class="card card-custom card-stretch gutter-b mt-md-3 text-center" style=''>
          <div class="pt-5">
          <div class="h6">Participants</div>
          <div class="display-4 mb-0" ><a href="{{ route('training.students',$obj->slug)}}" >{{$obj->users->count()}}</a>
          </div>
        </div>
      </div>
        
      </div>
    </div>
  </div>

<div class='p-3 mb-5 ddblue' >
  <div class='container'>
    <a href="{{route('trainingpage.show',$obj->slug)}}" class="f20 text-white" > <i class="fa fas fa-share-square text-white fa-external-link" ></i> {{route('trainingpage.show',$obj->slug)}}</a>&nbsp; @if($obj->status!=1)
                <span class="badge badge-secondary">Draft</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif

                @can('update',$obj)
              <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm float-right text-white">
                      <li class="breadcrumb-item">
                        <a href="{{ route('training.edit',$obj->slug) }}" class="text-white"> Edit</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="" class="text-white" data-toggle="modal" data-target="#exampleModal2">Add Participants</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="" class="text-white" data-toggle="modal" data-target="#exampleModal">Delete</a>
                      </li>
                    </ul>
                @endcan
        
            
    </div>
  </div>
</div>


<div class="container ">
  <div class="pb-1"></div>
  @include('flash::message')
  <div class="row mt-1">
    <div class="col-12 col-md-4 col-lg-3">
      <!--begin::Mixed Widget 14-->
                    <div class="card card-custom gutter-b ">
                      <!--begin::Header-->
                      <div class="card-header border-0 pt-5">
                        <h3 class="card-title font-weight-bolder">Sessions</h3>
                        <div class="card-toolbar">
                            {{$obj->progress()}}/{{$obj->sessions}}
                        </div>
                      </div>
                      <!--end::Header-->
                      <!--begin::Body-->
                      <div class="card-body d-flex flex-column">
                        <div class="flex-grow-1">
                          <div id="kt_mixed_widget_14_chart" style="height: 200px;" data-series="{{$obj->progress_percent()}}"></div>
                        </div>
                        
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 14-->
    </div>

    <div class="col-12 col-md-5 col-lg-6">

     <!--begin::Stats Widget 1-->
                    <div class="card card-custom bgi-no-repeat gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-4.svg)">
                      <!--begin::Body-->
                      <div class="card-body">
                        <a href="#" class="card-title font-weight-bold text-muted text-hover-primary font-size-h5 ">Details</a>
                        <p class="text-dark-100 font-weight-bolder  mt-5">{!! $obj->details!!}</p>
                        <div class="d-flex flex-wrap mt-14">
                        <div class="mr-12 d-flex flex-column mb-7">
                          <span class="d-block font-weight-bold mb-4">Start Date</span>
                          <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">{{\carbon\carbon::parse($obj->start_date)->format('d M, Y') }}</span>
                        </div>
                        <div class="mr-12 d-flex flex-column mb-7">
                          <span class="d-block font-weight-bold mb-4">Due Date</span>
                          <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">{{\carbon\carbon::parse($obj->due_date)->format('d M, Y') }}</span>
                        </div>
                      </div>
                      </div>
                      <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 1-->


        <div class="card card-custom gutter-b">
    <div class="card-header">
  <div class="card-title">
   <h3 class="card-label">
    Banner Image
   </h3>
  </div>
 </div>
        <div class="">
      @if(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.png'))
              <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.png')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('training.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm m-3"> delete banner</a></div>
              @elseif(Storage::disk('public')->exists('articles/training_b_'.$obj->slug.'.jpg'))
              <img src="{{ asset('/storage/articles/training_b_'.$obj->slug.'.jpg')}}?time={{microtime()}}" class=" w-100" />
              <div>
              <a href="{{ route('training.show',$obj->slug)}}?delete=banner" class="btn btn-danger btn-sm m-3"> delete banner</a></div>
              @else
              <img src="{{ asset('/img/clients/logo_notfound.png')}}" class="float-right" />
              @endif
            </div>
  </div>

    </div>

    <div class="col-12 col-md-5 col-lg-3">

      <!--begin::Stats Widget 4-->
      <div class="card card-custom gutter-b">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center py-0 mt-8">
          <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
            <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">{{$obj->trainer->name}}</a>
            <span class="font-weight-bold text-muted font-size-lg">Trainer</span>
          </div>
          <img src="{{ asset('assets/media/svg/avatars/009-boy-4.svg') }}" alt="" class="align-self-end h-100px" />
        </div>
        <!--end::Body-->
      </div>
      <!--end::Stats Widget 4-->

      <!--begin::Stats Widget 4-->
      <div class="card card-custom gutter-b">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center py-0 mt-8">
          <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
            <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">{{$obj->tpo->name}}</a>
            <span class="font-weight-bold text-muted font-size-lg">College TPO</span>
          </div>
          <img src="{{ asset('assets/media/svg/avatars/004-boy-1.svg') }}" alt="" class="align-self-end h-100px" />
        </div>
        <!--end::Body-->
      </div>
      <!--end::Stats Widget 4-->

      <!--begin::Tiles Widget 11-->
      
      <div class="row mb-4">
        <div class="col-6 col-md-6">
          <a href="{{ route('schedule.index',$obj->slug)}}">
          <div class="card card-custom bg-info gutter-b" >
        <div class="p-4 text-center">
         <span class="svg-icon svg-icon-white svg-icon-5x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Dial-numbers.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="4" y="10" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="10" y="4" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="10" y="10" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="16" y="4" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="16" y="10" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="4" y="16" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="10" y="16" width="4" height="4" rx="2"/>
        <rect fill="#000000" x="16" y="16" width="4" height="4" rx="2"/>
    </g>
</svg><!--end::Svg Icon--></span>
          <div class="text-inverse-success font-weight-bolder font-size-h5 text-center mt-3">Schedule</div>
        </div>
      </div>
    </a>
      <!--end::Tiles Widget 11-->
          
        </div>
        <div class="col-6 col-md-6">
          <a href="{{ route('resource.index',$obj->slug)}}">
          <div class="card card-custom bg-success gutter-b" >
        <div class="p-4 text-center">
        <span class="svg-icon svg-icon-white svg-icon-5x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Cloud-download.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
        <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-270.000000) translate(-11.959697, -18.661508) "/>
    </g>
</svg><!--end::Svg Icon--></span>
          <div class="text-inverse-success font-weight-bolder font-size-h5 text-center mt-3">Resources</div>
        </div>
      </div>
    </a>
        </div>
        
      </div>

         

      
    </div>

  </div> 



</div>




  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This following action is permanent and it cannot be reverted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('post.destroy',$obj->slug)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{route('participant_import',$obj->slug)}}" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Participants</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput ">Excel File </label>
        <input type="file" class="form-control" name="users" id="formGroupExampleInput" placeholder="Enter the  path" 
          >
          <small class="text-secondary">Kindly use only .xlsx format</small>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="slug" value="{{ $obj->slug }}">
        <button type="submit" class="btn btn-primary">Upload Excel</button>
        
      </div>
      </form>
    </div>
  </div>
</div>
</div>


@endsection