@extends('layouts.nowrap-white')
@section('title', $obj->title)
@section('content')

@include('appl.exam.exam.xp_css')


<div class="banner">
  @if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.png'))
  <img src="{{ Storage::disk('s3')->url('post/job_b_'.$obj->slug.'.png') }}" class=" w-100" />
  @elseif(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.jpg'))
  <img src="{{ Storage::disk('s3')->url('post/job_b_'.$obj->slug.'.jpg') }}" class=" w-100" />
  @else
  <div class="p-5" style="background: #8ec6f9"></div>

  @endif
</div>
<div class="bg-light">
<div class="container ">
  <div class="row">
    <div class="col-12 col-md-8">
      <div class="bg-white mb-2 mb-md-5 p-4 p-md-5" style="margin-top:-50px">
        <div class="float-right pb-4 pl-4">
          @if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.jpg'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.jpg') }} " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @elseif(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.png'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src=" {{ Storage::disk('s3')->url('post/job_'.$obj->slug.'.png') }}  " class="d-print-none w-100" alt="{{  $obj->title }}" style='max-width:100px;'>
                  </picture>
                </div>
              @endif
            </div>
        <h1 class="mb-4">{{$obj->title}}</h1>
        @include('flash::message')
        <div class="">
          
        {!!$obj->details !!}

        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mt-4">
      <div class="alert alert-warning alert-important" role="alert">
        <h5>Last date for application </h5>
        <div class="display-5 h3">{{\carbon\carbon::parse($obj->last_date)->format('M d, Y')}}</div>
      </div>
    @include('appl.job.post.apply')

    </div>

    <div class="mt-4 mb-5" style="word-wrap: break-word;">
      <h3>Information</h3>
      <div class="row mb-2">
            <div class="col-6"><i class="fa fa-map-marker"></i>&nbsp; Locations</div>
            <div class="col-6">{{str_replace(',',', ',$obj->location)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-university"></i>&nbsp; Eligibility</div>
            <div class="col-6">{{str_replace(',',', ',$obj->education)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calendar"></i>&nbsp; Year of passing</div>
            <div class="col-6">{{str_replace(',',', ',$obj->yop)}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-graduation-cap"></i>&nbsp; Academics </div>
            <div class="col-6">{{$obj->academic}}% & above</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-flickr"></i>&nbsp; Salary</div>
            <div class="col-6">{{$obj->salary}} </div>
          </div>
    </div>
    </div>
  </div>

</div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal2"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
     
      <div class="modal-body">
       Kindly Login to view the content
      </div>
      {{
          request()->session()->put('redirect.url',url()->current())
      }}
      
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('login')}}">
        <button type="button" class="btn btn-success">Login</button>
      </a>
      <a href="{{ route('student.eregister')}}">
        <button type="button" class="btn btn-primary">Register</button>
      </a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal3"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog ">

    <div class="modal-content">
      <div class="modal-header h4">
        Profile Incomplete
      </div>
      <div class="modal-body">
       Kindly complete your profile to apply for this job.
      </div>
      {{
          request()->session()->put('redirect.url',url()->current())
      }}
      
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <a href="{{ route('profile.complete')}}">
        <button type="button" class="btn btn-primary">Complete Profile</button>
      </a>
      
      </div>
    </div>
  </div>
</div>
@endsection