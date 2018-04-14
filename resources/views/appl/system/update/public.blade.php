@extends('layouts.app')
@section('content')


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Updates</li>
  </ol>
</nav>
<div  class="row ">
  <div class="col-md-12">

    @include('flash::message')  

     <div class="card mb-3 bg-light">
      <div class="card-body ">
        <h1 class="mb-0"><i class="fa fa-bullhorn"></i> Updates
        </h1>
      </div>
    </div>
    

    <div class=" mb-1">
      <div class="">
        <div id="search-items">
          @if($updates->total()!=0)
            @foreach($updates as $key=>$update)  
            <div class="row mb-3">
              <div class="col-2 d-none d-md-block">
                <img class="img-thumbnail  mb-3"src="{{ Gravatar::src($update->user->email, 120) }}"><br>
                <a href="{{ route('profile','@'.$update->user->username)}}">{{ $update->user->name }}</a><br>
                <div>{{ $update->user->details->designation }}</div>
              </div>
              <div class="col-12 col-md-10">
                <div class="bg-white border p-4">
                <div class="mb-3">

                <div class="mb-3 d-block d-md-none">
                <a href="{{ route('profile','@'.$update->user->username)}}">{{ $update->user->name }}</a>
                </div>

                @if($update->type==2)
                <div class="text-success rounded mb-3">
                  <h2 class="mb-0"><i class="fa fa-trophy text-success"></i> Milestone</h2>
                </div>
                <h1>
                @endif
                {!! str_limit(strip_tags($update->content),300) !!}
                @if($update->type==2)
                </h1>
                @endif
                </div>
                <a href="{{ route('updates.view',$update->id) }}">
                <button class="btn btn-outline-info btn-sm">Readmore</button>
                </a>
                <span class="float-right">
                <small class="text-secondary">{{ $update->created_at->diffForHumans() }}</small>
              </span>
                @can('edit',$update)
                  <span class="">
                    
                  <button class="btn btn-sm btn-outline-secondary" disabled>
                  @if($update->status==0)
                  Draft
                  @else
                  Published
                  @endif
                  </button>
                  <a href="{{ route('update.edit',$update->id) }}">
                  <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i> edit</button>
                  </a>
                  </span>
                @endcan
                </div>
              </div>
            </div>
            @endforeach      
          @else
          <div class="card card-body bg-light mb-3">
            No Updates listed
          </div>
          @endif
          <nav aria-label="Page navigation example">
            {{$updates->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>

      </div>
    </div>
  </div>
      
@endsection


