@extends('layouts.nowrap-product')
@section('title', 'Dashboard ')
@section('description', 'Know you tests')
@section('keywords', 'quantitative aptitude, mental ability, learning, simple, interresting, logical reasoning, general english, interview skills')
@section('content')


<div class="container mt-4">
  @include('flash::message')  
@if(auth::user())
     @if($user->status!=0)
<div class="rounded p-4 mb-4" style="background: #caf7dd; border:1px solid #39c072;">
  <a href="{{ route('activation')}}">
<button class="btn btn-success float-right mt-md-2">Validate Now</button>
</a>
  <h4 class="">Validate your account</h4>
<p class="mb-0">Your account has not been validated yet. You are only a few steps away from complete access to our platform.</p>

</div>
@endif
    @endif

<div class="row">
  <div class="col-12 col-md-9 ">

    
<div class="p-0 mb-4" style="border:1px solid #eee;box-shadow: 2px 2px 2px 1px #e7e7e7">
  <div class="p-2 bg-light"> </div>
<div class="  p-3 pt-5 bg-white" >


  <div class="row ">
    <div class="col-md-9 ">
      @if(auth::user())
      <div class="row mt-0 mt-mb-4">
        <div class="col-12 col-md-3">


          <img class="img-thumbnail rounded-circle mb-3" src="@if(\auth::user()->image) {{ (\auth::user()->image)}}@else {{ Gravatar::src(\auth::user()->email, 150) }}@endif">
        </div>
        <div class="col-12 col-md-9">

          <h2>Hi, {{  \auth::user()->name}} 
            @if(auth::user()->profile_complete()==100)<i class="fa fa-check-circle text-success"  data-toggle="tooltip" title="Profile Completed"></i>@endif
            @if(auth::user()->video)<i class="fa fa-vcard-o text-secondary"  data-toggle="tooltip" title="Profile Video"></i>@endif</h2>
      <p> Welcome aboard</p>

      <p class="lead">
        <dl class="row">
  @if($user->college_id)        
  <dt class="col-sm-5">College </dt>
  @if($user->college->id!=5 && $user->college->id!=295)
  <dd class="col-sm-7">{{ $user->college->name}}</dd>
  @else
  <dd class="col-sm-7">{{$user->info}}</dd>
  @endif
  @endif
  @if($user->branch_id)
  <dt class="col-sm-5">Branch</dt>
  <dd class="col-sm-7">{{ $user->branch->name}} &nbsp;
  </dd>
  @endif

  @if($user->year_of_passing)
  <dt class="col-sm-5">Year of Passing</dt>
  <dd class="col-sm-7">
    {{ ($user->year_of_passing)?$user->year_of_passing:'-' }}
  </dd>
  @endif
</dl>
      </p>



    @if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xp.test')
    <a href="{{ route('profile','@'.\auth::user()->username)}}" class="btn btn-primary">Profile</a>
    @endif
      <a class="btn border border-success text-success " href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" role="button">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>


            <br><br>

        
            

        </div>


      </div>


            
             
      
      @else

      @endif

    </div>
    
    <div class="col-12 col-md-3  ">
      <div class="float-right ">
                <img src="{{ asset('/img/student_front.png')}}" class="w-100 p-3 pt-0"/>
                
      </div>
    </div>
  </div>
</div>
</div>



@if(isset(request()->session()->get('client')->slug))
@if(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_banner.png'))
              <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_banner.png')}}" class=" w-100 mb-3" />
              @elseif(Storage::disk('s3')->exists('companies/'.request()->session()->get('client')->slug.'_banner.jpg'))
              <img src="{{ Storage::disk('s3')->url('companies/'.request()->session()->get('client')->slug.'_banner.jpg')}}" class=" w-100 mb-3" />
             
              @endif
@endif



@if(count(\auth::user()->newtests())!=0)
  <div class="row ">
            
                @foreach(\auth::user()->newtests() as $k=>$e)
                @if(!\auth::user()->attempted($e->id))
                    @include('snippets.test')  
                @endif
                @endforeach
            </div>


@endif

<div class="rounded p-4 mb-4 " style="background: #dfecff; border:1px solid #98c3ff;">
  
  <h1>View my tests & products</h1>


<a href="{{ route('dashboard')}}?mytests=1">
<button class="btn btn-primary  mt-md-2">View Now</button>
</a>

</div>


  </div>

<div class="col-12 col-md-3">
  <a href="https://t.me/xplorejobs" target="_blank"><img src="{{ asset('img/graphics/telegram.jpg')}}" class="w-100 rounded mb-3" style="box-shadow: 3px 3px 3px 3px #eee;"/></a>

    <a href="https://packetprep.com/apply?utm_source=xplore&utm_medium=referral&utm_term=imagefeed" target="_blank"><img src="{{ asset('img/pp2.png')}}" class="w-100 rounded" style="box-shadow: 3px 3px 3px 3px #eee;"/></a>

@if(auth::user()->profile_complete()!=100)
  <div class="bg-white  p-4 p-md-4 mb-md-4 mt-4" style="background-image:url({{asset('img/graphics/corner-4.png')}});background-position: right;background-repeat: no-repeat; border-radius:8px;box-shadow: 3px 3px 3px 3px #eee;background-size: auto;">
  <div class="heading mb-4">
    <h3 class="jost  text-blue" >Profile Incomplete </h3>
    <div class="progress">
  <div class="progress-bar" role="progressbar" style="width: {{auth::user()->profile_complete()}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{auth::user()->profile_complete()}}%</div>
</div>
  </div>
  <p>Fill all the details to make your profile <i class="fa fa-check-circle text-success"></i> active. </p>
  <p class="mb-0 text-blue">
    <a href="{{route('profile.edit','@'.$user->username)}}?complete_profile=1"><b><i class="fa fa-angle-right"></i> edit profile</b></a></p>
    
</div>
@endif


@if(!auth::user()->video)
  <div class="bg-white  p-4 p-md-4 mb-md-4 mt-4" style="background-image:url({{asset('img/graphics/corner-3.png')}});background-position: right;background-repeat: no-repeat; border-radius:8px;box-shadow: 3px 3px 3px 3px #eee;background-size: auto;">
  <div class="heading mb-4">
    <h3 class="jost  text-blue" >Add Profile Video </h3>
    
  </div>
  <p>A great profile video <i class="fa fa-vcard-o text-secondary"></i> can enhance your visibility to the HR's. </p>
  <p class="mb-0 text-blue">
    <a href="{{route('video.upload')}}"><b><i class="fa fa-angle-right"></i> add video</b></a></p>
    
</div>
@endif
</div>


  
</div>

</div>
@endsection           