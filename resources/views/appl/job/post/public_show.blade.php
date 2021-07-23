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

        

        <h1 class="mb-4 mt-3">{{$obj->title}}</h1>
        
          @include('flash::message')

        @if(trim($status_message))
        <div class="alert alert-primary alert-important mt-3">
          <h4>Important Note:</h4>
        {!! $status_message !!}
        </div>
        @endif

        <div class="">
          
        {!!$obj->details !!}

        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mt-4">
      <div class="alert alert-warning alert-important" role="alert">
        <h5>Last date for application </h5>
        <div class="display-5 h3">{{\carbon\carbon::parse($obj->last_date)->format('M d, Y h:i a' )}}</div>
      </div>


    @include('appl.job.post.apply')

    </div>

    <div class="mt-4 mb-5" style="word-wrap: break-word;">
      <h3>Information</h3>
      <div class="row mb-2">
            <div class="col-6"><i class="fa fa-map-marker"></i>&nbsp; Locations</div>
            <div class="col-6">{{ucwords(str_replace(',',', ',ucwords(strtolower($obj->location))))}}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-university"></i>&nbsp; Eligibility</div>
            <div class="col-6">{{ucwords(str_replace(',',', ',ucwords(strtoupper($obj->education))))}}</div>
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
            <div class="col-6">
              @if($obj->salary_num)
              {{$obj->salary_num}} 
              @else
              {{$obj->salary}} 
              @endif
            </div>
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

@auth
<div class="modal fade bd-example-modal-lg" id="myModal4"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
  <div class="modal-dialog ">
    <form action="{{ route('post.apply',$obj->slug)}}" method="post" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header h4">
        Confirm Details
      </div>
      <div class="modal-body">
        <div class="mt-3  mb-3 h5 text-primary">Profile Information</div>
        <div class="row mb-2">
            <div class="col-4">Name</div>
            <div class="col-8">{{\auth::user()->name}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Email</div>
            <div class="col-8">{{\auth::user()->email}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Phone</div>
            <div class="col-8">{{\auth::user()->phone}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">College</div>
            @if(isset(\auth::user()->college->name))
            <div class="col-8">{{\auth::user()->college->name}}
            </div>
            @endif
          </div>
          <div class="row mb-2">
             @if(isset(\auth::user()->branch->name))
            <div class="col-4">Branch</div>
            <div class="col-8">{{\auth::user()->branch->name}}</div>
            @endif
          </div>
          <div class="row mb-2">
            <div class="col-4">Year of passing</div>
            <div class="col-8">{{\auth::user()->year_of_passing}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Hometown</div>
            <div class="col-8">{{\auth::user()->hometown}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Current City</div>
            <div class="col-8">{{\auth::user()->current_city}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Aadhar Number</div>
            <div class="col-8">{{\auth::user()->aadar}}</div>
          </div>
          <div class="mt-3  mb-3 h5 text-primary">Academic Percentages</div>
          <div class="row mb-2">
            <div class="col-4">Class 10th</div>
            <div class="col-8">{{\auth::user()->tenth}}</div>
          </div>
          <div class="row mb-2">
            <div class="col-4">Class 12th</div>
            <div class="col-8">{{\auth::user()->twelveth}}</div>
          </div>
           <div class="row mb-2">
            <div class="col-4">Graduation</div>
            <div class="col-8">{{\auth::user()->bachelors}}</div>
          </div>
           <div class="row mb-2">
            <div class="col-4">Masters</div>
            <div class="col-8">{{\auth::user()->masters}}</div>
          </div>
          <div class="mt-3  mb-3 h5 text-primary">Resume</div>
          <div class="row mb-2">
            <div class="col-4">Document</div>
            <div class="col-8">
              @if(Storage::disk('s3')->exists('resume/resume_'.\auth::user()->username.'.pdf'))
                <span class="badge badge-success">Uploaded</span>
              @else
              <span class="badge badge-secondary">not uploaded</span>
              @endif
            </div>
          </div>

        @if($form)
          <div class="mt-3  mb-3 h5 text-primary">Questions from Recruiter</div>
          @foreach($form as $k=>$f)
            @if($f['type']=='input')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <input type="text" class="form-control" name="questions_{{ str_replace(' ','_',$f['name'])}}" required >
            </div>
            @elseif($f['type']=='textarea')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="questions_{{ str_replace(' ','_',$f['name'])}}" rows="{{$f['values']}}"></textarea>
            </div>
            @elseif($f['type']=='radio')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <select class="form-control" name="questions_{{ str_replace(' ','_',$f['name'])}}"  id="exampleFormControlSelect1">
                @foreach($f['values'] as $v)
                <option value="{{$v}}">{{$v}}</option>
                @endforeach
              </select>
            </div>
            @elseif($f['type']=='file')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <input type="file" class="form-control-file" name="questions_{{ str_replace(' ','_',$f['name'])}}" id="exampleFormControlFile1">
            </div>
            @else
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                @foreach($f['values'] as $m=>$v)
              <div class="form-check">
                <input class="form-check-input" name="questions_{{ str_replace(' ','_',$f['name'])}}[]" type="checkbox" value="{{$v}}" id="defaultCheck{{$m}}">
                <label class="form-check-label" for="defaultCheck{{$m}}">
                  {{$v}}
                </label>
              </div>
              @endforeach
            </div>
            @endif
          @endforeach
      @endif

      @if($accesscode)
        <div class="bg-light border p-3 my-2 rounded mt-4">
          <div class=" h5 text-primary">Access Code</div>
          <small class="mb-3">This job posting is private, you have to enter the access code to apply.</small>
          <input type="text" class="form-control" name="accesscode" required >
        </div>
      @else
        <input type="hidden" name="accesscode" value="true">
      @endif

      <hr>
      <p>I hereby declare that the information provided is true and correct. I also understand that any willful
dishonesty may render for refusal of this application or immediate termination in the recruitment process.</p>

      </div>

      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="apply" value="1">
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Submit Application</button>
    
    </div>
      
      </div>
    </div>
  </div>
</div>
@endauth
@endsection