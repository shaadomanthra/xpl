@extends('layouts.app')
@section('title', $user->name.' - User ')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">User Accounts</a></li>
    <li class="breadcrumb-item">{{$user->name}}</li>
  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-9">
 
    <div class="">
      <div class="mb-0">
        
        <nav class="navbar navbar-light bg-light justify-content-between border rounded p-3 mb-3">
          <a class="navbar-brand"><i class="fa fa-user"></i> {{ $user->name}}</a> 
          @if(!$user->checkUserRole(['administrator','manager']))
          <a href="{{ route('admin.user.edit',$user->username) }}"><i class="fa fa-edit"></i> edit </a>
          @endif
          
        </nav>

        <div class="card mb-3">
      <div class="card-body">
        
        <div class="row">
          <div class="col-12 col-md-4">
          @if($user->image)
          <img src="{{ $user->image }}" class="w-100 p-3 pt-0"/>  
          @else
          <img src="{{ asset('/img/user.png')}}" class="w-100 p-3 pt-0"/>    
          @endif
          </div>
          <div class="col-12 col-md-8">
                    <dl class="row">
          <dt class="col-sm-5">id</dt>
  <dd class="col-sm-7">{{ $user->id}}</dd>
  <dt class="col-sm-5">Name</dt>
  <dd class="col-sm-7">{{ $user->name}}</dd>
  

  <dt class="col-sm-5">Username</dt>
  <dd class="col-sm-7">
    <a href="{{ route('profile','@'.$user->username)}}">{{ $user->username}}
    </a>
  </dd>
  <dt class="col-sm-5">Email</dt>
  <dd class="col-sm-7">
    {{ $user->email }}
  </dd>


  <dt class="col-sm-5">Phone</dt>
  <dd class="col-sm-7">
    {{ $user->phone }}
  </dd>
  <dt class="col-sm-5">Client</dt>
  <dd class="col-sm-7">
    @if($user->client_slug)
    {{ $user->client_slug}}
    @else
    Xplore
    @endif
  </dd>

 

 

  @if($user->roles()->first())        
  <dt class="col-sm-5">Role</dt>

  <dd class="col-sm-7">
    @foreach($user->roles()->get() as $k=> $r)
    <span class="badge badge-warning">{{ $r->name }}</span>
    @if($r->slug=='hr-manager')
    <span class="badge badge-info">
      @if($user->role==10)
        Basic
      @elseif($user->role==11)
        Pro
      @elseif($user->role==12)
        Advanced
      @endif 
    </span>
    @endif
    <br>
    @endforeach
  </dd>
  @endif

  

  

@if(!$user->checkUserRole(['client-owner','client-manager','administrator','manager']))
  <dt class="col-sm-5">Password/Activation</dt>
  <dd class="col-sm-7">{{ $user->activation_token}}</dd>
  @else
  <dt class="col-sm-5">Account Access</dt>
  <dd class="col-sm-7"><span class="badge badge-danger">Administrator</span></dd>
  @endif
  <dt class="col-sm-5">Created </dt>
  <dd class="col-sm-7">{{ $user->created_at->diffforHumans()}}</dd>
  <dt class="col-sm-5">Status</dt>
  <dd class="col-sm-7">
     @if($user->status==0)
                    <span class="badge badge-secondary">Inactive</span>
                  @elseif($user->status==1)
                    <span class="badge badge-success">Active</span>
                    @elseif($user->status==2)
                    <span class="badge badge-warning">Blocked</span>
                  @endif
  </dd>
  
</dl>
            
          </div>
        </div>


         
  
        </div>
      </div>
     <!-- && ( || $user->client_slug=='') -->
@if($user->video && $user->client_slug=='xplore')
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

            <div class="card mb-3">
      <div class="card-body">

        <div class="row">
          <div class="col-12 col-md-2">
          <img src="{{ asset('/img/solar-system.png')}}" class="w-100 p-3 pt-0"/>    
          </div>

          <div class="col-12 col-md-9">
            <dl class="row">
              <dt class="col-sm-5">Gender (or Father Phone)</dt>
              <dd class="col-sm-7">
                @if($user->gender)
                {{ $user->gender}}
                @else -
                @endif
              </dd>
              
              <dt class="col-sm-5">Date of Birth</dt>
              <dd class="col-sm-7">
                @if($user->dob)
                {{ $user->dob}}
                @else -
                @endif
              </dd>
              

              <dt class="col-sm-5">Current City (or Address)</dt>
              <dd class="col-sm-7">
                @if($user->current_city)
                {{ $user->current_city}}
                @else -
                @endif
              </dd>
 

             
              <dt class="col-sm-5">Hometown (or District)</dt>
              <dd class="col-sm-7">
                 @if($user->hometown)
                 {{ $user->hometown}}
                 @else
                 -
                 @endif
               </dd>
              

              @if($user->zones()->first())        
              <dt class="col-sm-5">Zone</dt>
              <dd class="col-sm-7"><a href="{{ route('zone.view',$user->zones()->first()->name) }}">{{ $user->zones()->first()->name}}</a></dd>
              @endif
            </dl>
          </div>
        </div>
        
        
         
  
        </div>
      </div>


          <div class="card mb-3">
      <div class="card-body">

        <div class="row">
          <div class="col-12 col-md-2">
          <img src="{{ asset('/img/education.png')}}" class="w-100 p-3 pt-0"/>    
          </div>

          <div class="col-12 col-md-9">
            <dl class="row">     
  <dt class="col-sm-3">Personality</dt>
  <dd class="col-sm-9 h3">@if($user->personality) {{ $user->personality}} @else - @endif</dd>

  <dt class="col-sm-3">Language</dt>
  <dd class="col-sm-9">@if($user->language) {{ $user->language}} @else - @endif</dd>
  
 <dt class="col-sm-3">Fluency</dt>
  <dd class="col-sm-9">@if($user->fluency) {{ $user->fluency}} @else - @endif</dd>
  
   <dt class="col-sm-3">Confidence</dt>
  <dd class="col-sm-9">@if($user->confidence) {{ $user->confidence}} @else - @endif</dd>
  
  

  
</dl>


          </div>

        </div>
        
        
         
  
        </div>
      </div>


              <div class="card mb-3">
      <div class="card-body">

        <div class="row">
          <div class="col-12 col-md-2">
          <img src="{{ asset('/img/college.png')}}" class="w-100 p-3 pt-0"/>    
          </div>

          <div class="col-12 col-md-9">
            <dl class="row">
  @if($user->college)        
  <dt class="col-sm-6">College Name</dt>
  @if($user->college->id!=5 && $user->college->id!=295)
  <dd class="col-sm-6"><a href="{{ route('college.view',$user->college->id ) }}">{{ $user->college->name}}</a></dd>
  @else
  <dd class="col-sm-6">{{$user->info}}</dd>
  @endif
  @endif

  @if($user->branch)
  <dt class="col-sm-6">Branch</dt>
  <dd class="col-sm-6">
    <a href="{{ route('branch.view',$user->branch->name ) }}">{{ $user->branch->name}}</a> &nbsp;
  </dd>
  @endif

  <dt class="col-sm-6">Roll Number (or Fathers Name)</dt>
  <dd class="col-sm-6">
    {{ $user->roll_number }}
  </dd>

  <dt class="col-sm-6">Year of Passing</dt>
  <dd class="col-sm-6">
    {{ ($user->year_of_passing)?$user->year_of_passing:'-' }}
  </dd>

  
</dl>


          </div>

        </div>
        
        
         
  
        </div>
      </div>


      <div class="card mb-3">
      <div class="card-body">

        <div class="row">
          <div class="col-12 col-md-2">
          <img src="{{ asset('/img/metrics.png')}}" class="w-100 p-3 pt-0"/>    
          </div>

          <div class="col-12 col-md-9">
            

        <dl class="row">
          @if($user->metrics())
          <dt class="col-sm-3">Metrics</dt>
          <dd class="col-sm-9">
          @foreach($user->metrics()->get() as $metric)
            <a href="{{ route('metric.view',$metric->name ) }}">{{ $metric->name}}</a> <br>
          @endforeach
          </dd>
          @else
           -
          @endif
        </dl>

          </div>
        </div>
        
        
        </div>
      </div>

      


@if($user->checkRole(['administrator','manager','investor','patron','promoter','employee','client-owner','client-manager']))
       <div class="card mb-3">
        <div class="card-header">
          <h2>Products
          <a href="{{ route('admin.user.product',$user->username) }}" class="btn btn-outline-primary float-right">
            
            <span class="">Add Product</span>
          </a>
        </h2></div>
      <div class="card-body">
        @if($user->products()->count())
        <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product</th>
      <th scope="col">Status</th>
      <th scope="col">Validity</th>
      <th scope="col">Valid till</th>
      <th scope="col">Created</th>
    </tr>
  </thead>
  <tbody>
    @foreach($user->products()->orderBy('pivot_created_at','desc')->get() as $k=>$c)
    <tr>
      <th scope="row">{{$k+1}}</th>
      <td>{{ $c->name }} <a href="{{ route('admin.user.product.update',[$user->id,$c->id])}}"><i class="fa fa-edit"></i></a></td>
      <td>
        @if(strtotime($c->pivot->valid_till) > strtotime(date('Y-m-d')))
          @if($c->pivot->status==1)
          <span class="badge badge-success">Active</span>
          @else
          <span class="badge badge-secondary">Disabled</span>
          @endif
        @else
            <span class="badge badge-danger">Expired</span>
        @endif
      </td>
      <td>{{ $c->pivot->validity}} months</td>
      <td>{{ date('d M Y', strtotime($c->pivot->valid_till)) }}</td>
      <td>{{ $c->pivot->created_at->diffForHumans()}}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>
@else
No Products Added
@endif

        </div>
      </div>

   @endif    
        

     </div>
   </div>
 </div>
  <div class="col-md-3 pl-md-0">
      @include('appl.product.snippets.adminmenu')
    </div>
</div>


@endsection

