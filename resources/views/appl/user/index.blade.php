@extends('layouts.nowrap')
@section('content')

<div  class="row ">
  <div class="col">
    @include('flash::message')  

    <div class="card mb-3">
      <div style="height:120px;background: linear-gradient(70deg,#2f82ca, #019875);"></div>
      <div class="card-body " style="margin-top: -110px;">
        <div class="row">
          <div class="col-md-4">
              <div class="text-center" style="height:180px">
                <img class="img-thumbnail rounded-circle mb-3"src="{{ Gravatar::src($user->email, 150) }}">
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
            </div>

          </div>
        </div>
        
      
     </div>
   </div>

   <div class="card">
    <div class="card-body bg-light">
      <div class="row">
        <div class="col-6"><h1 class="mb-0"> Position</h1></div>
        <div class="col-6 mt-2">
          @if(count($user->roles))
            @foreach($user->roles as $roles)
              {{ $roles->name }} <br>
            @endforeach
          @else
            - Not Assigned -
          @endif
        </div>
      </div>
    </div>
   </div>

 </div>
</div>

@endsection


