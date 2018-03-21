@extends('layouts.app')
@section('content')

@include('appl.system.snippets.breadcrumb')
<div  class="row ">
  <div class="col-md-9">
    @include('flash::message')  
    <div class="card mb-3">
      <div class="card-body ">
        <nav class="navbar navbar-light bg-light justify-content-between mb-3">
          <a class="navbar-brand"><i class="fa fa-flag"></i> Goals </a>
          @can('create',$goal)
            <a href="{{route('goal.create')}}">
              <button type="button" class="btn btn-outline-success my-2 my-sm-2 "><i class="fa fa-plus"></i> New</button>
            </a>
            @endcan
        </nav>

        <div id="search-items" class="p-3 ">
          @if($goals->total()!=0)
            @foreach($goals as $key=>$goal)  

            @if($key != 0)
              <hr>
            @endif

            <div class="row">
              <div class="col-3">
                <div>Target</div>
                <h3>{{ \carbon\carbon::parse($goal->end_at)->format('M d Y') }}</h3><br>
                <a href="{{ route('profile','@'.\auth::user()->getUsername($goal->user_id))}}">{{ \auth::user()->getName($goal->user_id)}}</a><br>
                <small>{{ $goal->updated_at->diffForHumans() }}</small>
              </div>
              <div class="col-6">
                
                <div @if($goal->prime) class="p-2 mb-3" style="background: rgb(226, 243, 255); border-radius: 5px;" @endif>
                <b class="text-primary">{!! $goal->title !!}</b>
                @can('edit',$goal)  
                <a href="{{ route('goal.edit',$goal->id) }}">
                <i class="fa fa-edit"></i>
                </a>
                @endcan
                {!! $goal->content !!}

                </div>

                @if($goal->endnote!=' ')
                <div class="card">
                  <div class="card-title p-2 mb-0">End Note</div>
                  <div class="card-body bg-light pb-1"> {!! $goal->endnote !!}</div>
                </div>
                @endif
              

              </div>
              <div class="col-3">
                <div>Status</div>
                @if($goal->status==0)
                  <span class="text-info"> <i class="fa fa-minus-circle"></i> Open</span>
                @elseif($goal->status==1)
                 <span class="text-success"> <i class="fa fa-check-circle"></i> Completed</span>
                @else
                  <span class="text-secondary"> <i class="fa fa-times-circle"></i> Incomplete</span>
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
    </div>
</div>
@endsection


