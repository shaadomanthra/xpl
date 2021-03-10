@extends('layouts.nowrap-white')

@section('title', 'Dashboard ')

@section('description', 'Know you tests')

@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')

@section('content')

@include('appl.exam.exam.xp_css')


<div class="dblue" >
  <div class="container">

    <div class="row">
      <div class="col-12 col-md">
        
        <div class=' pb-1'>
          <p class="heading_two mb-1 f30 mt-3" >
            <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-2">
            <img class="img-thumbnail rounded-circle mb-3 mt-2" src="@if(\auth::user()->image) {{ (\auth::user()->image)}} @else {{ Gravatar::src(\auth::user()->email, 150) }}@endif" style="width:120px">
          </div>
          <div class="col-12 col-md-10">
            <p class='mt-3'>
           <h2>Hi, {{  \auth::user()->name}}
            <span class="badge badge-info" data-toggle="tooltip" title="Account Type">
      @if(\auth::user()->role==10)
        Basic 
      @elseif(\auth::user()->role==11)
        Pro 
      @elseif(\auth::user()->role==12)
        Advanced 
      @elseif(\auth::user()->role==13)
        Admin
      @endif 
    </span>
           </h2>
      <p> Welcome aboard</p>

      @if(subdomain() == 'rguktn' || subdomain() == 'rguktrkv' )
    <a href="{{ route('password.change')}}" class="btn btn-primary">Change Password</a>
    @endif
      <a class="btn btn-warning " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </p>
          </div>
        </div>
          </p>
        </div>
      </div>
      @if( $_SERVER['HTTP_HOST'] != 'xplore.co.in')
      @if(\auth::user()->role == 12 || \auth::user()->role == 13 || \auth::user()->isAdmin())
      <div class="col-12 col-md-2">
        <div class="row mt-4">
          <div class="col-12 ">
            <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Total Users</div>
          <div class="h2" ><a href="{{ route('user.list')}}" data-toggle="tooltip" title="View Users"><!-- $user->where('client_slug',subdomain())->count() --> 0</a></div>
        </div>
          </div>
        </div>
      </div>
      @endif
      @endif

      @if(\auth::user()->role == 12 || \auth::user()->role == 13 || \auth::user()->isAdmin())
      <div class="col-12 col-md-2">
        <div class="row mt-4">
         
          <div class="col-12 ">
            <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Total Attempts</div>
          <div class="h2" ><a href="{{ route('attempts')}}" data-toggle="tooltip" title="View Participants">{{$user->attempts}}</a></div>
        </div>
          </div>
          
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
<div class='p-2 pt-3 ddblue' >
<div class="container">
    <div class="row">
      <div class="col-12 col-md-8">
        
        <div class=' pb-1'>
          <p class="heading_two mb-2 f30 text-white" ><i class="fa fa-inbox "></i> My Tests

            @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
            @if(\auth::user()->role == 10 || \auth::user()->role == 12 || \auth::user()->role == 13 ||  \auth::user()->isAdmin())
            <a href="{{route('examtype.index')}}">
              <button type="button" class="btn btn-outline-light my-2 my-sm-2 mr-sm-3">Testtypes</button>
            </a>
            <a href="{{route('exam.create')}}">
              <button type="button" class="btn btn-success float-right my-2 my-sm-2 ">Create Test</button>
            </a>
            @endif
            @endif

          </p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="mt-2">
         

         <form class="w-100" method="GET" action="{{ route('exam.index') }}">
            
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </div>
      </div>
    </div>
</div>
</div>

<div class="container mt-4">
  <div id="search-items">
  @include('snippets.hr_tests')
  </div>
</div>

@if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com' || $_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in')
@if($e)
<div class="dyellow" style="background:#f7f6cf">
  <div class="container">
    <div class="p-3 py-4 pb-5">
       <div class="row">
            <div class='col-2 col-md-1'>
              @if(isset($e->image))
                @if(Storage::disk('s3')->exists($e->image))
                <div class=" text-center">
                  <picture class="">
                    <img 
                    src="{{ Storage::disk('s3')->url($e->image) }} " class="d-print-none w-100 mt-2" alt="{{  $e->name }}" style='max-width:80px;'>
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
              <h2 class="mb-1 mt-2 lh15">
                <a href=" {{ url('/exam/psyreport') }} " data-toggle="tooltip" title="View Test Reports">
                @if($e->status==0)
                <i class="fa fa-square-o"></i> 
                @elseif($e->status==1)
                  <i class="fa fa-globe"></i> 
                @else
                  <i class="fa fa-lock"></i> 
                @endif  
                  {{ $e->name }}
                </a>

              </h2>
              <div>
                <a href="{{route('assessment.show',$e->slug)}}" class=""><i class="fa fa-external-link" ></i> {{ route('assessment.show',$e->slug) }}</a>
                  @if($e->active==1)
                <span class=" badge badge-secondary">Inactive</span>
                @else
                  <span class=" badge badge-success">Active</span>
                @endif
                <br>

                <div class="text-muted mt-1">This test is included for free in all packages</div>
              </div>
              
            </div>

            

          </div>
    </div>
  </div>
  </div>
@endif
@endif
  
</div>

</div>
@endsection           