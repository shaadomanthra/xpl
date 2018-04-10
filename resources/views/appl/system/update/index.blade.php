@extends('layouts.app')
@section('content')


@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">

    @include('flash::message')  

     <div class="card mb-3 bg-light">
      <div class="card-body ">
        <h1 class="mb-0"><i class="fa fa-bullhorn"></i> Updates
        <span class="float-right">
         @can('create',$update)
            <a href="{{route('update.create')}}">
              <button type="button" class="btn btn-outline-success "><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan 
        </span>
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
                <img class="img-thumbnail  mb-3"src="{{ Gravatar::src($update->user->email, 80) }}"><br>
                <a href="{{ route('profile','@'.\auth::user()->getUsername($update->user_id))}}">{{ \auth::user()->getName($update->user_id)}}</a><br>
                <div>{{ \auth::user()->getDesignation($update->user_id)}}</div>
              </div>
              <div class="col-12 col-md-10">
                <div class="bg-white border p-4">
                <div class="mb-3">

                <div class="mb-3 d-block d-md-none">
                <a href="{{ route('profile','@'.\auth::user()->getUsername($update->user_id))}}">{{ \auth::user()->getName($update->user_id)}}</a>
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
                <a href="{{ route('update.show',$update->id) }}">
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

  <div class="col-md-3 pl-md-0">
      @include('appl.system.snippets.menu')
      
      <div class="list-group  mb-0">
        <a href="#" class="list-group-item list-group-item-action list-group-item-light  disabled" >
          <h2 class="mb-0"><i class="fa fa-sliders"></i> Filters</h2>
        </a>
        <a href="{{ route('update.index',['all'=>true])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('all') ? 'active' : ''  }}">
          All Updates
        </a>
        @if(\Auth::user()->checkRole(['administrator','manager']))
        <a href="{{ route('update.index',['draft'=>true]) }}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('draft') ? 'active' : ''  }}" > Drafts </a>
        <a href="{{ route('update.index',['published'=>true])}}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('published') ? 'active' : ''  }}" > Published</a>
        @endif
        <a href="{{ route('update.index',['feed'=>true])}}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('feed') ? 'active' : ''  }} ">Feeds</a>
        <a href="{{ route('update.index',['milestone'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('milestone') ? 'active' : ''  }} ">Milestones</a>
        </div>
      </div>
      
@endsection


