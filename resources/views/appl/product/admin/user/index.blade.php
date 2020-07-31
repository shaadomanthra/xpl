@extends('layouts.app')
@section('title', 'Userlist')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
    <li class="breadcrumb-item">User Accounts</li>

  </ol>
</nav>
@include('flash::message')
<div  class="row ">

  <div class="col-md-12">
 
    <div class="card mb-3 mb-md-0">
      <div class="card-body mb-0">
        <nav class="navbar navbar-light bg-light justify-content-between border mb-3">
          <a class="navbar-brand"><i class="fa fa-user"></i> Users ({{count($users)}}) @if(request()->get('month')) <span class="badge badge-warning">{{request()->get('month')}}</span>@endif 
             @if(request()->get('recent')) <span class="badge badge-info">Recent Logins</span>@endif
          </a>
          <form class="form-inline" method="GET" >
            <a href="{{route('admin.user.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 mr-sm-3">Add User</button>
            </a>
            <a href="{{route('admin.user')}}?recent=true">
              <button type="button" class="btn btn-outline-secondary my-2 my-sm-2 mr-sm-3">Recent</button>
            </a>
            <div class="input-group ">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
              </div>
              <input class="form-control " id="search" name="item" autocomplete="off" type="search" placeholder="Search" aria-label="Search" 
              value="{{Request::get('item')?Request::get('item'):'' }}">
            </div>
            
          </form>
        </nav>

       

        <div id="search-items">
         @include('appl.product.admin.user.list')
       </div>

     </div>
   </div>
 </div>
  
</div>

@endsection


