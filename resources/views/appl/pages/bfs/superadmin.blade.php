@extends('layouts.nowrap-white')
@section('title', 'Admin Dashboard ')
@section('description', 'Know you tests')
@section('keywords', '')
@section('content')

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
      Administrator
    </span>
           </h2>
      <p> Welcome aboard</p>
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
      <div class="col-12 col-md-2">
        <div class="row mt-4">
          <div class="col-12 ">
            <div class=" p-3 mt-md-2 mb-3 mb-md-0 text-center cardbox bg-white" style=''>
          <div class="h6">Total Users</div>
          <div class="h2" ><a href="{{ route('user.list')}}" data-toggle="tooltip" title="View Users">{{$user->where('client_slug',subdomain())->count()}}</a></div>
        </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<div class='p-1 pt-1 ddblue' ></div>
<div class="container my-4 ">
  <div class="row">
    <div class="col-4">
      <div class="bg-primary text-light  rounded p-4 mb-4">
                <h3><i class="fa fa-user"></i> Users <Span class="float-right">{{$user->where('client_slug',subdomain())->count()}}</Span></h3>
                <hr>
                @foreach($user->where('client_slug',subdomain())->orderBy('id','desc')->get() as $k=>$user)
                <div class="mb-2"><a href="{{ route('profile','@'.$user->username) }}" class="text-white">{{$user->name}}</a>
                    <span class="float-right text-blue" style="color:#419cff">{{ $user->created_at->diffForHumans()}}</span></div>
                @if($k==2)
                    @break
                @endif
                @endforeach
                

                <a href="{{ route('user.list')}}"><button class="btn btn-outline-light btn-sm mt-3">view all</button></a>
            </div>
    </div>
    <div class="col-8">

      @include('appl.pages.bfs.icons.superadmin')
    </div>
  </div>
</div>
@endsection           