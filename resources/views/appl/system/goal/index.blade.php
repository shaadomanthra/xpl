@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('system')}}">System</a></li>
    <li class="breadcrumb-item " >Goals</li>
  </ol>
</nav>

<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  
    <div class="card mb-3 bg-light">
      <div class="card-body ">
        <h1 class="mb-0"><i class="fa fa-flag"></i> Goals
          <span class="float-right">
           @can('create',$goal)
           <a href="{{route('goal.create')}}">
            <button type="button" class="btn btn-outline-success "><i class="fa fa-plus"></i> New</button>
          </a>
          @endcan
        </span>
      </h1>
    </div>
  </div>
  <div class="mb-3">
    <div class=" ">

      <div id="search-items" class=" ">
        @if($goals->total()!=0)
        @foreach($goals as $key=>$goal)  
        <div class="card mb-4">

          <div class="bg-light p-3">
            <div class="row ">
              <div class="col-12 col-md-4">
                <div>Target</div>
                <h3 class="mb-3 mb-md-0">{{ \carbon\carbon::parse($goal->end_at)->format('d M Y') }}</h3>
                
              </div>
              <div class="col-6 col-md-4">
                <div>Status</div>
                @if($goal->status==0)
                <span class="text-secondary"> <i class="fa fa-minus-circle"></i> Open</span>
                @elseif($goal->status==1)
                <span class="text-success"> <i class="fa fa-check-circle"></i> Completed</span>
                @else
                <span class="text-dark"> <i class="fa fa-times-circle"></i> Incomplete</span>
                @endif      
              </div>
              <div class="col-6 col-md-4">
                <a href="{{ route('profile','@'.\auth::user()->getUsername($goal->user_id))}}">{{ \auth::user()->getName($goal->user_id)}}</a><br>
                <small>{{ $goal->updated_at->diffForHumans() }}</small>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="mb-3">
              <b class="text-primary ">{!! $goal->title !!}</b>
              @if($goal->prime)
              <span class="text-success float-right mb-3"><i class="fa fa-star"></i> Prime</span>
              @endif
              @can('edit',$goal)  
              <a href="{{ route('goal.edit',$goal->id) }}">
                <i class="fa fa-edit"></i>
              </a>
              @endcan
              {!! $goal->content !!}

            </div>

            @if($goal->endnote!=' ')
            <div class="bg-light mb-3 p-2 pl-3 border">
              <div class="mb-0"><b>End Note</b></div>
              <div class=""> {!! $goal->endnote !!}</div>
            </div>
            @endif

          </div>

        </div>
        @endforeach      
        @else
        <div class="card card-body bg-light mb-3">
          No Goals listed
        </div>
        @endif
        <div class="mt-4">
          <nav aria-label="Page navigation example ">
            {{$goals->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
          </nav>
        </div>
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
    <a href="{{ route('goal.index',['all'=>true])}}" class="list-group-item list-group-item-action list-group-item-light  {{  request()->get('all') ? 'active' : ''  }}">
      All Goals
    </a>
    <a href="{{ route('goal.index',['prime'=>true])}}" class="list-group-item list-group-item-action list-group-item-light {{  request()->get('prime') ? 'active' : ''  }} ">Prime</a>
    <a href="{{ route('goal.index',['open'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('open') ? 'active' : ''  }} ">Open</a>
    <a href="{{ route('goal.index',['incomplete'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('incomplete') ? 'active' : ''  }} ">Incomplete</a>
    <a href="{{ route('goal.index',['complete'=>true])}}" class="list-group-item list-group-item-action list-group-item-light list-group-item-light {{  request()->get('complete') ? 'active' : ''  }} ">Complete</a>
  </div>
</div>

</div>
</div>
@endsection


