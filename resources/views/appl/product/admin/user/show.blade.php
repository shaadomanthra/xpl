@extends('layouts.app')
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
          @if(!$user->checkUserRole(['client-owner','client-manager']))
          <a href="{{ route('admin.user.edit',$user->username) }}"><i class="fa fa-edit"></i> edit </a>
          @endif
        </nav>

        <div class="card mb-3">
      <div class="card-body">
        
        <dl class="row">
  <dt class="col-sm-3">Name</dt>
  <dd class="col-sm-9">{{ $user->name}}</dd>

  <dt class="col-sm-3">Username</dt>
  <dd class="col-sm-9">{{ $user->username}}</dd>
  <dt class="col-sm-3">Email</dt>
  <dd class="col-sm-9">
    {{ $user->email }}
  </dd>

@if(!$user->checkUserRole(['client-owner','client-manager']))
  <dt class="col-sm-3">Password</dt>
  <dd class="col-sm-9">{{ $user->activation_token}}</dd>
  @else
  <dt class="col-sm-3">Account Access</dt>
  <dd class="col-sm-9"><span class="badge badge-danger">Administrator</span></dd>
  @endif
  <dt class="col-sm-3">Created </dt>
  <dd class="col-sm-9">{{ $user->created_at->diffforHumans()}}</dd>
  <dt class="col-sm-3">Status</dt>
  <dd class="col-sm-9">
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



@if(!$user->checkRole(['administrator','manager','investor','patron','promoter','employee','client-owner','client-manager']))
       <div class="card mb-3">
        <div class="card-header">
          <h2>Courses 
          @if($client->getCreditsUsedCount()<($client->getCreditPoints()-1))
          <a href="{{ route('admin.user.course',$user->username) }}" class="btn btn-outline-primary float-right">
            @else
            <a href="#" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Credits" >
            @endif
            <span class="">Add Course</span>
          </a>
        </h2></div>
      <div class="card-body">
        @if($user->courses()->count())
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Course</th>
      <th scope="col">Credits</th>
      <th scope="col">Valid till</th>
      <th scope="col">Created</th>
    </tr>
  </thead>
  <tbody>
    @foreach($user->courses()->orderBy('pivot_created_at','desc')->get() as $k=>$c)
    <tr>
      <th scope="row">{{$k+1}}</th>
      <td>{{ $c->name }}</td>
      <td>{{ $c->pivot->credits}}</td>
      <td>{{ date('d M Y', strtotime($c->pivot->valid_till)) }}</td>
      <td>{{ $c->pivot->created_at->diffForHumans()}}</td>
    </tr>
    @endforeach
    
  </tbody>
</table>
@else
No Courses Added
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Buy Credits</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        All your credit points are used. Kindly buy credits to continue the service. 
        </div>
      <div class="modal-footer">
        
        
        <a href="{{ route('order.buy')}}">
          <button type="button" class="btn btn-primary">Buy</button></a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

@endsection

