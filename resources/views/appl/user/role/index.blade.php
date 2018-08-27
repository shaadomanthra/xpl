@extends('layouts.corporate-body')
@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb border">
      <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('team')}}">Team</a></li>
      <li class="breadcrumb-item active">Roles</li>
    </ol>
  </nav>

  @include('flash::message')  
    <div class="card">
      <div class="card-body pb-1">
        <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-user-plus"></i> Roles </a>
            <a href="{{route('role.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 "> <i class="fa fa-plus"></i> New</button>
            </a>
        </nav>

        @if($nodes)
        <div class="dd">
        {!! $nodes !!}
        </div>
        @else
        No Categories defined !
        @endif
     </div>
   </div>

@endsection