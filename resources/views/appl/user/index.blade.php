@extends('layouts.app')
@section('title', $user->name.' ')
@section('content')

<div  class="row ">
  <div class="col">
    @include('flash::message')  

    <div class="card mb-3">
      <div style="height:150px;background: linear-gradient(70deg,#F44336, #3f51b5);"></div>
      <div class="card-body " style="margin-top: -110px;">
        <div class="row">
          <div class="col-md-4">
              <div class="text-center" style="height:180px">
                <img class="img-thumbnail rounded-circle mb-3"src="@if($user->image) {{ ($user->image)}}@else {{ Gravatar::src($user->email, 150) }}@endif" style="width:180px;height:180px">
              </div>
          </div>
          <div class="col-md-8">
            <div class="mt-3 mt-md-5 ">
             <h2 class="mb-md-4 name" >{{ $user->name }} 

              @if($user->personality)
            <span class="badge badge-light float-right">
              @if($user->personality>=8)
        Grade A
      @elseif($user->personality>=5 && $user->personality<8)
        Grade B
      @else
        Grade C  
      @endif</span>
          @endif

              
             </h2>
             @if($user_details)
               @if($user_details->designation)
               <div class="mt-2">
               <h4 class="text-secondary ">{{ $user_details->designation }}</h4>
             </div>
               @endif
             @endif  
              <div>
              @can('update',$user)
              <a href="{{route('profile.edit','@'.$user->username)}}"><i class="fa fa-edit"></i></a>
              @endcan
              @can('manage',$user)
              <a href="{{route('profile.manage','@'.$user->username)}}"><i class="fa fa-gear"></i></a>
              @endcan
              </div>
              

             @if($user_details)
             <p>{!! $user_details->bio !!}</p>
             @endif

              @if($user->colleges()->first())
             <p>@if($user->colleges()->first()) <b>{{ $user->colleges()->first()->name }}</b> @endif - 
             @if($user->branches()->first()) {{  $user->branches()->first()->name  }} @endif </p>
             @endif

             @if($user->year_of_passing)
             <div> Year of Passing - {{$user->year_of_passing}}</div>
             @endif

             @if($user->gender)
             <div> Gender - {{$user->gender}}</div>
             @endif

             @if($user->dob)
             <div> Date of Birth - {{$user->dob}}</div>
             @endif

             @if($user->current_city)
             <div> Current City - {{$user->current_city}}</div>
             @endif
             @if($user->hometown)
             <div> Hometown - {{$user->hometown}}</div>
             @endif

            </div>

          </div>
        </div>
        
      
     </div>
   </div>


   @if(\Auth::user())
@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))

<div class="row mb-3">

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #f9e2df;border-left:5px solid #ed443c;background: #fdf5f4">
      <h3 class="display-5">Grade</h3>
      <h5 class="heading_one" style="color:#ed443c;opacity: 0.7">@if($user->personality>=8)
        A
      @elseif($user->personality>=5 && $user->personality<8)
        B
      @else
        C  
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
@endif

@auth
<div class="row">
<div class="col-12 col-md-7">
   <div class="">
    <div class=" mb-4">
      <div class="row">
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
    </div>
   </div>
</div>

<div class="col-12 col-md-5">

<div class="card mb-4">
    <div class=" bg-white">
      <div class="row">
        <div class="col-12 ">
          <h3 class=" p-3 mb-0"><i class='fa fa-youtube-play'></i> Profile Video</h3>
         
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
<a href="{{ route('video.upload') }}" class="btn btn-primary">Add Profile Video</a>
@endif


      </div>
    </div>
   </div>
</div>
@endauth


 </div>
</div>



@endsection


