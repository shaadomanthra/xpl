@extends('layouts.nowrap-white')
@section('title', $user->name.' ')
@section('content')

<div  class="row ">
  <div class="col">
    @include('flash::message')  

    <div class=" mb-3">
      <div style="height:150px;background: linear-gradient(70deg,#F44336, #3f51b5);"></div>
      <div class=" " style="margin-top: -90px;">
        <div class="row">
          <div class="col-md-4">
              <div class="text-center" style="height:180px">
                <img class="img-thumbnail rounded-circle mb-3"src="@if($user->image) {{ ($user->image)}}@else {{ Gravatar::src($user->email, 150) }}@endif" style="width:180px;height:180px">
              </div>
          </div>
          <div class="col-md-8">
            <div class="mt-3 mt-md-5 ">
             <h2 class="mb-md-4 name mr-4 ml-4" >{{ $user->name }} 


              
             </h2>
             @if($user_details)
               @if($user_details->designation)
               <div class="mt-5 mr-4 ml-4">
               <h4 class="text-secondary ">{{ $user_details->designation }}</h4>
             </div>
               @endif
             @endif  
              <div>
              
              </div>
              
            <div class="mr-4 ml-4">
             @if($user_details)
             <p class='mr-3'>{!! $user_details->bio !!}</p>
             @endif

              
             <p class="pt-1"></p>


             @if($user->colleges()->first())
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-building'></i> &nbsp; College</dt>
                <dd class="col-sm-9">@if($user->colleges()->first()){{ $user->colleges()->first()->name }}@endif</dd>
              </dl>
             @endif

             @if($user->branches()->first())
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-bookmark-o'></i> &nbsp; Branch</dt>
                <dd class="col-sm-9">@if($user->branches()->first()) {{  $user->branches()->first()->name  }} @endif</dd>
              </dl>
             @endif

             @if($user->year_of_passing)
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-tint'></i> &nbsp; Year of Passing</dt>
                <dd class="col-sm-9">{{$user->year_of_passing}}</dd>
              </dl>
             @endif

             @if($user->gender)
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-venus'></i> &nbsp; Gender</dt>
                <dd class="col-sm-9">{{$user->gender}}</dd>
              </dl>
             @endif

             @if($user->dob)
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-calendar'></i> &nbsp; Date of Birth</dt>
                <dd class="col-sm-9">{{$user->dob}}</dd>
              </dl>
             @endif

             @if($user->current_city)
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-address-card-o'></i> &nbsp; Current City</dt>
                <dd class="col-sm-9">{{$user->current_city}}</dd>
              </dl>
             @endif

             @if($user->hometown)
             <dl class="row mb-0">
                <dt class="col-sm-3"><i class='fa fa-home'></i> &nbsp; Hometown</dt>
                <dd class="col-sm-9">{{$user->hometown}}</dd>
              </dl>
             @endif
             
             @can('update',$user)
              <a href="{{route('profile.edit','@'.$user->username)}}" class="btn btn-success mt-3 mb-4"><i class="fa fa-edit"></i> Edit</a>
              @endcan
              @can('manage',$user)
              <a href="{{route('profile.manage','@'.$user->username)}}" class="btn btn-primary mt-3 mb-4"><i class="fa fa-gear"></i> Manage</a>
              @endcan

            </div>

                 @if(\Auth::user())
@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))

@if($user->personality)
<div class="row mb-3 mr-2 ml-2 mt-4">

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #f9e2df;border-left:5px solid #ed443c;background: #fdf5f4">
      <h3 class="display-5">Grade</h3>
      <h5 class="heading_one" style="color:#ed443c;opacity: 0.7">@if($user->personality>=8)
        A
      @elseif($user->personality>=5 && $user->personality<8)
        B
      @elseif($user->personality>=2 && $user->personality<5)
        C 
      @else
        -

      @endif</h5>
    </div>
  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #f5e2e5;border-left:5px solid #bf4a60;background: #ffedf0">
      <h3 class="display-5">Language</h3>
      <h5 class="heading_one" style="color:#bf4a60;opacity: 0.7">@if($user->language)
            {{$user->language}}
          @else
            -
          @endif</h5>
    </div>
    
  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #eee1f5;border-left:5px solid #7e4f8d;background:  #fbf3ff;">
      <h3 class="display-5">Confidence</h3>
      <h5 class="heading_one" style="color:#7e4f8d;opacity: 0.7">@if($user->confidence)
            {{$user->confidence}}
          @else
            -
          @endif</h5>
    </div>

  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="background: #f5f3ff;border:1px solid #e6e2ff;border-left:5px solid #5950a4;">
      <h3 class="display-5">Fluency</h3>
      <h5 class="heading_one" style="color:#5950a4;opacity: 0.7"> @if($user->fluency)
            {{$user->fluency}}
          @else
            -
          @endif</h5>
    </div>
    
  </div>


</div>
@endif

@include('appl.user.psychometric_report')

@endif
@endif

@auth
      <div class="row mr-2 mb-4 ml-2">
        <div class="col-12 ">
          <h3 class="bg-light p-3 mb-0"><i class='fa fa-youtube-play'></i> Profile Video</h3>
         
          @if($user->video)
@if(!is_numeric($user->video))
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $user->video}}?rel=0" allowfullscreen></iframe>
</div>
@else
<div class="embed-responsive embed-responsive-16by9">
  <iframe src="//player.vimeo.com/video/{{ $user->video }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>
@endif

@else
<div class='p-3 bg-light mt-3'>
<a href="{{ route('video.upload') }}" class="btn btn-primary">Add Profile Video</a>
</div>
@endif


      </div>
    </div>

      <div class="row mr-2 ml-2">
        <div class="col-12 ">
          <h3 class=" p-3 mb-0 bg-white border border-bottom-0"><i class='fa fa-university'></i> Academic Scores</h3>
         
          <div class="table-responsive">
            <table class="table table-bordered bg-light">
  <thead>
    <tr class="">
      <th scope="col">Board</th>
      <th scope="col">CGPA / Percentage </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Class 10</td>
      <td>
        @if($user->tenth)
        {{$user->tenth}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Class 12</td>
      <td>
        @if($user->twelveth)
        {{$user->twelveth}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Graduation</td>
      <td>
        @if($user->bachelors)
        {{$user->bachelors}}
        @else
          - 
        @endif
      </td>
    </tr>
    <tr>
      <td>Masters</td>
      <td>
        @if($user->masters)
        {{$user->masters}}
        @else
          - 
        @endif
      </td>
    </tr>

  </tbody>
</table>
          </div>
        </div>
      </div>
@endauth

            </div>

          </div>
        </div>
        
      
     </div>
   </div>








@endsection


