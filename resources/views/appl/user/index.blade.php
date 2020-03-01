@extends('layouts.app')
@section('content')

<div  class="row ">
  <div class="col">
    @include('flash::message')  

    <div class="card mb-3">
      <div style="height:120px;background: linear-gradient(70deg,#F44336, #3f51b5);"></div>
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

              @if($user_details)
              @if($user_details->facebook_link)
                <a href="{{$user_details->facebook_link}}" class="link"><i class="fa fa-facebook-square"></i> </a>
                @endif

                @if($user_details->twitter_link)
                <a href="{{$user_details->twitter_link}}" class="link"><i class="fa fa-twitter-square"></i> </a>
                @endif
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

@auth
<div class="row">
<div class="col-12 col-md-8">
   <div class="card mb-3">
    <div class="card-body bg-light">
      <div class="row">
        <div class="col-12 col-md-4"><h1 class="mb-0"> Academics</h1></div>
        <div class="col-12 col-md-8 mt-2">
          
          <div class="table-responsive">
            <table class="table table-bordered">
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

<div class="col-12 col-md-4">

<div class="card">
    <div class="card-body bg-white">
      <div class="row">
        <div class="col-12 col-md-4"><h1 class="mb-0"> Skills</h1></div>
        <div class="col-12 col-md-8 mt-2">
          @foreach($user->metrics as $m)

            <span class="badge badge-success">{{$m->name}}</span><br>
          @endforeach
         
        </div>
      </div>
    </div>
   </div>
 </div>
</div>
@endauth

@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
@if($user->video)
      <div class="card mb-3">
      <div class="card-body">
@if(!is_numeric($user->video))
<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $user->video}}?rel=0" allowfullscreen></iframe>
</div>
@else
<div class="embed-responsive embed-responsive-16by9">
  <iframe src="//player.vimeo.com/video/{{ $user->video }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>
@endif
      </div>
    </div>
@endif
@endif

 </div>
</div>

@endsection


