@extends('layouts.nowrap-white')
@section('title', $exam->name)
@section('content')

@include('appl.exam.exam.xp_css')


<div class="dblue" >
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-10">
        <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
            @if(auth::user()->isAdmin())
            <li class="breadcrumb-item"><a href="{{ url('/exam')}}">Tests</a></li>
            @else
            <li class="breadcrumb-item">Tests</li>
            @endif
          </ol>
        </nav>
        <div class=' pb-3'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-inbox "></i> {{ $exam->name }}</p>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2">
        <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Attempts</div>
          <div class="h2" ><a href="{{ route('test.report',$exam->slug)}}" >{{$exam->users_count}}</a></div>
        </div>
      </div>
    </div>
  </div>

<div class='p-3 mb-3 ddblue' >
  <div class='container'>
    <a href="{{route('assessment.show',$exam->slug)}}" class="f20 text-white" > <i class="fa fa-external-link" ></i> {{route('assessment.show',$exam->slug)}}</a>&nbsp; @if($exam->active==1)
                <span class="badge badge-secondary">Inactive</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif
          @can('update',$exam)
            <span class="btn-group float-md-right btn-group-sm mt-2 mt-md-0" role="group" aria-label="Basic example">
              <a href="{{ route('exam.edit',$exam->slug) }}" class="btn btn-outline-light" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i> edit</a>
                <a href="" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal4" data-tooltip="tooltip" data-placement="top" title="Download"><i class="fa fa-cloud-download"></i> Download</a>
              @if(\Auth::user()->checkRole(['administrator','editor']))
               
              <a href="" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal2" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-retweet"></i> copy</a>
              <a href="" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal3" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-user"></i> change owner</a>
              @endif
              <a href="#" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i> delete</a>
            </span>
            @endcan
    </div>
  </div>
</div>


<div class="container ">

  <div class="alert alert-important alert-info mt-3">
    Data is cached for faster access. Refresh Cache to load the updated data.
    <a href="{{request()->url()}}?refresh=1">
    <span class="float-right"><i class="fa fa-retweet"></i> Refresh Now</span>
    </a>
  </div>

  @include('flash::message')
  <div class="row mt-4">
    <div class="col-12 col-md-6 col-lg-7">
      <div class="card mb-4 ">
        <div class="card-body">
            <div class="row mb-2">
            <div class="col-5  col-md-4 col-lg-3 pt-1">
              @if(isset($exam->image))
                @if(Storage::disk('s3')->exists($exam->image))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url($exam->image) }} " class="d-print-none w-100" alt="{{  $exam->name }}" style='max-width:200px;'>
                  </picture>
                </div>
                @endif
              @else
              <div class="text-center">
                <i class="fa fa-newspaper-o fa-5x p-1 d-none d-md-block" aria-hidden="true"></i>
                <i class="fa fa-newspaper-o  fa-2x d-inline d-md-none" aria-hidden="true"></i>
              </div>
              @endif
            </div>
            <div class="col-12 col-md-12 col-lg-9">
              <div class="pt-2 f18 mb-4 lh15" >
              <h4 class="mb-3"><i class="fa fa-angle-right"></i> Description 
                @can('update',$exam)
                <a href="{{ route('exam.edit',$exam->slug)}}?id=description" class="float-right"><i class="fa fa-edit"></i> edit</a>
                @endcan
              </h4>
              {!! $exam->description !!}
              </div>


              <h4 class="mb-3"><i class="fa fa-angle-right"></i> Settings 
                @can('update',$exam)
                <a href="{{ route('exam.edit',$exam->slug)}}?id=settings" class="float-right"><i class="fa fa-edit"></i> edit</a>
                @endcan
              </h4>
              <div class="row mb-2">

            <div class="col-6"><i class="fa fa-th"></i>&nbsp; Report</div>
            <div class="col-6">
              @if($exam->solutions==1)
                <span class="badge badge-warning">No solutions</span>
              @elseif($exam->solutions==2)
              <span class="badge badge-warning">No report</span>
              @else
                <span class="badge badge-primary">Report with solutions</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-bars"></i>&nbsp; Testtype</div>
            <div class="col-6">
              {{$data['examtype']->name}}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calculator"></i>&nbsp; Calculator</div>
            <div class="col-6">
              @if($exam->calculator==1)
                <span class="badge badge-success">Enabled</span>
              @else
                <span class="badge badge-secondary">Disabled</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-camera"></i>&nbsp; Camera</div>
            <div class="col-6">
              @if($exam->camera==1)
                <span class="badge badge-success">Enabled</span>
              @else
                <span class="badge badge-secondary">Disabled</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-image"></i>&nbsp; Capture Frequency</div>
            <div class="col-6">
              @if($exam->capture_frequency==0)
                <span class="badge badge-warning">None</span>
              @else
                Every {{$exam->capture_frequency}} secs
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-laptop"></i>&nbsp; Window Swap</div>
            <div class="col-6">
              @if($exam->window_swap==1)
                <span class="badge badge-success">Enabled</span>
              @else
                <span class="badge badge-secondary">Disabled</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-minus-square-o"></i>&nbsp; Auto Terminate</div>
            <div class="col-6">
              @if($exam->auto_terminate==0)
                <span class="badge badge-warning">None</span>
              @else
                After {{$exam->auto_terminate }} swaps
              @endif
            </div>
          </div>

         

          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-check-square"></i>&nbsp;Exam Status</div>
            <div class="col-6">
              @if($exam->status==0)
                <span class="badge badge-warning">Draft</span>
              @elseif($exam->status==1)
                <span class="badge badge-success">Free Access</span>
              @else
                <span class="badge badge-primary">Private</span>
              @endif
            </div>
          </div>


          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-mobile-phone"></i>&nbsp;Mobile Disable</div>
            <div class="col-6">
              @if($exam->extra==0)
                <span class="badge badge-warning">No</span>
              @elseif($exam->extra==1)
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-retweet"></i>&nbsp;Question Shuffle</div>
            <div class="col-6">
              @if($exam->shuffle==0)
                <span class="badge badge-warning">No</span>
              @elseif($exam->shuffle==1)
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-cloud-upload"></i>&nbsp;Save Responses</div>
            <div class="col-6">
              @if($exam->save==0)
                <span class="badge badge-warning">No</span>
              @elseif($exam->save==1)
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-commenting-o"></i>&nbsp;Chat</div>
            <div class="col-6">
              @if($exam->chat=="no")
                <span class="badge badge-warning">No</span>
              @elseif($exam->chat=="yes")
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

           <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-user-circle-o"></i>&nbsp;Approval</div>
            <div class="col-6">
              @if($exam->manual_approval=="no")
                <span class="badge badge-warning">Automatic</span>
              @elseif($exam->manual_approval=="yes")
                <span class="badge badge-success" >Manual</span>
              @endif
            </div>
          </div>


          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-bars"></i>&nbsp;Section Timer</div>
            <div class="col-6">
              @if($exam->section_timer=="no")
                <span class="badge badge-warning">No</span>
              @elseif($exam->section_timer=="yes")
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6"> <i class="fa fa-bars"></i>&nbsp;Marking Scheme</div>
            <div class="col-6">
              @if($exam->section_marking=="no")
                <span class="">Question Wise</span>
              @elseif($exam->section_marking=="yes")
                <span class="" >Section Wise</span>
              @endif
            </div>
          </div>




          <div class="row mb-0">
            <div class="col-6"> <i class="fa fa-user"></i>&nbsp;Ownership</div>
            <div class="col-6">
              {{$exam->user->name}}
            </div>
          </div>


          @if(subdomain()=='rguktn' || subdomain()=='rguktrkv')
           <h4 class="my-3"><i class="fa fa-angle-right"></i> Other Details</h4>
          
          <div class="row mb-0">
            <div class="col-6"> <i class="fa fa-th"></i>&nbsp;Mid paper</div>
            <div class="col-6">
              @if(!$exam->mid)
                <span class="badge badge-warning">No</span>
              @elseif($exam->mid)
                <span class="badge badge-success" >Yes</span>
              @endif
            </div>
          </div>

           <div class="row mb-0">
            <div class="col-6"> <i class="fa fa-th"></i>&nbsp;Set Creation</div>
            <div class="col-6">
              @if(!$exam->sets)
                <span class="badge badge-warning">No</span>
              @elseif($exam->sets)
                <span class="badge badge-success" >Yes</span> <span class="badge badge-danger">{{$exam->qcount}} questions</span>
              @endif
            </div>
          </div>

          <div class="row mb-0">
            <div class="col-6"> <i class="fa fa-th"></i>&nbsp;Proctors Assigned</div>
            <div class="col-6">
              @if(!$exam->invigilation)
                <span class="badge badge-warning">No</span>
              @else
                <span class="badge badge-success" >Yes</span> <span class="badge badge-info">{{$exam->viewers()->wherePivot('role','viewer')->count()}} proctors</span>
              @endif
            </div>
          </div>

          @endif


            </div>
            </div>

        <div class="alert alert-warning alert-important mt-4">
          <h4>Link Status:
            @if($exam->active==1)
                <span class="badge badge-secondary">Inactive</span>
              @else
                <span class="badge badge-success">Active</span>
              @endif

              <span class="float-right"></span>
          </h4>
             <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calendar"></i>&nbsp; Link Auto Activation</div>
            <div class="col-6">
              @if(!$exam->auto_activation)
                -
              @else
                {{\carbon\carbon::parse($exam->auto_activation)->toDayDateTimeString()}}
              @endif
            </div>
          </div>


          @if(isset(json_decode($exam->getOriginal('settings'))->start_time))
           <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calendar"></i>&nbsp; Exam Start time</div>
            <div class="col-6">
                {{\carbon\carbon::parse(json_decode($exam->getOriginal('settings'))->start_time)->toDayDateTimeString()}}
            
            </div>
          </div>
          @endif

          <div class="row mb-2">
            <div class="col-6"><i class="fa fa-calendar"></i>&nbsp; Link Auto Deactivation</div>
            <div class="col-6">
              @if(!$exam->auto_deactivation)
                -
              @else
                {{\carbon\carbon::parse($exam->auto_deactivation)->toDayDateTimeString()}}
              @endif
            </div>
          </div>
          <div ><small class="text-secondary"><i class="fa fa-clock-o"></i>&nbsp; Current Server Time : &nbsp; {{\carbon\carbon::now()->toDayDateTimeString()}}</small></div>
          
          </div>
        </div>
      </div>

      <div class="card mb-4 ">
        <div class="card-body">
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Instructions 
              @can('update',$exam)
              <a href="{{ route('exam.edit',$exam->slug)}}?id=instructions" class="float-right"><i class="fa fa-edit"></i> edit</a>
              @endcan
            </h4>
            @if($exam->instructions)
              {!! $exam->instructions !!}
            @else
              -
            @endif
        </div>
      </div>

      @if(count($exam->sections))
      <div class=" mb-4 ">
        <div class="">
              <div class="table-responsive mb-0">
              <table class="table table-bordered rounded mb-0">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sections</th>
                    <th scope="col">Time</th>
                    <th scope="col">Mark per ques</th>
                    <th scope="col">Negative</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['sections'] as $w=>$section)
                  <tr>
                    <th scope="row">{{($w+1)}}</th>
                    <td><a href="{{ route('sections.show',[$exam->slug,$section->id]) }}">{{$section->name}}({{ count($section->questions)}})</a></td>

                    <td>{{ $section->time }} min</td>
                    <td>{{$section->mark}}</td>
                    <td>@if($section->negative)  -{{ $section->negative}} @else NA @endif</td>
                  </tr>
                            @endforeach
                  
                  
                </tbody>
              </table>
              </div>
        </div>
      </div>
      @endif

      <div class="card mb-4 ">
        <div class="card-body">
      <h4 class="mb-3"><i class="fa fa-angle-right"></i> Access Codes <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Test creator can uniquely name the access codes to categorise the participants based on job opening."></i> 
        @can('update',$exam)
        <a href="{{ route('exam.edit',$exam->slug)}}?id=accesscode" class="float-right"><i class="fa fa-edit"></i> edit</a>
        @endcan
      </h4>
      <hr>
      
      <div class="">
      @foreach(explode(',',$exam->code) as $code)
              @if($code)
              <a href="{{ route('test.report',$exam->slug)}}?code={{$code}}" class="btn btn-outline-primary mb-2 ">{{ $code}}({{ $data['code_'.$code]}})</a>
              @else
              <span class="text-secondary"> - No access codes defined</span>
              @endif &nbsp;&nbsp;
              @endforeach
       </div>
     </div>
   </div>
      
      <div class="card mb-4 ">
        <div class="card-body">
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Candidates Emails <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Only the listed candidates can attempt the test with a valid access code. If no emails are listed, then the test will be open for all."></i> 
              @can('update',$exam)
              <a href="{{ route('exam.edit',$exam->slug)}}?id=emails" class="float-right"><i class="fa fa-edit"></i> edit</a> 
              @endcan 
            </h4>
            <hr>
            @if($exam->emails)
            <div class="row ">
                <div class="col-12 col-md-4">
                  <div class="bg-light border rounded p-3">
                    <h5>Total</h5>
                    <div class="display-3">
                      <a href="" data-toggle="modal" data-target="#all_emails" data-tooltip="tooltip" data-placement="top" title="All Emails">{{count($email_stack['total']) }}</a></div>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="bg-light border rounded p-3">
                    <h5>Registered</h5>
                    <div class="display-3">
                      <a href="" data-toggle="modal" data-target="#registered_emails" data-tooltip="tooltip" data-placement="top" title="Registered Emails">{{ count($email_stack['registered']) }}</a></div>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="bg-light border rounded p-3">
                    <h5>Not Registered</h5>
                    <div class="display-3"><a href="" data-toggle="modal" data-target="#not_registered_emails" data-tooltip="tooltip" data-placement="top" title="Not Registered Emails">{{ count($email_stack['not_registered'])}}</a></div>
                  </div>
                </div>
            </div>
            
              @else
              <span class="text-secondary"> - No emails listed</span>
              @endif
        </div>
      </div>

      <div class="card mb-4 ">
        <div class="card-body">
            <h4 class="mb-3"><i class="fa fa-angle-right"></i> Banner in report page <i class="fa fa-question-circle text-secondary" data-toggle="tooltip" title="Only the listed candidates can attempt the test with a valid access code. If no emails are listed, then the test will be open for all."></i> 
              @can('update',$exam)
              <a href="{{ route('exam.edit',$exam->slug)}}?id=image" class="float-right"><i class="fa fa-edit"></i> edit</a> 

              @endcan
            </h4>
            <hr>
            @if(Storage::disk('s3')->exists('articles/'.$exam->slug.'_banner.jpg'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url('articles/'.$exam->slug.'_banner.jpg') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
                <a href="{{ route('exam.show',$exam->slug)}}?delete=banner" class="btn btn-danger btn-sm"> delete banner</a>
            @elseif(Storage::disk('s3')->exists('articles/'.$exam->slug.'_banner.png'))
                <div class="mb-3">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url('articles/'.$exam->slug.'_banner.png') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
                  </picture>
                </div>
                <a href="{{ route('exam.show',$exam->slug)}}?delete=banner" class="btn btn-danger btn-sm"> delete banner</a>
            @else
             - No Banner -
            @endif
        </div>
      </div>
     
     


    </div>

    <div class="col-12 col-md-6 col-lg-5">

      <div class="row mb-1">
        <div class="col-6 col-md-4">
          <a href="{{ route('sections.index',$exam->slug)}}">
          <div class="cardbox p-4 p-md-1 p-lg-4 text-center mb-4 ">
            <img src="{{ asset('img/icons/category.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Sections</h4>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4">
          <a href="{{ route('exam.questions',$exam->slug)}}">
          <div class="cardbox p-4 p-md-1 p-lg-4 text-center mb-4">
            <img src="{{ asset('img/icons/tag.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Questions</h4>
            </div>
          </a>
        </div>
        <div class="col-6 col-md-4">
          <a href="{{ route('test.accesscode',$exam->slug)}}">
          <div class="cardbox p-4 p-md-1 p-lg-4 text-center mb-0">
            <img src="{{ asset('img/icons/analytics.png')}}" class="w-100 p-2 mb-2" />
            <h4  class="mb-0">Reports</h4>
            </div>
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="h5 mb-3 alert alert-important alert-warning" ><a href="{{ route('test.live',$exam->slug)}}" class="  mt-3 mt-lg-0"><i class="fa fa-circle-o"></i> Ques Analysis </a> </div>

        </div>
        <div class="col-6">
          <div class="h5 mb-3 alert alert-important alert-warning" ><a href="{{ route('test.active',$exam->slug)}}" class="  mt-3 mt-lg-0"><i class="fa fa-circle-o"></i> Live Tracker  </a> </div>

        </div>

        <div class="col-6">
          <div class="h5 mb-3 alert alert-important alert-warning" ><a href="{{ route('test.proctorlist',$exam->slug)}}" class="  mt-3 mt-lg-0"><i class="fa fa-circle-o"></i> Proctors </a> </div>

        </div>
        <div class="col-6">
          <div class="h5 mb-3 alert alert-important alert-warning" ><a href="{{ route('test.candidatelist',$exam->slug)}}" class="  mt-3 mt-lg-0"><i class="fa fa-circle-o"></i> Candidates  </a> </div>

        </div>

        <div class="col-6">
          <div class="h5 mb-3 alert alert-important alert-warning" ><a href="{{ route('test.user_roles',$exam->slug)}}?evaluator=1" class="  mt-3 mt-lg-0"><i class="fa fa-circle-o"></i> Evaluators </a> </div>

        </div>

      </div>
      

      


      @if($data['attempt_count'])
      <div class="h4 mt-3 mb-4" ><i class="fa fa-angle-right"></i> Latest participants <small><span class="text-secondary">({{$exam->users_count}})</span></small><a href="{{ route('test.report',$exam->slug)}}" class="btn btn-outline-primary btn-sm float-lg-right mt-3 mt-lg-0">View all</a></div>

      @foreach($data['users'] as $u =>$t)
      <div class='cardbox lblue p-3 mb-3'>
        <div class="row">
          <div class='col-3 col-md-3 col-lg-2'>
            <img src="@if($t->user->getImage()) {{ ($t->user->getImage())}}@else {{ Gravatar::src($t->user->email, 150) }}@endif" class="img-cirlce " />
          </div>
          <div class='col-9 col-md-9 col-lg-10'>
            <div class="f18 mb-0">
              <a href="#" class="showuser"  data-url="{{route('profile','@'.$t->user->username)}}"><b>{{$t->user->name}}</b></a>

              @if($t->status || $exam->slug=='psychometric-test' || $data['examtype']->slug=='psychometric-test')
              has attempted the test
              @else
               has scored <b class="text-primary">
                @if($t->score){{ $t->score }}@else 0 @endif</b> out of {{ $t->max }}
              @endif
             
            </div>
            <small>{{$t->created_at->diffforHumans()}} </small>

            <div class=''>
              <small class="mr-2">
              <a href="{{ route('assessment.analysis',[$exam->slug]) }}?student={{$t->user->username}}" ><i class="fa fa-bar-chart"></i> Report</a></small>

              @if($exam->slug!='psychometric-test' && $data['examtype']->slug!='psychometric-test')
              <small class="mr-2">
              <a href="{{ route('assessment.responses',$exam->slug)}}?student={{$t->user->username}}" ><i class="fa fa-commenting-o"></i> Responses</a></small>
              @endif

              <small class="mr-2 float-lg-right @if($t->cheat_detect==1) text-danger @elseif($t->cheat_detect==2) text-warning @else text-success @endif">
                @if($t->cheat_detect==1)
                  <i class="fa fa-ban"></i> Potential Cheating  
                @elseif($t->cheat_detect==2)
                  <i class="fa fa-ban"></i> Cheating - Not Clear 
                @else
                  <i class="fa fa-check-circle"></i> No Cheating  
                @endif </small>

            </div>
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>

  </div> 
</div>


  <!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="{{route('e.exam.owner')}}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Test Ownership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="form-group">
        <label for="formGroupExampleInput ">Current Owner</label>
        <div class="h3 text-primary">{{$exam->user->name}}</div>
       
      </div>
        <div class="form-group">
        <label for="formGroupExampleInput "> Select the HR Manager to assign for</label>
        <select class="form-control" name="user_id">
          <option value=""  >-None-</option>
          <option value="{{\auth::user()->id}}"  >{{ \auth::user()->username }}</option>
          @foreach($data['hr-managers'] as $u)

          <option value="{{$u->id}}"  >{{ $u->name }} ({{ $u->client_slug }})</option>
          @endforeach
        </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
        <input type="hidden" name="exam_id" value="{{$exam->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-success">Change</button>
        
      </div>
    </div>
    </form>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="{{route('e.exam.copy')}}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Copy Test</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="form-group">
        <label for="formGroupExampleInput ">Test Name</label>
        <input type="text" class="form-control" name="exam_name" id="formGroupExampleInput" placeholder="Enter the Test Name" 
            value=''
          >
       
      </div>

      <div class="form-group">
        <label for="formGroupExampleInput ">Section Sequence (Optional)</label>
        <input type="text" class="form-control" name="section_sequence" id="formGroupExampleInput" placeholder="give values seperated by commas" 
            value=''
          >
          <p class="bg-light p-3 rounded">
         <small class=" ">The number of sections should match with original & the indexing starts from zero (like array indexing)  for eg: actual sequence - 0,1,2 & new sequence - 2,0,1 . This will make thrid section appear first and second section at the end</small></p>
      </div>

        <div class="form-group">
        <label for="formGroupExampleInput "> Select the HR Manager to assign for</label>
        <select class="form-control" name="user_id">
          <option value="{{\auth::user()->id}}"  >{{ \auth::user()->username }}</option>
          @foreach($data['hr-managers'] as $u)
          @if($u->role==12 || $u->role==13)
          <option value="{{$u->id}}"  >{{ $u->name }} ({{ $u->client_slug }})</option>
          @endif
          @endforeach
        </select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
        <input type="hidden" name="exam_id" value="{{$exam->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-success">Create a copy</button>
        
      </div>
    </div>
    </form>
  </div>
</div>
  <!-- Modal -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Download & Upload - Question Paper</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="alert alert-warning alert-important">Download the <a href="{{ route('test.download',$exam->slug)}}?template=1">word tempate</a> for uploading</div>
       <h4>Download </h4>
       <a href="{{ route('test.download',$exam->slug)}}" class="btn btn-outline-primary">Word Format</a>
       <a href="{{ route('test.download',$exam->slug)}}?html=1" class="btn btn-outline-success">Html Format</a>
       @if(Storage::disk('s3')->exists('docs/'.$exam->slug.'.docx'))
       <a href="{{Storage::disk('s3')->url('docs/'.$exam->slug.'.docx')}}" class="btn btn-outline-secondary">Backup file</a>
       @endif
       <h4 class="my-4">Upload</h4>
       <form method="post" action="{{route('test.upload',$exam->slug)}}" enctype="multipart/form-data">
        <div class="form-group bg-light p-3 rounded">
        <label for="formGroupExampleInput ">File</label>
        <input type="file" class="form-control" name="file_" id="formGroupExampleInput" placeholder="Enter the document path" 
          >
          <div class="form-check form-check-inline mt-2">
  <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="word" checked>
  <label class="form-check-label" for="inlineRadio1">word</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="html">
  <label class="form-check-label" for="inlineRadio2">Html</label>
</div>
<div>
    <button type="submit" class="btn btn-primary mt-3">Upload</button></div>
      </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
           </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         
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
        
        <form method="post" action="{{route('exam.destroy',$exam->id)}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade " id="all_emails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">All Emails({{substr_count($exam->emails, "@")}})</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       {!! implode("<br> ",$email_stack['total']) !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade " id="registered_emails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registered Emails({{ count($email_stack['registered'])}})</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! implode("<br> ",$email_stack['registered']) !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade " id="not_registered_emails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Not Registered Emails({{ count($email_stack['not_registered'])}})</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! implode("<br> ",$email_stack['not_registered']) !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade " id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="" id="">
        <div class="p-3 loading">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>  
        </div> Loading...
        
        </div>
        <div id="user_data">
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection